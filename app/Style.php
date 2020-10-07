<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [];

    public function beers()
    {
        return $this->hasMany('App\Models\Beer');
    }
    
}