<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';

    protected $guarded = ['updated_at'];

    protected $appends = ['customer_name'];

    /**
     * Get the user that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function customerName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->full_name,
        );
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function() {
                $parts = array_filter([
                $this->address,
                $this->kelurahan,
                $this->kecamatan,
                $this->kota,
                $this->provinsi,
                $this->kode_pos,
            ]);

            return count($parts) ? implode(', ', $parts) : 'Alamat tidak tersedia';
            },
        );
    }

    public function scopeUserOrderByAscWithFirstName(Builder $customer) : void {
        $customer->join('users', 'customer.id', '=', 'users.id')
        ->orderBy('users.first_name', 'asc')
        ->select('customer.*');
    }
}
