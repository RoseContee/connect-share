<?php

namespace App\Http\Controllers\User\Widgets;

use App\Http\Controllers\Controller;
use App\Mail\HolidayApproval as HolidayApprovalMail;
use App\Models\HolidayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HolidayApprovalController extends Controller
{
    public function __construct() {
        view()->share('menu', 'Approval');
        view()->share('submenu', 'HolidayApproval');
    }

    public function index(Request $request) {
        if (!$request['holiday_requests_number']) {
            return redirect()->route('dashboard');
        }
        return view('user.home.widgets.holiday-request.approval.index', [
            'requests' => $request['holiday_requests'],
        ]);
    }

    public function accept(Request $request) {
        $request->validate([
            'request' => ['required'],
        ]);
        $holiday_request = HolidayRequest::with(['latestReply'])
            ->where('id', $request['request'])
            ->where('manager_id', $request->user()->google_id)
            ->where('status', '<>', 'approved')
            ->whereNull('parent')
            ->first();
        $r = $holiday_request['latestReply'] ?? $holiday_request;
        if (!$r || $r['status'] != 'pending') return back();
        $this->acceptRequest($holiday_request);
        return back()->with('success_message', 'User request has been approved.');
    }

    public function acceptFromEmail(Request $request) {
        $holiday_request = $request['holiday_request'];
        $this->acceptRequest($holiday_request);
        return redirect()->route('holiday-approvals')
            ->with('success_message', 'User request has been approved.');
    }

    public function rejectForm(Request $request, $id) {
        $holiday_request = HolidayRequest::with(['latestReply', 'user'])
            ->where('id', $id)
            ->where('manager_id', $request->user()->google_id)
            ->where('status', '<>', 'approved')
            ->whereNull('parent')
            ->first();
        $r = $holiday_request['latestReply'] ?? $holiday_request;
        if (!$r || $r['status'] != 'pending' || !$holiday_request['user']) return back();
        return view('user.home.widgets.holiday-request.approval.reject', [
            'request' => $holiday_request,
        ]);
    }

    public function reject(Request $request, $id) {
        $request->validate([
            'reason' => ['required'],
        ]);
        $holiday_request = HolidayRequest::with(['latestReply'])
            ->where('id', $id)
            ->where('manager_id', $request->user()->google_id)
            ->where('status', '<>', 'approved')
            ->whereNull('parent')
            ->first();
        $r = $holiday_request['latestReply'] ?? $holiday_request;
        if (!$r || $r['status'] != 'pending' || !$holiday_request['user']) return back();
        $this->rejectRequest($holiday_request, $request['reason']);
        return redirect()->route('holiday-approvals')
            ->with('error_message', 'User request has been rejected.');
    }

    public function rejectFromEmail(Request $request) {
        $holiday_request = $request['holiday_request'];
        return redirect()->route('holiday-reject', $holiday_request['id']);
    }

    private function acceptRequest($holiday_request) {
        $r = $holiday_request['latestReply'] ?? $holiday_request;
        $r['status'] = 'approved';
        $r->save();
        $holiday_request['token'] = null;
        $holiday_request->save();
        $this->sendNotification($holiday_request);
    }

    private function rejectRequest($holiday_request, $reason) {
        $r = $holiday_request['latestReply'] ?? $holiday_request;
        $r['status'] = 'rejected';
        $r['reason'] = $reason;
        $r->save();
        $holiday_request['token'] = null;
        $holiday_request->save();
        $this->sendNotification($holiday_request);
    }

    private function sendNotification($holiday_request) {
        try {
            $r = $holiday_request['latestReply'] ?? $holiday_request;
            $holiday_request['note'] = $r['note'];
            $holiday_request['status'] = $r['status'];
            $holiday_request['reason'] = $r['reason'];
            $manager = request()->user();
            $user = $holiday_request['user'];
            Mail::to($user['email'])->send(new HolidayApprovalMail([
                'user' => $user['given_name'].' '.$user['family_name'],
                'manager' => $manager['given_name'].' '.$manager['family_name'],
                'title' => $holiday_request['title'],
                'type' => $holiday_request['type'],
                'period' => $holiday_request['period'],
                'note' => $holiday_request['note'],
                'status' => $holiday_request['status'],
                'reason' => $holiday_request['reason'],
            ]));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
