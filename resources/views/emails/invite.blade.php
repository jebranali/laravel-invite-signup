@component('mail::message')
# Introduction

Invitation to signup.

@component('mail::button', ['url' => url('/confirm_invitation/'.$data['invitation_token'])])
Accept Invite
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
