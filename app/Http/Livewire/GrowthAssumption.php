<?php

namespace App\Http\Livewire;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;

class GrowthAssumption extends Component
{
    public $project;

    public $matrix;

    public $reevaluate = false;

    protected $listeners = ['reevaluate' => 'reevaluate'];

    public function reevaluate()
    {
        Debugbar::info('reevaluate');
        $this->reevaluate = ! $this->reevaluate;
    }

    public function mount()
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            $matrix[$strength->name] = [];
            foreach ($this->project->extra_years as $year) {
                if ($strength->get_growth_assumption($year) != null) {
                    $matrix[$strength->name][$year] = [$strength->get_growth_assumption($year), $strength->get_growth_assumption($year), 1];
                } else {
                    $matrix[$strength->name][$year] = [0, 0, 0];
                }
            }
        }
        $this->matrix = $matrix;
    }

    public function saveMatrix()
    {
        foreach ($this->matrix as $strength => $years) {
            foreach ($years as $year => $values) {
                if ((int)$values[0] !== $values[1]) {
                    $m_strength = $this->project->marketMetric->strengths->where('name', $strength)->first();
                    $growth_assumption = $m_strength->growthAssumptions->where('year', $year);
                    if ($growth_assumption->count() > 0) {
                        $growth_assumption->first()->update(['change' => $values[0]]);
                    } else {
                        $m_strength->growthAssumptions()->create(['year' => $year, 'change' => $values[0]]);
                    }
                    $this->matrix[$strength][$year][1] = $values[0];
                    $this->matrix[$strength][$year][2] = 1;
                }
            }
        }
    }

    public function calculate_perc($year, $strength, $reevaluate)
    {
        Debugbar::info($reevaluate);
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

        if (!$this->project->years->contains($prev_year->format('Y-m-d'))) {
            return '—';
        } else {
            $this_vol = $matrix[$strength][$year];
            $prev_vol = $matrix[$strength][$prev_year->format('Y-m-d')];
            return intval((($this_vol - $prev_vol) / $prev_vol) * 100) . '%';
        }
    }

    public function render()
    {
        return view('livewire.growth-assumption');
    }
}
