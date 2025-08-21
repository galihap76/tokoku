<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryModel extends Model
{
    protected $table = "categories";
    protected $guarded = [];

    public function sub_categories(): HasMany
    {
        return $this->hasMany(CategorySubMenuModel::class, 'category_id');
    }
}
