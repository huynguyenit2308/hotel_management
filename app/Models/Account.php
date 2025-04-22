<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $table = 'account';
    protected $fillable = [
        'customer_id',
        'username',
        'password',
        'admin_id',
        'status'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
