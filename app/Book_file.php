<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_file extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'book_ISBN';



    public function book(){
        return $this->belongsTo(\App\Book::class);
    }


}
