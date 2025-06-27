<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class FamilyContactPerson extends Model
{
    /** @use HasFactory<\Database\Factories\FamilyMemberFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'family_contact_persons';

    protected $fillable = [
        'first_name',
        'infix',
        'last_name',
        'birth_date',
        'relation',
        'email',
        'phone',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
