<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'id_user',
        'title',
        'post_text',
        'gambar',
        'id_topik',
    ];

    public function topik()
    {
        return $this->belongsTo(Topik::class, 'id_topik');
    }

    public function replys()
    {
        return $this->hasMany(Reply::class, 'id_post');
    }
}
