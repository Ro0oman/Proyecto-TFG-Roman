<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafica extends Model
{
    use HasFactory;
    protected $fillable =  ['id', 'modelGPU', 'launch', 'priceGPU',
    'memory', 'TDPGPU', 'brandGPU'];
}
