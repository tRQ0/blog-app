<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $with = ['user'];

    use HasFactory;

    public function user() {
        return $this -> belongsTo(User::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('childComment');
    }

}
