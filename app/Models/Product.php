<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Adiciona estas linhas para permitir a gravação destes campos:
    protected $fillable = [
        'sku',
        'name',
        'category',
        'price',
        'stock'
    ];


}