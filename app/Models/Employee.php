<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'birth_day',
        'hire_date',
        'position',
        'salary',
        'admin_id',
        'status'
    ];

    /**
     * Lấy thông tin quyền của nhân viên
     */
    public function adminRole()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
} 