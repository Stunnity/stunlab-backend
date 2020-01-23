<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'ISBN';
    protected $keyType = 'varchar';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ISBN', 'name', 'publisher', 'level_levelName', 'provider_providerName', 'category_categoryName', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    public function likes()
    {
        return $this->hasMany(\App\Like::class);
    }
    public function dislikes()
    {
        return $this->hasMany(\App\Dislike::class);
    }
    public function downloads()
    {
        return $this->hasMany(\App\Download::class);
    }

    public function reads()
    {
        return $this->hasMany(\App\Read::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(\App\Bookmark::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Book::class);
    }
    public function cover()
    {
        return $this->hasOne(\App\Book::class);
    }

    public function book_file()
    {
        return $this->hasOne(\App\Book::class);
    }

    public function provider()
    {
        return $this->belongsTo(\App\Book::class);
    }
    public function level()
    {
        return $this->belongsTo(\App\Book::class);
    }
}
