<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Info extends Component
{
    public $project;

    public $extra_info;

    public $matrix;

    public $future_matrix;

    public $spu_growth_matrix;

    public $current_matrix;

    public $loss;

    public $spu_values;

    public $cogs;

    public $actuals;

    public $operatings;

    public $reevaluate = false;

    public function prepare_operatings()
    {
        $matrix = [];
        foreach ($this->project->xMonthsFromLaunch() as $year) {
            if ($this->project->operatings) {
                $operating = $this->project->operatings->where('year', $year)->first();
                if ($operating) {
                    $matrix[$year] = [
                        'development_cost' => [$operating->development_cost ?? 0, $operating->development_cost ?? 0],
                        'litigation_cost' => [$operating->litigation_cost ?? 0, $operating->litigation_cost ?? 0],
                        'other_cost' => [$operating->other_cost ?? 0, $operating->other_cost ?? 0],
                    ];
                } else {
                    $matrix[$year] = [
                        'development_cost' => [0, 0],
                        'litigation_cost' => [0, 0],
                        'other_cost' => [0, 0],
                    ];
                }
            }
        }

        return $matrix;
    }

    public function get_operating_cost_by_year(string $year)
    {
        return collect($this->operatings[$year])->sum(function ($item) {
            return $item[0];
        });
    }

    public function get_operating_cost_by_type(string $type)
    {
        return collect($this->operatings)->map(function ($item) use ($type) {
            return $item[$type][0];
        })->sum();
    }

    public function get_operating_total()
    {
        $grandTotal = 0;
        foreach ($this->operatings as $costs) {
            foreach ($costs as $costValues) {
                $grandTotal += $costValues[0];
            }
        }

        return $grandTotal;
    }

    public function prepare_current_matrix()
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            $last_sales = $strength->get_sales($this->project->years->last());
            $last_volume = $strength->get_market_volume($this->project->years->last());
            if ($last_volume == null) {
                $last_volume = $strength->get_volume($this->project->years->last());
            }
            if ($last_volume == 0) {
                $last_volume = 1;
            }
            $matrix[$strength->name] = $last_sales / $last_volume;
        }

        return $matrix;
    }

    public function prepare_spu_values()
    {
        $comp_matrix = collect(config('comp_matrix'));
        $spu_values = [];

        $years = $this->project->xMonthsFromLaunch();
        $first_year = $years->first();
        $filtered = $comp_matrix->where('no_of_players', $this->extra_info[$first_year]['expected_competitors'][0]);
        $bwac = $filtered->pluck('bwac')->first();

        foreach ($this->project->marketMetric->strengths as $strength) {
            $loe = $this->current_matrix[$strength->name]
                * (1 + ($this->spu_growth_matrix[$strength->name][0] / 100)) ** $years->count();
            $bwac_of_loe = ($bwac / 100) * $loe;
            foreach ($years as $key => $year) {
                if ($key == 0) {
                    $loop_val = $bwac_of_loe;
                } else {
                    $last_year = $years[$key - 1];
                    $loop_val = $spu_values[$strength->name][$last_year] * (1 + ($this->loss[0] / 100));
                }
                $spu_values[$strength->name][$year] = $loop_val;
            }
        }

        return $spu_values;
    }

    public function prepare_actuals()
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            $actuals = $strength->actualCog->cost ?? 0;
            $matrix[$strength->name] = [$actuals, $actuals];
        }

        return $matrix;
    }

    public function prepare_spu_growth_matrix()
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            if ($strength->spuGrowth) {
                $matrix[$strength->name] = [$strength->spuGrowth->growth, $strength->spuGrowth->growth];
            } else {
                $matrix[$strength->name] = [0, 0];
            }
        }

        return $matrix;
    }

    public function render()
    {
        return view('livewire.info');
    }

    public function save()
    {
        foreach ($this->project->xMonthsFromLaunch() as $year) {
            $expected_competitors_changed = $this->extra_info[$year]['expected_competitors'][0] != $this->extra_info[$year]['expected_competitors'][1];
            $order_of_entry_changed = $this->extra_info[$year]['order_of_entry'][0] != $this->extra_info[$year]['order_of_entry'][1];

            if ($expected_competitors_changed || $order_of_entry_changed) {
                $this->project->extraInfo()->updateOrCreate(
                    ['year' => $year],
                    [
                        'expected_competitors' => $this->extra_info[$year]['expected_competitors'][0],
                        'order_of_entry' => $this->extra_info[$year]['order_of_entry'][0],
                    ]
                );

                $this->extra_info[$year]['expected_competitors'][1] = $this->extra_info[$year]['expected_competitors'][0];
                $this->extra_info[$year]['order_of_entry'][1] = $this->extra_info[$year]['order_of_entry'][0];
            }
        }

        // persist spu_growth_matrix
        foreach ($this->project->marketMetric->strengths as $strength) {
            $growth_changed = $this->spu_growth_matrix[$strength->name][0] != $this->spu_growth_matrix[$strength->name][1];
            if ($growth_changed) {
                $strength->spuGrowth()->updateOrCreate(
                    ['strength_id' => $strength->id],
                    ['growth' => $this->spu_growth_matrix[$strength->name][0]]
                );
                $this->spu_growth_matrix[$strength->name][1] = $this->spu_growth_matrix[$strength->name][0];
            }
        }

        // persist loss
        $loss_changed = $this->loss[0] != $this->loss[1];
        if ($loss_changed) {
            $this->project->lossPercent()->updateOrCreate(
                ['project_id' => $this->project->id],
                ['loss' => $this->loss[0]]
            );
            $this->loss[1] = $this->loss[0];
        }

        // persist cogs
        $cogs_changed = $this->cogs[0] != $this->cogs[1];
        if ($cogs_changed) {
            $this->project->productMetric()->update([
                'cogs' => $this->cogs[0],
            ]);
            $this->cogs[1] = $this->cogs[0];
        }

        // persist actuals
        foreach ($this->project->marketMetric->strengths as $strength) {
            $actuals_changed = $this->actuals[$strength->name][0] != $this->actuals[$strength->name][1];
            if ($actuals_changed) {
                $strength->actualCog()->updateOrCreate(
                    ['strength_id' => $strength->id],
                    ['cost' => $this->actuals[$strength->name][0]]
                );
                $this->actuals[$strength->name][1] = $this->actuals[$strength->name][0];
            }
        }

        // persist operatings
        foreach ($this->project->xMonthsFromLaunch() as $year) {
            $development_cost_changed = $this->operatings[$year]['development_cost'][0] != $this->operatings[$year]['development_cost'][1];
            $litigation_cost_changed = $this->operatings[$year]['litigation_cost'][0] != $this->operatings[$year]['litigation_cost'][1];
            $other_cost_changed = $this->operatings[$year]['other_cost'][0] != $this->operatings[$year]['other_cost'][1];

            if ($development_cost_changed || $litigation_cost_changed || $other_cost_changed) {
                $this->project->operatings()->updateOrCreate(
                    ['year' => $year],
                    [
                        'development_cost' => $this->operatings[$year]['development_cost'][0],
                        'litigation_cost' => $this->operatings[$year]['litigation_cost'][0],
                        'other_cost' => $this->operatings[$year]['other_cost'][0],
                    ]
                );

                $this->operatings[$year]['development_cost'][1] = $this->operatings[$year]['development_cost'][0];
                $this->operatings[$year]['litigation_cost'][1] = $this->operatings[$year]['litigation_cost'][0];
                $this->operatings[$year]['other_cost'][1] = $this->operatings[$year]['other_cost'][0];
            }
        }

        // growth assumption
        foreach ($this->future_matrix as $strength => $years) {
            foreach ($years as $year => $values) {
                if ((int) $values[0] !== $values[1]) {
                    $m_strength = $this->project->marketMetric->strengths->where('name', $strength)->first();
                    $growth_assumption = $m_strength->growthAssumptions->where('year', $year);
                    if ($growth_assumption->count() > 0) {
                        $growth_assumption->first()->update(['change' => $values[0]]);
                    } else {
                        $m_strength->growthAssumptions()->create(['year' => $year, 'change' => $values[0]]);
                    }
                    $this->future_matrix[$strength][$year][1] = $values[0];
                    $this->future_matrix[$strength][$year][2] = 1;
                }
            }
        }

        // volume
        foreach ($this->matrix as $strength => $years) {
            foreach ($years as $year => $values) {
                if ((int) $values[0] !== $values[1]) {
                    $m_strength = $this->project->marketMetric->strengths->where('name', $strength)->first();
                    $market_volume = $m_strength->marketVolumes->where('year', $year);
                    if ($market_volume->count() > 0) {
                        $market_volume->first()->update(['volume' => $values[0]]);
                    } else {
                        $m_strength->marketVolumes()->create(['year' => $year, 'volume' => $values[0]]);
                    }
                    $this->matrix[$strength][$year][1] = $values[0];
                    $this->matrix[$strength][$year][2] = 1;
                }
            }
        }

        $this->reevaluate = !$this->reevaluate;
    }

    public function calculate_cogs_units($strength, $year)
    {
        if ($this->actuals[$strength][0] !== 0) {
            return $this->actuals[$strength][0];
        } else {
            return $this->spu_values[$strength][$year] * ($this->cogs[0] / 100);
        }
    }

    public function calculate_mol_pnl($strength, $year)
    {
        $vol = $this->calculate_vol($year, $strength, false);
        $spu = $this->spu_values[$strength][$year];
        $mol_pnl = $vol * $spu;

        return $mol_pnl;
    }

    public function calculate_cogs($strength, $year)
    {
        $vol = $this->calculate_vol($year, $strength, false);
        $cogs = $this->calculate_cogs_units($strength, $year);
        $cogs_total = $vol * $cogs;

        return $cogs_total;
    }

    public function total_mol_pnl_by_strength($strength)
    {
        $total = 0;
        foreach ($this->project->xMonthsFromLaunch() as $year) {
            $total += $this->calculate_mol_pnl($strength, $year);
        }

        return $total;
    }

    public function total_mol_pnl_by_year($year)
    {
        $total = 0;
        foreach ($this->project->marketMetric->strengths as $strength) {
            $total += $this->calculate_mol_pnl($strength->name, $year);
        }

        return $total;
    }

    public function total_mol_pnl()
    {
        $total = 0;
        foreach ($this->project->marketMetric->strengths as $strength) {
            $total += $this->total_mol_pnl_by_strength($strength->name);
        }

        return $total;
    }

    public function total_cogs_by_strength($strength)
    {
        $total = 0;
        foreach ($this->project->xMonthsFromLaunch() as $year) {
            $total += $this->calculate_cogs($strength, $year);
        }

        return $total;
    }

    public function total_cogs_by_year($year)
    {
        $total = 0;
        foreach ($this->project->marketMetric->strengths as $strength) {
            $total += $this->calculate_cogs($strength->name, $year);
        }

        return $total;
    }

    public function total_cogs()
    {
        $total = 0;
        foreach ($this->project->marketMetric->strengths as $strength) {
            $total += $this->total_cogs_by_strength($strength->name);
        }

        return $total;
    }

    public function gross_profit_by_year($year)
    {
        return $this->total_mol_pnl_by_year($year) - $this->total_cogs_by_year($year);
    }

    public function gross_profit_percent_by_year($year)
    {
        if ($this->total_mol_pnl_by_year($year) == 0) {
            return 0;
        }

        return ($this->gross_profit_by_year($year) / $this->total_mol_pnl_by_year($year)) * 100;
    }

    public function gross_profit_total()
    {
        return $this->total_mol_pnl() - $this->total_cogs();
    }

    public function gross_profit_percent_total()
    {
        if ($this->total_mol_pnl() == 0) {
            return 0;
        }

        return ($this->gross_profit_total() / $this->total_mol_pnl()) * 100;
    }

    public function prepare_future($strengths, $years)
    {
        $matrix = [];
        foreach ($strengths as $strength) {
            $matrix[$strength->name] = [];
            foreach ($years as $year) {
                if ($strength->get_growth_assumption($year) != null) {
                    $matrix[$strength->name][$year] = [$strength->get_growth_assumption($year), $strength->get_growth_assumption($year), 1];
                } else {
                    $matrix[$strength->name][$year] = [0, 0, 0];
                }
            }
        }

        return $matrix;
    }

    public function calculate_perc($year, $strength, $reevaluate)
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $m_strength) {
            $matrix[$m_strength->name] = [];
            foreach ($this->project->years as $m_year) {
                if ($m_strength->get_market_volume($m_year) != null) {
                    $matrix[$m_strength->name][$m_year] = $m_strength->get_market_volume($m_year);
                } else {
                    $matrix[$m_strength->name][$m_year] = $m_strength->get_volume($m_year);
                }
            }
        }

        $this_year = \Carbon\Carbon::parse($year);
        $prev_year = $this_year->subYear();

        if (! $this->project->years->contains($prev_year->format('Y-m-d'))) {
            return '—';
        } else {
            $this_vol = $matrix[$strength][$year];
            $prev_vol = $matrix[$strength][$prev_year->format('Y-m-d')];
            if ($prev_vol == 0) {
                return '—';
            }

            return intval((($this_vol - $prev_vol) / $prev_vol) * 100).'%';
        }
    }

    public function mount()
    {
        $this->extra_info = $this->get_extra_info(
            $this->project->xMonthsFromLaunch(),
            $this->project->productMetric->expected_competitors,
            $this->project->productMetric->order_of_entry
        );

        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            $matrix[$strength->name] = [];
            foreach ($this->project->years as $year) {
                if ($strength->get_market_volume($year) != null) {
                    $matrix[$strength->name][$year] = [$strength->get_market_volume($year), $strength->get_market_volume($year), 1];
                } else {
                    $matrix[$strength->name][$year] = [$strength->get_volume($year), $strength->get_volume($year), 0];
                }
            }
        }

        $this->matrix = $matrix;
        $this->future_matrix = $this->prepare_future($this->project->marketMetric->strengths, $this->project->extra_years);
        $this->spu_growth_matrix = $this->prepare_spu_growth_matrix();
        $this->current_matrix = $this->prepare_current_matrix();

        $loss = $this->project->lossPercent->loss ?? -5;
        $this->loss = [$loss, $loss];

        $cogs = $this->project->productMetric->cogs;
        $this->cogs = [$cogs, $cogs];

        $this->spu_values = $this->prepare_spu_values();

        $this->actuals = $this->prepare_actuals();

        $this->operatings = $this->prepare_operatings();
    }

    public function get_effective_market_share($year)
    {
        $maket_share = $this->get_market_share($year);
        $sales_months = $this->extra_info[$year]['sales_months'];

        return $maket_share * ($sales_months / 12);
    }

    public function get_market_size($strength, $year)
    {
        $effective_market_share = $this->get_effective_market_share($year) / 100;
        $vol = $this->calculate_vol($year, $strength, false);

        return number_format($effective_market_share * $vol / 1e+6, 2).' M';
    }

    public function calculate_vol($year, $strength, $reevaluate)
    {
        $to_get = \Carbon\Carbon::parse($year);
        $starting = \Carbon\Carbon::parse($this->project->extra_years[0]);
        $percent_change = $this->future_matrix[$strength][$starting->format('Y-m-d')][0];
        $last_year_vol = $this->matrix[$strength][$starting->copy()->subYear()->format('Y-m-d')][0];
        $this_year_vol = $last_year_vol + ($last_year_vol * $percent_change) / 100;
        $last_year_vol = $this_year_vol;
        while ($to_get->year != $starting->year) {
            $starting->addYear();
            $percent_change = $this->future_matrix[$strength][$starting->format('Y-m-d')][0];
            $this_year_vol = $last_year_vol + ($last_year_vol * $percent_change) / 100;
            $last_year_vol = $this_year_vol;
        }

        return $this_year_vol;
    }

    public function get_market_share($year)
    {
        $comp = $this->extra_info[$year]['expected_competitors'][0];
        $order = $this->extra_info[$year]['order_of_entry'][0];

        $players = collect(config('comp_matrix'))->where('no_of_players', $comp)->first();

        if (! $players) {
            return 0;
        }

        $share = $players['share_order_of_entry'][$order] ?? 0;

        return $share;
    }

    public function get_extra_info($extra_years, $expected_competitors, $order_of_entry)
    {
        $info = [];
        $extra_years_length = count($extra_years);

        foreach ($extra_years as $index => $year) {
            $new_expected_competitors = null;
            $new_order_of_entry = null;
            $extra_info_model = null;

            $sales_months = 12;
            if ($index == 0) {
                $sales_months = 3;
            } elseif ($index == $extra_years_length - 1) {
                $sales_months = 9;
            }

            $extra_info_model = $this->project->extraInfo->where('year', $year)->first();
            if ($extra_info_model) {
                $new_expected_competitors = $extra_info_model->expected_competitors ?? null;
                $new_order_of_entry = $extra_info_model->order_of_entry ?? null;
            }

            $info[$year] = [
                'sales_months' => $sales_months,
                'expected_competitors' => [$new_expected_competitors ?? $expected_competitors, $new_expected_competitors ?? $expected_competitors],
                'order_of_entry' => [$new_order_of_entry ?? $order_of_entry, $new_order_of_entry ?? $order_of_entry],
            ];
        }

        return $info;
    }
}
