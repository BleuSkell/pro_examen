<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RolesFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'roles';

    protected $fillable = [
        'role_name',
        'date_created',
        'date_modified',
        'is_active',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
