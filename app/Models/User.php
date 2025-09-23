<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // daftar siapa saja yang dia follow
    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // daftar siapa saja yang follow dia
    public function follower()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // cek apakah user sudah follow orang lain
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    // cek apakah user lain follow dia
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }
    
    // ambil feed postingan dari user yang di-follow
    public function feed()
    {
        // ambil id semua user yang di-follow
        $followingIds = $this->followings()->pluck('following_id');

        // tambahkan id user sendiri (biar muncul juga postingannya)
        $followingIds->push($this->id);

        // ambil semua post dari user yang di-follow
        return Post::whereIn('user_id', $followingIds)
            ->with(['user', 'media', 'likes', 'comments']) // eager load biar lebih cepat
            ->orderBy('created_at', 'desc');
    }

}
