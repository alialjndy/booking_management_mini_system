<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'phone_number',
        'booking_date',
        'service_type_id',
        'notes',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function service(){
        return $this->belongsTo(ServiceType::class ,'service_type_id');
    }
}
