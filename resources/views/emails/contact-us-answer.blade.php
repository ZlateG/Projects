@component('mail::message')
# Contact Us Answer

Here is the answer to your contact us request:

{{ $answer }}

Thank you,
{{ config('app.name') }}
@endcomponent
