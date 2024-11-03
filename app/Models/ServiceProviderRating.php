<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderRating extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_provider_ratings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rating_id';

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
        'driver_id',
        'service_provider_id',
        'rating',
    ];

    /**
     * The relationships between Rating, Driver, and Service Provider.
     * A rating belongs to both a driver and a service provider.
     */

    public $timestamps = false; // Disable timestamps


    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }
}
