<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(\App\User::class);
    }
    public function books(){
        return $this->belongsToMany(\App\Book::class);
    }

}
