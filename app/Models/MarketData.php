<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketData extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'strength_id',
        'year',
        'sales',
        'volume',
    ];

    public function strength()
    {
        return $this->belongsTo(Strength::class);
    }
}
