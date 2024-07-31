<x-mail::message>
Dear **{{ $nama_customer }}**,

Terima kasih atas pembelian Anda! Kami dengan senang hati menginformasikan bahwa pesanan Anda pada
    invoice **{{ $order_id }}** telah berhasil dilakukan.
    
**Pesanan Produk** : 

- {{ $nama_produk }} ({{ $deskripsi }})


**Total Pembayaran** : 

IDR {{ number_format($total, 0, ',', '.') }}

Terima kasih telah berbelanja di Tokoku. Anda akan selalu menerima pembaruan terkait produk yang telah Anda beli. 
Anda dapat mengunduh pembaruan tersebut kapan saja. Jika ada fitur baru yang tersedia untuk produk Anda, kami akan memberitahukan Anda.

Terima kasih,<br>
Admin, {{ config('app.name') }}
</x-mail::message>