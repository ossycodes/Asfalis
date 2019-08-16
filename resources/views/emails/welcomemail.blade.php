@component('mail::message')
# Dear {{  {{ $user->first_name }} }}, Thank you for signing up.

We built USECURED to help our users curb emergency situation ASAP by reaching out to registered emergency contacts which are assumed to close friends/families of the user.

Your default password is {{ $user->default_password }}

@component('mail::button', ['url' => 'localhost:8000'])
You can read more about us on our website.
@endcomponent

@component('mail::button', ['url' => ''])
Download Mobile App
@endcomponent

All the best<br>
{{ config('app.name') }}
@endcomponent
