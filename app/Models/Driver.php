<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'drivers'; // Replace with your actual table name if it's different.

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'driver_id';

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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'license_number',
        'vehicle',
        'profile_picture',
        'driver_id', // This should be added for the relationship
    ];

    /**
     * The relationship between Driver and User.
     * A driver belongs to a user.
     */

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'driver_id'); // Assuming user_id in the drivers table relates to the id in users table.
    }
}
