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
        'provider_id',
        'service_provider_name',
        'contact_info',
        'location_lat',
        'location_lng',
        'address', 
        'business_permit_no',
        'logo',
        'business_hours_monday',
        'business_hours_tuesday',
        'business_hours_wednesday',
        'business_hours_thursday',
        'business_hours_friday',
        'business_hours_saturday',
        'business_hours_sunday',
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
