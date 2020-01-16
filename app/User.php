<?php

namespace App;

use App\Service\TaggedCache;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Cache
        static::updated(function (User $user) {
            if ($user->isDirty('name')) {
                self::flushCache();
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('role', $role)->exists();
    }

    public function addRole(string $role): User
    {
        $this->roles()->attach(\App\Role::firstOrCreate(['role' => $role]));

        return $this;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    private static function flushCache()
    {
        TaggedCache::users()->flush();
    }
}
