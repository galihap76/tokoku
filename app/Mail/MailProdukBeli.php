<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailProdukBeli extends Mailable
{
    use Queueable, SerializesModels;

    public $nama_customer;
    public $nama_produk;
    public $deskripsi;
    public $total;
    public $order_id;

    /**
     * Create a new message instance.
     */
    public function __construct(
        $nama_customer,
        $nama_produk,
        $deskripsi,
        $total,
        $order_id
    ) {
        $this->nama_customer = $nama_customer;
        $this->nama_produk = $nama_produk;
        $this->deskripsi = $deskripsi;
        $this->total = $total;
        $this->order_id = $order_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembelian Tokoku: Invoice #' . $this->order_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'markdown-produk-beli'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
