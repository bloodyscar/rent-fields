<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lapangan extends Model
{
    // protected $casts = [
    //     'price' => MoneyCast::class,
    // ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
