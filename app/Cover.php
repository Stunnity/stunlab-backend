<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    protected $primaryKey = 'book_ISBN';

    public function book(){
        return $this->belongsTo(\App\Book::class);
    }
}
