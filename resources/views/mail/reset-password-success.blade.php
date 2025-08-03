<x-mail::message>
Dear **{{ $user }}**,

Kami ingin memberitahukan bahwa password akun Anda di {{ env('APP_NAME') }} telah berhasil diperbarui pada **{{ now()->format('d M Y, H:i') }} WIB**.
    
Jika Anda merasa tidak melakukan perubahan ini, harap segera hubungi Admin agar dapat membantu Anda mengamankan akun Anda.
    
✅ Tips:
- Jangan bagikan password Anda kepada siapa pun.
- Gunakan password yang unik dan sulit ditebak.

Salam hangat,<br>
**{{ config('app.name') }}**
</x-mail::message>