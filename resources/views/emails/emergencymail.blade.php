@component('mail::message')
# Emergency Emergency, Emergency

Hi {{ $emergencyContactName }}, {{ $user->name }} is in an emergency situation and currently needs your help
<br>
You are recieving this email because {{ $user->name }} registered you as an emergency contact, to be contacted whenever his/her is in an emergency sistuation.

@component('mail::button', ['url' => ''])
You can read about us on our website.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
