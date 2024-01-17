@component('mail::message')
# Airplane Ticket Answer

Here is the answer to your airplane ticket request:

{{ $answer }}

Thank you,
{{ config('app.name') }}
@endcomponent
