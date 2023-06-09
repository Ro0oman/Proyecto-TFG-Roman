<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;
    protected $fillable =  ['pc_name', 'description', 'cpu', 'motherboard', 'gpu', 'storage', 'psu', 'user'];
}
