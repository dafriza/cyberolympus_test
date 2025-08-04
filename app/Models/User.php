<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

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

    const IS_SUPERADMIN = 'superadmin';
    const IS_AGENT = 'agent';
    const IS_CUSTOMER = 'customer';

    /**
     * Get the customer that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id', 'id');
    }

    /**
     * Get the agent that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'id', 'id');
    }

    /**
     * Get all of the customerOrders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    /**
     * Get all of the agentOrder for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentOrder(): HasMany
    {
        return $this->hasMany(Agent::class, 'agent_id', 'id');
    }

    public function isSuperadmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->account_role === self::IS_SUPERADMIN,
        );
    }

    public function isAgent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->account_role === self::IS_AGENT,
        );
    }

    public function isCustomer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->account_role === self::IS_CUSTOMER,
        );
    }

}
