@component('mail::message')
# Welcome to USECURED

Dear {{ $emergencycontact->name }}, {{ $user->full_name }} registered you as an emergency contact.
<br>
Hence we would always alert or notify you via EMAIL and SMS whenever {{ $user->name }} is in danger/emergency situation.

@component('mail::button', ['url' => ''])
You can read about us on our website.
@endcomponent


Thanks and all the best,<br>
{{ config('app.name') }}
@endcomponent