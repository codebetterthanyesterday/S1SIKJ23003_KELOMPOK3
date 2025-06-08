<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'address',
        'profile_picture'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'id_user', 'id_role');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'id_user', 'id_user');
    }

    public function cartGroups()
    {
        return $this->hasMany(CartGroup::class, 'id_user', 'id_user');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id_user');
    }

    public function favoriteStores()
    {
        return $this->belongsToMany(Store::class, 'favorite_stores', 'id_user', 'id_store')->withTimestamps();
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'id_admin', 'id_user');
    }
}
