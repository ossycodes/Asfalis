@component('mail::message')
# Welcome to Usecured

Hi {{ $user->name }} thank you for joining USecured

@component('mail::button', ['url' => 'localhost:8000'])
Visit Website
@endcomponent

@component('mail::button', ['url' => ''])
Download Mobile App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
