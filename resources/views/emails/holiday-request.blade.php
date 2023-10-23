@php
$success_button_style = "
box-sizing: border-box;
font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
border-radius: 4px;
color: #fff;
display: inline-block;
overflow: hidden;
text-decoration: none;
background-color: #48bb78;
border-bottom: 8px solid #48bb78;
border-left: 18px solid #48bb78;
border-right: 18px solid #48bb78;
border-top: 8px solid #48bb78;
";

$error_button_style = "
box-sizing: border-box;
font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial,sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
border-radius: 4px;
color: #fff;
display: inline-block;
overflow: hidden;
text-decoration: none;
background-color: #e53e3e;
border-bottom: 8px solid #e53e3e;
border-left: 18px solid #e53e3e;
border-right: 18px solid #e53e3e;
border-top: 8px solid #e53e3e;
";
@endphp
<x-mail::message>
<h1>Hi {{ $manager }}!</h1>

<p><b>{{ $user }}</b> wants to request a vacation through {{ config('app.name') }}.</p>
<x-mail::panel>
<p><b>Title:</b> {{ $title }}</p>
<p><b>Type:</b> {{ $type }}</p>
@php
$period = explode(' - ', $period);
$start_date = date('m/d/Y', strtotime($period[0]));
$end_date = date('m/d/Y', strtotime($period[1]));
@endphp
<p><b>Period:</b> {{ $start_date.' - '.$end_date }}</p>
<p style="margin-bottom: 0;"><b>Note:</b></p>
<p>{{ $note }}</p>
</x-mail::panel>
<p style="text-align:center;">
<a href="{{ $accept_url }}" style="margin-right:0.25rem; {{ $success_button_style }}">
    Accept
</a>
<a href="{{ $reject_url }}" style="{{ $error_button_style }}">
    Reject
</a>
</p>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
