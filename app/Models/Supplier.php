<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContactPerson;
use App\Models\Product;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'suppliers';

    protected $fillable = [
        'contact_person_id',
        'company_name',
        'address',
        'next_delivery_date',
        'next_delivery_time',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function contactPerson()
    {
        return $this->belongsTo(ContactPerson::class, 'contact_person_id');

    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

  
}
