<?php

namespace App\Http\Controllers\User\Widgets;

use App\Http\Controllers\Controller;
use App\Mail\HolidayRequest as WidgetHolidayRequestMail;
use App\Models\Widgets\HolidayRequest as WidgetHolidayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HolidayRequestController extends Controller
{
    public function __construct() {
        view()->share('menu', 'Request');
        view()->share('submenu', 'WidgetHolidayRequest');
    }

    public function index(Request $request) {
        $holiday_requests = WidgetHolidayRequest::with(['latestReply', 'manager'])
            ->owner($request->user()->google_id)
            ->whereNull('parent')
            ->orderBy('period', 'desc')
            ->get();
        return view('user.home.widgets.holiday-request.index', [
            'requests' => $holiday_requests,
        ]);
    }

    public function send() {
        return view('user.home.widgets.holiday-request.new');
    }

    public function submit(Request $request) {
        $period = explode(' - ', $request['period']);
        $request['start_date'] = $period[0];
        $request['end_date'] = $period[1];
        $request->validate([
            'title' => ['required'],
            'type' => ['required'],
            'period' => ['required'],
            'start_date' => ['dateFormat:m/d/Y'],
            'end_date' => ['dateFormat:m/d/Y', 'after:start_date'],
        ]);
        $start_date = date('Y-m-d', strtotime($request['start_date']));
        $end_date = date('Y-m-d', strtotime($request['end_date']));
        $user = $request->user();
        $holiday_request = $user->holidayRequests()
            ->create([
                'manager_id' => $user['manager_id'],
                'title' => $request['title'],
                'type' => $request['type'],
                'period' => $start_date.' - '.$end_date,
                'note' => $request['note'],
                'status' => 'pending',
                'token' => Str::random(64),
            ]);
        $this->sendNotification($holiday_request);
        return redirect()->route('widget.holiday-requests')
            ->with('success_message', 'New request has been sent.');
    }

    public function resend(Request $request, $id) {
        $holiday_request = WidgetHolidayRequest::with(['latestReply'])
            ->owner($request->user()->google_id)
            ->where('id', $id)
            ->rejected()
            ->first();
        if (!$holiday_request || ($holiday_request['latestReply']['status'] ?? 'rejected') != 'rejected') {
            return back();
        }
        return view('user.home.widgets.holiday-request.resend', [
            'request' => $holiday_request,
        ]);
    }

    public function resubmit(Request $request, $id) {
        $user = $request->user();
        $holiday_request = WidgetHolidayRequest::with(['latestReply', 'manager'])
            ->owner($user['google_id'])
            ->where('id', $id)
            ->rejected()
            ->first();
        if (!$holiday_request || ($holiday_request['latestReply']['status'] ?? 'rejected') != 'rejected') {
            return back();
        }
        $request->validate([
            'note' => ['required'],
        ]);
        $r = $user->holidayRequests()
            ->create([
                'note' => $request['note'],
                'status' => 'pending',
                'parent' => $holiday_request['id'],
            ]);
        $holiday_request['token'] = Str::random(64);
        $holiday_request->save();
        $holiday_request['note'] = $r['note'];
        $this->sendNotification($holiday_request);
        return redirect()->route('widget.holiday-requests')
            ->with('info_message', 'Request has been sent.');
    }

    public function destroy(Request $request) {
        $user = $request->user();
        $holiday_request = $user->holidayRequests()
            ->where('id', $request['request'])
            ->whereNull('parent')
            ->first();
        if (!$holiday_request) return back();
        $holiday_request->delete();
        $user->holidayRequests()
            ->where('parent', $holiday_request['id'])
            ->delete();
        return back()->with('error_message', 'The request has been removed.');
    }

    private function sendNotification($holiday_request) {
        try {
            $user = request()->user();
            $manager = $holiday_request['manager'];
            Mail::to($manager['email'])->send(new WidgetHolidayRequestMail([
                'user' => $user['given_name'].' '.$user['family_name'],
                'manager' => $manager['given_name'].' '.$manager['family_name'],
                'title' => $holiday_request['title'],
                'type' => $holiday_request['type'],
                'period' => $holiday_request['period'],
                'note' => $holiday_request['note'],
                'accept_url' => route('widget.manager-accept-holiday-from-email', $holiday_request['token']),
                'reject_url' => route('widget.manager-reject-holiday-from-email', $holiday_request['token']),
            ]));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
