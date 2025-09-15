<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;

    protected $table = 'account';
    protected $fillable = [
        'customer_id',
        'username',
        'password',
        'admin_id',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Lấy thông tin khách hàng liên kết với tài khoản
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Lấy thông tin quyền của tài khoản
     */
    public function adminRole()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
