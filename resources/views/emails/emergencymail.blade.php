@component('mail::message')
# Emergency Emergency, Emergency

Hi {{ $emergencyContactName }}, {{ $user }} is in an emergency situation and currently located at {{ $userLocation }}
<br>
You are recieving this email because {{ $emergencyContactName }} registered you as an In Case Of Emergency (ICE) Contact.
We have also notified various Emergency agencies.

@component('mail::button', ['url' => ''])
You can read about us on our website.
@endcomponent

Thanks<br>
{{ config('app.name') }}
@endcomponent
