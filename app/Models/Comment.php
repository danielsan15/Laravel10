<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded =['id','created_at','updated_at'];
    //relacion uno a uno inversa profile- user 
    public function user(){

        return $this->belongsTo(User::class);
    }
    //relacion uno a uno inversa profile- user 
    public function article(){

        return $this->belongsTo(Article::class);
    }
}
