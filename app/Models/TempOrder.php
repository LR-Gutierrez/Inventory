<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
