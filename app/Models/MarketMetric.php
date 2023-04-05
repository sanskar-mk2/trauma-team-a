<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketMetric extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'salt',
        'form',
        'evaluate_by',
        'brand_generic',
        'category',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function productSums()
    {
        return $this->hasMany(ProductSum::class);
    }

    public function strengths()
    {
        return $this->hasMany(Strength::class);
    }
}
