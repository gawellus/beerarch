<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    protected $fillable = [
        'name',
        'alc',
        'ekst',
        'ibu',
        'description',
        'notes',
        'rating',
        'photo'
    ];

    protected $hidden = [];

    public function brewery()
    {
        return $this->belongsTo('App\Brewery');
    }

    public function style()
    {
        return $this->belongsTo('App\Style');
    }    
}