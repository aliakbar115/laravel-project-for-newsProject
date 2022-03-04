<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'summary', 'body', 'view_count', 'image', 'status', 'user_id', 'category_id'];
    protected $casts=[
        'image'=>'array',
    ];
    public function comments()
    {
        return $this->morphMany("App\Models\Comment", "commentable")->where('parent_id','=', 0);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
