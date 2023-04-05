<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthAssumption extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'strength_id',
        'year',
        'change',
    ];

    public function strength()
    {
        return $this->belongsTo(Strength::class);
    }
}
