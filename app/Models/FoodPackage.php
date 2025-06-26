<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPackage extends Model
{
    /** @use HasFactory<\Database\Factories\FoodPackageFactory> */
    use HasFactory;

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

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
