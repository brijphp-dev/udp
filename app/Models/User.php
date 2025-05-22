<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends \Cartalyst\Sentinel\Users\EloquentUser
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'state',
        'post_code',
        'country',
        'gender',
        'profile_img',
        'user_type',
        'chapter',
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

    /**
     * The Roles that belong to the User.
     */
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function countryDetail()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function stateDetail()
    {
        return $this->belongsTo('App\Models\State', 'state');
    }

    public function paymentDetails()
    {
        return $this->hasMany('App\Models\UserPayment');
    }

    public function chapterDetail()
    {
        return $this->belongsTo('App\Models\Chapter', 'chapter');
    }
}
