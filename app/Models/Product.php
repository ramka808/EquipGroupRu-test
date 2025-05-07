<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    public function price()
    {
        return $this->hasOne(Price::class, 'id_product', 'id');
    }

    
}
