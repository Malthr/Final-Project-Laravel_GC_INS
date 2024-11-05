<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replys';

    protected $fillable = [
        'id_user',
        'id_post',
        'id_parent',
        'reply',
        'gambar',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    // Relasi dengan Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    public function children() {
        return $this->hasMany(Reply::class, 'id_parent'); // asumsi parent_id adalah kolom untuk relasi balasan
    }
    
}
