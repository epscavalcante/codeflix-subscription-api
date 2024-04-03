<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';
}
