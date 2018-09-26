<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'category',
        'user_id'
    ];

    protected $dates = ['published_at'];//字符串转为carbon对象

    //set{字段名}Attribute   数据存储的预处理
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    //scope{方法名}  有助于代码重用
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
