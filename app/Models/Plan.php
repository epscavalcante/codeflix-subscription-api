<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'plan_id';
    }

    protected $fillable = [
        'plan_id',
        'name',
        'description',
    ];
}
