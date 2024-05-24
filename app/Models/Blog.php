<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth, DB;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = [
        'like_count',
        'unlike_count',
        'auth_like_count',
        'comment_count'
    ];
 
      /**
     * Get the likes for the blog.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikeCountAttribute()
    {
        return Like::where(['blog_id' => $this->id,'like' => 1])->count();
    }
    
    public function getUnlikeCountAttribute()
    {
        return Like::where(['blog_id' => $this->id,'like' => 0])->count();
    }
    
    public function getAuthLikeCountAttribute()
    {
        return Like::where(['blog_id' => $this->id,'user_id' => Auth::id(),'like' => 1])->count();
    }
 
     /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
 
    public function getuserDataAttribute()
    {
        return User::where('id', $this->user_id)->first();
    }
    
    public function getcommentCountAttribute()
    {
 
         $comment = Comment::groupBy('blog_id')->select('blog_id', DB::raw('count(blog_id) as total_comments'))->where('blog_id', $this->id)->first();   
        if($comment !=null)
            return $comment;
        else 
            return 0;
    }
 
}
