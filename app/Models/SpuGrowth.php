<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpuGrowth extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'strength_id',
        'growth',
    ];

    public function strength()
    {
        return $this->belongsTo(Strength::class);
    }
}
