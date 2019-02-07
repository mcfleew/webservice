<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid', 'first', 'last', 'street', 'city', 'zip'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}