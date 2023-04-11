<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded =['id','created_at','updated_at'];
 
    //relacion muchos a uno articles - user
 public function user(){

    return $this->belongsTo(User::class);
    //return $this->belongsTo(User::class)->withTrashed();
}
//relacion uno a muchos articles - comment
public function comments(){

    return $this->hasMany(Comment::class);
}
//relacion uno a muchos category - articles
public function category(){

    return $this->belongsTo(Category::class);
}

//utilizar slug
public function getRouteKeyName(){

    return 'slug';
}
}
