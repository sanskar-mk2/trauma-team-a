<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strength extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'market_metric_id',
        'name',
        'is_custom',
    ];

    public function marketMetric()
    {
        return $this->belongsTo(MarketMetric::class);
    }

    public function marketDatas()
    {
        return $this->hasMany(MarketData::class);
    }

    public function growthAssumptions()
    {
        return $this->hasMany(GrowthAssumption::class);
    }

    public function marketVolumes()
    {
        return $this->hasMany(MarketVolume::class);
    }

    public function get_growth_assumption($year)
    {
        return $this->growthAssumptions->where('year', $year)->first()->change ?? null;
    }

    public function get_market_volume($year)
    {
        return $this->marketVolumes->where('year', $year)->first()->volume ?? null;
    }

    public function get_volume($year)
    {
        return $this->marketDatas->where('year', $year)->first()->volume;
    }

    public function get_sales($year)
    {
        return $this->marketDatas->where('year', $year)->first()->sales;
    }

    public function spuGrowth()
    {
        return $this->hasOne(SpuGrowth::class);
    }

    public function actualCog()
    {
        return $this->hasOne(ActualCog::class);
    }
}
