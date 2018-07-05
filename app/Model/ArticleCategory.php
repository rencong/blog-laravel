<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    //
    protected $table = 'article_category';

    protected $fillable = [
        'title'
    ];
}
