<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_detail';

    protected $fillable = ['invoice_id', 'service_id', 'quantity', 'amount'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
