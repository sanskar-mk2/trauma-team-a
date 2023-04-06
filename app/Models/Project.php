<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'years',
        'extra_years',
    ];

    public function marketMetric()
    {
        return $this->hasOne(MarketMetric::class);
    }

    public function productMetric()
    {
        return $this->hasOne(ProductMetric::class);
    }

    public function getYearsAttribute()
    {
        return $this->marketMetric->strengths[0]->marketDatas->pluck('year')->sort();
    }

    public function xMonthsFromLaunch($months = 60)
    {
        $launch = Carbon::create($this->productMetric->launch_date);
        $dates = [];

        $months_left = $months;

        $launch->startOfMonth();

        while ($months_left > 0) {
            $dates[] = $launch->format('Y-01-01');
            $launch->addMonth();
            $months_left--;
        }

        return collect($dates)->unique()->values();
    }

    public function getExtraYearsAttribute()
    {
        $last = Carbon::create($this->years->last());

        $future_last = Carbon::create($this->productMetric->launch_date)
            ->addMonths(60);

        $extra_years = CarbonPeriod::create($last, '1 year', $future_last)->excludeStartDate();

        $formatted = $extra_years->map(function ($date) {
            return $date->format('Y-m-d');
        });

        return collect($formatted);
    }

    public function getExtraYearsAfterLaunchAttribute()
    {
        $launch = Carbon::create($this->productMetric->launch_date);

        $future_last = Carbon::create($this->productMetric->launch_date)
            ->addMonths(60);

        $extra_years = CarbonPeriod::create($launch, '1 year', $future_last)->excludeStartDate();

        $formatted = $extra_years->map(function ($date) {
            return $date->format('Y-m-d');
        });

        return collect($formatted);
    }

    public function getExtraYearsWithLaunchAttribute()
    {
        $launch = Carbon::create($this->productMetric->launch_date);

        $future_last = Carbon::create($this->productMetric->launch_date)
            ->addMonths(60);

        $extra_years = CarbonPeriod::create($launch, '1 year', $future_last);

        $formatted = $extra_years->map(function ($date) {
            return $date->format('Y-m-d');
        });

        return collect($formatted);
    }

    public function extraInfo()
    {
        return $this->hasMany(ExtraInfo::class);
    }
}
