<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MarketVolume extends Component
{
    protected $listeners = ['reevaluate-after-growth-change' => 'reevaluate'];

    public $project;

    public $matrix;

    public $future_matrix;

    public function reevaluate($matrix)
    {
        $this->future_matrix = $matrix;
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

    public function saveMatrix()
    {
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
        $this->emit('reevaluate');
    }

    public function render()
    {
        return view('livewire.market-volume');
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
        $in_millions = number_format($this_year_vol / 1e+6, 2);

        return $in_millions.'M';
    }
}
