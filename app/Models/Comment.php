<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = [
        'user_name',
        'blog_data'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
   
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    
    public function getuserNameAttribute()
    {
        return User::where('id', $this->user_id)->select('name')->first();
    }
    
    public function getblogDataAttribute()
    {       
        return Blog::where('id', $this->blog_id)->select('title','description')->first();
    }

}
