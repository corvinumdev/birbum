@component('mail::message')

# ¡Verifica tu correo electrónico!


Gracias por registrarte en Birbum. Antes de continuar, por favor verifica tu dirección de correo haciendo clic en el botón de abajo:

<span style="font-size: 13px; color: #555; display: block; margin-top: 10px;">
<strong>Nota:</strong> Si al hacer clic en "Verificar correo" el sistema te pide iniciar sesión, simplemente ingresa con tu cuenta y tu correo se verificará automáticamente.
</span>

@component('mail::button', ['url' => $actionUrl])
Verificar correo
@endcomponent

Si no creaste una cuenta, puedes ignorar este mensaje.

Gracias,<br>
El equipo de Birbum
@endcomponent
