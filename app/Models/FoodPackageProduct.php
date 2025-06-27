<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodPackage;
use App\Models\Product;

class FoodPackageProduct extends Model
{
    /** @use HasFactory<\Database\Factories\FoodPackageProductFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'food_package_products';

    protected $fillable = [
        'food_package_id',
        'product_id',
        'amount',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function foodPackage()
    {
        return $this->belongsTo(FoodPackage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
