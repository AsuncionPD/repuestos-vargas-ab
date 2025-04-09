<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'products_categories'; // Asegúrate de que este sea el nombre correcto
    protected $fillable = ['name', 'description'];
}
