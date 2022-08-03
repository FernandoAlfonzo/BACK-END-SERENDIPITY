@component('mail::message')
![product](https://serendipitydiplomados.com/wp-content/uploads/2020/12/logo.png)
# Validación de correo

Para {{ $demo->user_email }},

Por favor has Clik en el siguiente enlace para validar tu correo

@component('mail::button', ['url' => 'https://serendipity.lendus.app/validateEmail?token='.$demo->urlvalidate])
Validar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent