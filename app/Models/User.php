<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'timezone',
        'password',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at'
    ];

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param $createdAt
     * @return string
     */
    public function getCreatedAtAttribute($createdAt)
    {
        if($this->timezone) {
            return (new Carbon($createdAt))->setTimezone($this->timezone)->format('Y-m-d H:i:s');
        }
        return $createdAt;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TodoList::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

}
