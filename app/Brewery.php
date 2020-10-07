<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brewery extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function beers()
    {
        return $this->hasMany('App\Models\Beer');
    }
}