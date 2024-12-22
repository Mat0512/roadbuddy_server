<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $primaryKey = 'request_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'provider_id',
        'service_provider_id',
        'status',
        'payment_method',
        'request_time',
        'completion_time',
        'location_lat',
        'location_lng',
        'service_id',
    ];

    public $timestamps = false;

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(ProviderService::class, 'service_id');
    }
        
    public function rating()
    {
        return $this->hasOne(ServiceProviderRating::class, 'request_id', 'request_id');
    }
}
