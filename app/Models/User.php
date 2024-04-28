<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'user_id';
    }

    protected $fillable = [
        'user_id',
        'document',
        'first_name',
        'last_name',
        'email',
        'birthdate',
    ];
}
