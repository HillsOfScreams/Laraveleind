<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'sender_id',
        'recipient_id',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
