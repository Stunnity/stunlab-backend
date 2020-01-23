<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $primaryKey = 'levelName';
    public $incrementing = false;
    protected $guarded = [];


    public function books(){
        return $this->hasMany(\App\Book::class);
    }
}
