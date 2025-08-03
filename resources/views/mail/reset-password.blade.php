<x-mail::message>
# Reset Kata Sandi

Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tombol di bawah ini untuk melanjutkan proses reset kata sandi :

<x-mail::button :url="$url">
Reset Kata Sandi
</x-mail::button>

Jika Anda tidak meminta reset kata sandi, tidak perlu melakukan tindakan lebih lanjut.

Salam hangat,<br>
**{{ config('app.name') }}**
</x-mail::message>