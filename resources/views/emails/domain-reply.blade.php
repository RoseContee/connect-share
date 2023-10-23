<x-mail::message>
<h1>Hi {{ $email }}!</h1>

@if ($status == 'active')
<p>Your domain has been allowed to use the {{ config('app.name') }}. You can use now.</p>
<br>
<x-mail::button :url="url('/')" color="success">
Login
</x-mail::button>
@else
<p>Your domain has been blocked for the following reasons:</p>
<x-mail::panel>
<p>{{ $reason }}</p>
</x-mail::panel>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
