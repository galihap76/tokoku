<x-mail::message>
# Verifikasi Email

Klik tombol di bawah ini untuk memverifikasi email Anda :

<x-mail::button :url="$url">
Verifikasi Email
</x-mail::button>

Jika Anda tidak membuat akun ini, tidak perlu melakukan tindakan lebih lanjut.

Salam hangat,<br>
**{{ config('app.name') }}**
</x-mail::message>