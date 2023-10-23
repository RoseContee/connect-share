<x-mail::message>
<h1>Hi, Admin!</h1>

<p>Domain {{ '@'.$domain }} try to use the {{ config('app.name') }}. Please check</p>
<br>
<x-mail::button :url="$url" color="success">
View Request
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
