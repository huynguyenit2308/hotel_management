<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'role_name',
        'description',
        'permissions',
        'is_default'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_default' => 'boolean'
    ];

    /**
     * Lấy danh sách nhân viên thuộc quyền này
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'admin_id');
    }

    /**
     * Lấy danh sách tài khoản thuộc quyền này
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'admin_id');
    }
} 