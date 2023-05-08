<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motherboard extends Model
{
    use HasFactory;
    protected $fillable =  ['id', 'socket_cpu', 'modelMotherboard', 'chipset',
    'priceMotherboard', 'maxram', 'ram', 'ramslots', 'link'];
}
