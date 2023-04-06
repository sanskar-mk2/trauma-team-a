<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Info extends Component
{
    public $project;

    public $extra_info;

    public $matrix;

    public $future_matrix;

    public function render()
    {
        return view('livewire.info');
    }

    public function save()
    {
        // if ($this->project_name[0] !== $this->project_name[1]) {
        //     $this->project->update(['name' => $this->project_name[0]]);
        //     $this->project_name[1] = $this->project_name[0];
        // }
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
        $vol = $this->calculate_vol($year, $strength);

        return number_format($effective_market_share * $vol / 1e+6, 2).' M';
    }

    public function calculate_vol($year, $strength)
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
