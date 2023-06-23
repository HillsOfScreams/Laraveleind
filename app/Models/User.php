<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\FriendRequest;
use App\Models\FriendModel;


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
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // public function friends()
    // {
    //     return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
    //         ->withPivot('status')
    //         ->withTimestamps();
    // }

    public function friendModels()
    {
        return $this->hasMany(FriendModel::class);
    }
    /**
     * Get the friends of the user.
     */
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friend_models', 'user_id', 'friend_id');
    }

    /**
     * Check if the user is friends with the given user.
     *
     * @param int $userId
     * @return bool
     */
    public function isFriendWith(int $userId): bool
    {
        return $this->friends()->where('users.id', $userId)->exists();
    }

    /**
     * Get the friend requests sent by the user.
     */
    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    /**
     * Check if the user has a friend request from the given user.
     *
     * @param int $userId
     * @return bool
     */
    public function hasFriendRequestFrom(int $userId): bool
    {
        return $this->sentFriendRequests()->where('recipient_id', $userId)->exists();
    }

    /**
     * Send a friend request to the given user.
     *
     * @param int $friendId
     * @return FriendRequest
     */
    public function sendFriendRequest(int $friendId): FriendRequest
    {
        return $this->sentFriendRequests()->create([
            'recipient_id' => $friendId,
            'status' => 'pending',
        ]);
    }

    /**
     * Accept a friend request from the given user.
     *
     * @param int $friendId
     * @return void
     */
    public function acceptFriendRequest(int $friendId)
    {
        $friendRequest = $this->receivedFriendRequests()
            ->where('sender_id', $friendId)
            ->first();

        if ($friendRequest) {
            $friendRequest->update(['status' => 'accepted']);
            $this->friends()->attach($friendId);
        }
    }
}
