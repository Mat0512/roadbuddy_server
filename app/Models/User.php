<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Add this

use App\Models\ServiceProvider;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Use HasApiTokens to fix the createToken issue

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'users'; // Replace with your actual table name if it's different.

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'type',
        'username',
        'profile_picture',
        'isSubscribed',
        'isVerified',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class, 'provider_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    // Messages that this user has received
    public function receivedMessages()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

}
