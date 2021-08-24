@component('mail::message')
    # Introduction

    Verify pin code.

    {{$data['pin_code']}}

    Thanks
    {{ config('app.name') }}
@endcomponent
