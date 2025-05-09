<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'birth_day',
        'registration_date'
    ];

    //Mối quan hệ 1 1 account với customer
    public function account()
    {
        return $this->hasOne(Account::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
}
