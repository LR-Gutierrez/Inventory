<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }
    /* public function businessManager()
    {
        return $this->belongsTo(BusinessManager::class, '');
    } */
}
