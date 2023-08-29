<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function coupons(){
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
