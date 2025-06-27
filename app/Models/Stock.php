<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'stocks';

    protected $fillable = [
        'product_id',
        'amount',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
