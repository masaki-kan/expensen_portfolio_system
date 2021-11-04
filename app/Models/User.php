<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable;
    use HasPushSubscriptions;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tel',
        'sex',
        'service',
        'email',
        'password',
        'image',
        'md5',
        'flag',
        'master_flag',
        'login',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function trains()
    {
        return $this->hasMany(Train::class);
    }

    public function realtrains()
    {
        return $this->hasMany(Realtrain::class);
    }

    public function pitapas()
    {
        return $this->hasMany(Pitapa::class);
    }

    public function relationtrains()
    {
        return $this->hasMany(Relationtrain::class);
    }
}
