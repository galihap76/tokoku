<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukModel extends Model
{
    use HasFactory;

    protected $table = "tbl_produk";
    protected $guarded = [];

    public function produk_terjual(): HasMany
    {
        return $this->hasMany(ProdukTerjualModel::class, 'produk_id');
    }

    public function produk_beli(): HasMany
    {
        return $this->hasMany(BeliProdukModel::class, 'produk_id');
    }
}
