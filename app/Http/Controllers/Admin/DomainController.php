<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Widgets;
use App\Http\Controllers\Controller;
use App\Mail\DomainReply;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DomainController extends Controller
{
    protected string $menu = 'Domains';

    public function __construct() {
        view()->share('menu', $this->menu);
    }

    public function index(Request $request) {
        $type = ucfirst(strtolower($request['type']));
        if (!in_array($type, ['Installed', 'Allowed', 'Blocked', 'Request'])) {
            $type = 'Installed';
        }
        if ($type == 'Installed') {
            $domains = Domain::with(['users'])
                ->installed()
                ->orderBy('domain')
                ->get();
        } else if ($type == 'Allowed') {
            $domains = Domain::with(['users'])
                ->active()
                ->orderBy('domain')
                ->get();
        } else if ($type == 'Blocked') {
            $domains = Domain::with(['users'])
                ->blocked()
                ->orderBy('domain')
                ->get();
        } else {
            $domains = Domain::pending()
                ->orderBy('domain')
                ->get();
        }
        $widgets = Widgets::getAllWidgets();
        return view('admin.domains.index', [
            'type' => $type,
            'domains' => $domains,
            'widgets' => $widgets,
        ]);
    }

    public function create() {
        $widgets = Widgets::getAllWidgets();
        return view('admin.domains.add', [
            'type' => 'Allowed',
            'widgets' => $widgets,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'domain' => ['required', 'unique:domains'],
            'banner_image' => ['nullable', 'image'],
            'widgets' => ['nullable', 'array'],
            'widgets.*' => ['nullable', Widgets::getWidgetsRule()],
            'notify_to' => ['nullable', 'email'],
        ], [
            'widgets.*.*' => 'The selected widget is invalid.',
        ]);
        $domain = Domain::create([
            'domain' => $request['domain'],
            'hide_banner' => !empty($request['hide_banner']),
            'widgets' => implode(',', $request['widgets'] ?? []),
            'notify_to' => $request['notify_to'],
            'status' => 'active',
        ]);
        if ($request->hasFile('banner_image')) {
            $domain['banner_image'] = 'uploads/'.$request->file('banner_image')->store('banner');
            $domain->save();
        }
        if ($domain['notify_to']) {
            try {
                Mail::to($domain['notify_to'])->send(new DomainReply([
                    'email' => $domain['notify_to'],
                    'status' => 'active',
                ]));
                return redirect()->route('admin.domains.index', ['type' => 'Allowed'])
                    ->with('success_message', 'Notification has been sent.');
            } catch (\Exception $exception) {
            }
            return redirect()->route('admin.domains.index', ['type' => 'Allowed'])
                ->with('info_message', 'Notification has not been sent.');
        }
        return redirect()->route('admin.domains.index', ['type' => 'Allowed'])
            ->with('success_message', 'New domain has been added.');
    }

    public function editRequest(string $token) {
        if ($domain = Domain::pending()->where('token', $token)->first()) {
            return redirect()->route('admin.domains.edit', $domain['id']);
        }
        $domain['token'] = null;
        $domain->save();
        return redirect()->route('admin.domains.index', ['type' => 'Request']);
    }

    public function edit($id) {
        $domain = Domain::find($id);
        if (!$domain) return back();
        $widgets = Widgets::getAllWidgets();
        return view('admin.domains.add', [
            'widgets' => $widgets,
            'domain' => $domain,
        ]);
    }

    public function update(Request $request, $id) {
        $domain = Domain::find($id);
        if (!$domain) return back();
        $request->validate([
            'banner_image' => ['nullable', 'image'],
            'widgets' => ['nullable', 'array'],
            'widgets.*' => ['nullable', Widgets::getWidgetsRule()],
            'notify_to' => ['nullable', 'email'],
            'status' => ['in:1,0'],
            'reason' => ['required_if:status,0'],
        ], [
            'widgets.*.*' => 'The selected widget is invalid.',
            'reason.required_if' => 'The reason field is required.',
        ]);
        $old_status = $domain['status'];
        $domain['hide_banner'] = !empty($request['hide_banner']);
        if ($request->hasFile('banner_image')) {
            if (getPath($domain['banner_image'])) {
                unlink(public_path($domain['banner_image']));
            }
            $domain['banner_image'] = 'uploads/'.$request->file('banner_image')->store('banner');
        }
        $domain['widgets'] = implode(',', $request['widgets'] ?? []);
        if (!$domain['requested_email']) {
            $domain['notify_to'] = $request['notify_to'];
        }
        $domain['status'] = !empty($request['status']) ? 'active' : 'blocked';
        $domain['reason'] = $request['reason'];
        $domain->save();
        $notify_to = $domain['requested_email'] ?: $domain['notify_to'];
        if ($old_status != $domain['status'] && $notify_to) {
            try {
                Mail::to($notify_to)->send(new DomainReply([
                    'email' => $notify_to,
                    'status' => $domain['status'],
                    'reason' => $domain['reason'],
                ]));
            } catch (\Exception $exception) {
            }
        }
        return redirect()->route('admin.domains.edit', $id)
            ->with('info_message', 'Domain has been updated.');
    }
}
