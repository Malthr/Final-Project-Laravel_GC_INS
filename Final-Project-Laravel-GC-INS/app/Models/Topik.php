<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    protected $table = 'topiks';

    protected $fillable = [
        'topik',
    ];

    public function postingan()
    {
        return $this->hasMany(Post::class, 'id_topik');
    }
}
