<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // public $table = 'reports';
    protected $fillable = ['user_username', 'message','seen'];


    public function user(){

        return  $this->hasMany(\App\User::class);
    }
}
