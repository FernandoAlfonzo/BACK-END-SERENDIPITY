@component('mail::message')
![product](https://serendipitydiplomados.com/wp-content/uploads/2020/12/logo.png)
# Recuperación de contraseña

Para {{ $demo->user_email }},

Por favor has Clik en el siguiente enlace

@component('mail::button', ['url' => 'https://serendipity.lendus.app/resetPassword?token='.$demo->urlrecuperate])
Recuperar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent