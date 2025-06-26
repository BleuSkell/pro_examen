<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\FoodPackage;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_categories_id',
        'suppliers_id',
        'product_name',
        'barcode',
        'amount',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function foodPackages()
    {
        return $this->belongsTo(FoodPackage::class);
    }
}
