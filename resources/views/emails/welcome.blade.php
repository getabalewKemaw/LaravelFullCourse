@component('mail::message')
# Welcome!

Thanks for joining our app, we’re happy to have you 🎉

@component('mail::button', ['url' => config('app.url')])
Visit Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
