<x-mail::message>
<h1>Hi {{ $user }}!</h1>

<p>Your holiday request has been {{ $status }} by <b>{{ $manager }}</b> through {{ config('app.name') }}.</p>
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
@if ($status == 'rejected')
<p style="margin-bottom: 0;"><b>Reject Reason:</b></p>
<p>{{ $reason }}</p>
@endif
</x-mail::panel>
<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
