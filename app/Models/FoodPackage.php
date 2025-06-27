<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\FoodPackageProduct;

class FoodPackage extends Model
{
    /** @use HasFactory<\Database\Factories\FoodPackageFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'food_packages';

    protected $fillable = [
        'customers_id',
        'products_id',
        'package_number',
        'date_composed',
        'date_issued',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function foodPackageProducts()
    {
        return $this->hasMany(FoodPackageProduct::class);
    }
}
