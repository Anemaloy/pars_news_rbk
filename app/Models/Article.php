<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasOne('App\Models\ArticleCategory', 'id', 'category_id');
    }
}
