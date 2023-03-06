<?php

namespace App\Http\Livewire;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;

class MarketVolume extends Component
{
    public $project;

    public $matrix;

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
    }

    public function saveMatrix()
    {
        foreach ($this->matrix as $strength => $years) {
            foreach ($years as $year => $values) {
                if ((int)$values[0] !== $values[1]) {
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
}
