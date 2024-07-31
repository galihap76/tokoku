<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukTerjualModel extends Model
{
    use HasFactory;
    protected $table = "tbl_produk_terjual";

    public function produk(): BelongsTo
    {
        return $this->belongsTo(ProdukModel::class);
    }
}
