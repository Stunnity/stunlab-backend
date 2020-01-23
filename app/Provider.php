<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    protected $primaryKey = 'providerName';
    public $incrementing = false;
    protected $guarded = [];


    public function books(){
        return $this->hasMany(\App\Book::class);
    }

    public function administrator(){
        return $this->hasOne(\App\Administrator::class);
    }
}
