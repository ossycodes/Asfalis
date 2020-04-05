@component('mail::message')
# Dear {{ $user->first_name }}, Thank you for signing up.

We built ASFALIS to help our users curb emergency situation ASAP by reaching out to registered In Case Of Emergency (ICE) Contacts which are assumed to be families and close friends of the user.
We also notify various Emergency agencies....

Your default password is {{ $user->default_password }}

@component('mail::button', ['url' => 'localhost:8000'])
You can read more about us on our website.
@endcomponent

@component('mail::button', ['url' => ''])
Download Our Mobile App:
@endcomponent

All the best<br>
{{ config('app.name') }}
@endcomponent
