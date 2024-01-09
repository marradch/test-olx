<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    protected $casts = [
        'price' => 'float',
    ];

    public function subscribers()
    {
        return $this->hasMany(AdvertSubscriber::class);
    }
}
