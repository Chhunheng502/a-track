@component('mail::message')
# You are invited!
 
Please click on the link below to join the class.
 
@component('mail::button', ['url' => $url])
Join Now
@endcomponent
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent