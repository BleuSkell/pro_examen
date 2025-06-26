<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_name',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
