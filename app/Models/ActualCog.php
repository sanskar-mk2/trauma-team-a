<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualCog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'strength_id',
        'cost',
    ];

    public function strength()
    {
        return $this->belongsTo(Strength::class);
    }
}
