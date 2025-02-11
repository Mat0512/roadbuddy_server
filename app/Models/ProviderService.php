<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    use HasFactory;

    protected $table = 'service_provider_services';

    protected $primaryKey = 'provider_service_id';

    public $timestamps = false;

    protected $fillable = [
        'provider_id',
        'service_name',
        'price',
        'description',
        'image',
        'status',
        ''
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }

    public function serviceRequest()
    {
        return $this->hasMany(ServiceRequest::class, 'service_id');
    }

    
}
