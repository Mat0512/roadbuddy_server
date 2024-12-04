<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_providers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'provider_id';

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
        'name',
        'contact_info',
        'location_lat',
        'location_lng',
        'provider_id', // Added for the relationship
    ];


    public $timestamps = false;

    /**
     * The relationship between Provider and User.
     * A provider belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
    
    public function services()
    {
        return $this->hasMany(ProviderService::class, 'provider_id');
    }
    
}
