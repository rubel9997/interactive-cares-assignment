<x-mail::message>
Email Verification


<x-mail::button :url="$url">
Verification Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
