<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class allcpu extends Model
{
    use HasFactory;
    protected $fillable =  ['id', 'Processorbranding', 'Model', 'Cores(Threads)',
    'Base', 'TDP(W)', 'Price(USD)', 'Brand'];
}
