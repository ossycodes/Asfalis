@component('mail::message')
# Emegency

Hi {{ $emergencyContactName }}, {{ $user->name }} is in an emergency situation and currently needs your help

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
