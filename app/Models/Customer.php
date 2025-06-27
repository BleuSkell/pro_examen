<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FamilyContactPerson;
use App\Models\FoodPackage;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'customers';

    protected $fillable = [
        'family_contact_persons_id',
        'amount_adults',
        'amount_children',
        'amount_babies',
        'special_wishes',
        'family_name',
        'address',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function familyContactPerson()
    {
        return $this->hasOne(FamilyContactPerson::class);
    }

    public function foodPackages()
    {
        return $this->hasMany(FoodPackage::class);
    }
}
