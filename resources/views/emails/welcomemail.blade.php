@component('mail::message')
# Thank you for signing up, {{ $user->name }}

We build USECURED to help our users curb emergency situation ASAP by reaching out to registered emergency contacts which are assumed to close friends/families of the user.

@component('mail::button', ['url' => 'localhost:8000'])
You can read more about us on our website.
@endcomponent

@component('mail::button', ['url' => ''])
Download Mobile App
@endcomponent

All the best<br>
{{ config('app.name') }}
@endcomponent
