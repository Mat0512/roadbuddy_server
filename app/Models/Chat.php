<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the sender of the chat message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id'); // Adjust foreign and local keys
    }
    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id'); // Adjust foreign and local keys
    }
    
}
