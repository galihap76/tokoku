<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategorySubMenuModel extends Model
{
    protected $table = "sub_categories";
    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class);
    }
}
