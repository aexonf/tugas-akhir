<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];


    // app/Models/Comment.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentComment()
    {
        return $this->belongsTo(Comments::class, 'parent_id');
    }

    public function childComments()
    {
        return $this->hasMany(Comments::class, 'parent_id');
    }




    public function post()
    {
        return $this->belongsTo(Posts::class);
    }
}
