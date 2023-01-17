<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MarketMetriks extends Component
{
    public $searchList = [];
    public $valid_molecule = false;
    public $forms = [];
    public $search = '';
    public $selected_form = '';
    public $strengths = [];
    public $selected_strengths = [];
    public $brand_generic = "";
    public $category = "";
    public $products = [];
    public $evaluate_by = "";
    public $units_eaches = "";

    public $launch_date = "";
    public $expected_competitors = 0;
    public $order_of_entry = 1;
    public $cogs = 0.00;
    public $development_cost = 0.00;



    public function searching()
    {
        $body = [
            'name' => $this->search,
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/search_salts');
        $this->searchList = array_column($response->json(), 'salt');
    }

    public function get_strengths()
    {
        $body = [
            'salt' => $this->search,
            'forms' => [$this->selected_form],
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/strengths');

        $this->strengths = $response->json()['strengths'];
    }

    public function get_dose_forms()
    {
        $body = [
            'salt' => $this->search,
        ];
        $response = Http::withBody(json_encode($body), 'application/json')
            ->get('http://127.0.0.1:8000/dose_forms');

        if ($response->status() == 404) {
            $this->forms = [];
            $this->selected_form = '';
            $this->strengths = [];
            $this->selected_strengths = [];
            $this->brand_generic = "";
            $this->category = "";
            $this->products = [];
            $this->evaluate_by = "";
            return;
        } else {
            $this->forms = $response->json()['forms'];
            $this->valid_molecule = true;

            $this->selected_strengths = [];
            $this->get_strengths();
        }
    }

    public function autofill()
    {
        if (!count($this->selected_strengths)) {
            $this->brand_generic = "";
            $this->category = "";
            $this->products = [];
            return;
        }

        $body = [
            'salt' => $this->search,
            'forms' => [$this->selected_form],
            'strengths' => $this->selected_strengths,
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

    public function updatedSearch()
    {
        $this->searching();
    }

    public function render()
    {
        return view('livewire.market-metriks');
    }
}
