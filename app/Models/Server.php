<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'game_id',
        'node_id',
        'allocation_id',
        'status',
        'memory',
        'disk',
        'cpu',
        'installed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'installed' => 'boolean',
    ];

    /**
     * Get the user that owns the server.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game associated with the server.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the node associated with the server.
     */
    public function node()
    {
        return $this->belongsTo(Node::class);
    }
}