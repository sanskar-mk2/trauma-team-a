<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MarketMetrics extends Component
{
    public $step = 0;

    public $search = '';

    public $searchList = [];

    public $valid_molecule = false;

    public $forms = [];

    public $selected_form = '';

    public $strengths = [];

    public $selected_strengths = [];

    public $brand_generic = '';

    public $category = '';

    public $products = [];

    public $evaluate_by = '';

    public $launch_date = '';

    public $expected_competitors = 0;

    public $order_of_entry = 1;

    public $cogs = 0.00;

    public $development_cost = 0.00;

    public $product_metric_vali = false;

    public $project_id = 0;

    public function vali()
    {
        if ($this->launch_date == '' || $this->expected_competitors == '' || $this->order_of_entry == '' || $this->cogs == '' || $this->development_cost == '') {
            $this->product_metric_vali = false;
        } else {
            $this->product_metric_vali = true;
        }
    }

    public function updatedSearch()
    {
        $this->searching();
    }

    public function searching()
    {
        $body = [
            'name' => $this->search,
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->post('http://127.0.0.1:8000/search_salts');
        $this->searchList = array_column($response->json(), 'salt');
        $this->get_dose_forms();
    }

    public function get_dose_forms()
    {
        $body = [
            'salt' => $this->search,
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/dose_forms');

        if ($response->status() == 404) {
            $this->valid_molecule = false;
        } else {
            $this->forms = $response->json()['forms'];
            $this->valid_molecule = true;
        }
    }

    public function next_step()
    {
        if ($this->step == 2) {
            $this->clean_strengths();
        }
        if ($this->step == 3) {
            $market_data = $this->get_market_data();
            $this->save_to_db($market_data);
        }
        if ($this->step == 4) {
            $this->save_product_metric();
        }
        $this->step++;
    }

    public function save_product_metric()
    {
        $project = Project::find($this->project_id);
        $project->productMetric()->create([
            'launch_date' => $this->launch_date,
            'expected_competitors' => $this->expected_competitors,
            'order_of_entry' => $this->order_of_entry,
            'cogs' => $this->cogs,
            'development_cost' => $this->development_cost,
        ]);
    }

    public function save_to_db($md)
    {
        $project = Project::create([
            'name' => $this->search,
        ]);

        $this->project_id = $project->id;

        $mm = $project->marketMetric()->create([
            'salt' => $this->search,
            'form' => $this->selected_form,
            'brand_generic' => $this->brand_generic,
            'category' => $this->category,
            'evaluate_by' => $this->evaluate_by,
        ]);

        $str_models = [];

        foreach ($this->selected_strengths as $strength) {
            $sm = $mm->strengths()->create([
                'name' => $strength,
                'is_custom' => false,
            ]);

            $str_models[$strength] = $sm;
        }

        foreach ($this->products as $product) {
            $mm->productSums()->create([
                'name' => $product,
            ]);
        }

        foreach ($md['market_data'] as $strength => $data) {
            $sm = $str_models[$strength];
            foreach ($md['years'] as $year) {
                $sales = $data["{$year}_Sales"];
                $volume = $data["{$year}_{$this->evaluate_by}"];
                $year_dt = "{$year}-01-01";
                $sm->marketDatas()->create([
                    'year' => $year_dt,
                    'sales' => $sales,
                    'volume' => $volume,
                ]);
            }
        }
    }

    public function get_market_data()
    {
        $body = [
            'salt' => $this->search,
            'forms' => [$this->selected_form],
            'strengths' => $this->selected_strengths,
            'evaluate_by' => $this->evaluate_by,
        ];

        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/market_data');

        return $response->json();
    }

    public function clean_strengths()
    {
        $this->selected_strengths = array_map(function ($s) {
            return str_replace('-', ' ', $s);
        }, $this->selected_strengths);
    }

    public function previous_step()
    {
        $this->step--;
    }

    public function get_strengths()
    {
        $this->strengths = [];
        $this->selected_strengths = [];
        $this->brand_generic = '';
        $this->category = '';
        $this->products = [];
        $this->evaluate_by = '';

        $body = [
            'salt' => $this->search,
            'forms' => [$this->selected_form],
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/strengths');

        $this->strengths = $response->json()['strengths'];
    }

    public function autofill()
    {
        if (! count($this->selected_strengths)) {
            $this->brand_generic = '';
            $this->category = '';
            $this->products = [];

            return;
        }

        $body = [
            'salt' => $this->search,
            'forms' => [$this->selected_form],
            'strengths' => $this->selected_strengths,
            'evaluate_by' => $this->evaluate_by,
        ];

        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/autofill');

        $this->brand_generic = $response->json()['market_type'];
        $this->category = $response->json()['category'];
        $this->products = $response->json()['products'];
        $this->evaluate_by = $response->json()['evaluate_by'];
    }

    public function mount()
    {
        $this->searching();
    }

    public function render()
    {
        return view('livewire.market-metrics');
    }
}
