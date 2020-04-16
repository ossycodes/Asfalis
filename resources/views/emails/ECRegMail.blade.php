@component('mail::message')
# Welcome to ASFALIS

Dear {{ $emergencycontact->name }}, {{ $user->full_name }} registered you as an In Case Of Emergency (ICE) contact.
<br>
Hence we would always alert or notify you via EMAIL and SMS whenever {{ $user->full_name }} is in an emergency situation.

@component('mail::button', ['url' => ''])
You can read more about us on our website.
@endcomponent

Thanks and all the best,<br>
{{ config('app.name') }}
@endcomponent