<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_pembayaran';
    protected $guarded = [];

    public $timestamps = false;

    public function beli_produk(): BelongsTo
    {
        return $this->belongsTo(BeliProdukModel::class, 'order_id', 'order_id');
    }
}
