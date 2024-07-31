<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeliProdukModel extends Model
{
    use HasFactory;

    protected $table = "tbl_beli_produk";
    protected $guarded = [];

    public $timestamps = false;

    public function produk(): BelongsTo
    {
        return $this->belongsTo(ProdukModel::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(PembayaranModel::class, 'order_id', 'order_id');
    }
}
