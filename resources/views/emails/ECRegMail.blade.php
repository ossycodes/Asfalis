@component('mail::message')
# Welcome to USECURE

Dear {{ $emergencycontact->name }}, {{ $user->name }} registered you as an emergency contact.

explain what emergency contact means
add a link to the web site

Thanks,<br>
{{ config('app.name') }}
@endcomponent