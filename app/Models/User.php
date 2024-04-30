<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use Sluggable;

    public function totalPostViews()
    {
        return $this->posts()->sum('views');
    }




    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $attributes = [
        'images' => '',
        'role' => 'admin',
     ];

    protected $fillable = [
        'name',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'role',
        'alamat',
        'password',
        'images',
        'status',
        'post_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comment()
    {
        return $this->hasMany(Comments::class);
    }

    public function postSaves()
    {
        return $this->hasMany(PostSaves::class);
    }

}
