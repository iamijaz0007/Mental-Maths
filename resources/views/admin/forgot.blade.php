@component('mail::message')
# Introduction

Hello {{ $user->name }},

@component('mail::button', ['url' => url('reset', ['token' => $user->remember_token])])
Reset Your Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
