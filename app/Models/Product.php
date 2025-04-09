<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_code', 'category_id', 'name', 'description', 'purchase_price',
        'price', 'location', 'units', 'image'
    ];

    // Relación con categorías
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}


