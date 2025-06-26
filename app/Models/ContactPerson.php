<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class ContactPerson extends Model
{
    /** @use HasFactory<\Database\Factories\ContactPersonFactory> */
    use HasFactory;

    protected $table = 'contact_persons';

    protected $fillable = [
        'first_name',
        'infix',
        'last_name',
        'email',
        'phone',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
