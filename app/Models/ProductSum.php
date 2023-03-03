<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSum extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'market_metric_id',
        'name',
    ];

    public function marketMetric()
    {
        return $this->belongsTo(MarketMetric::class);
    }
}
