<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMetric extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'launch_date',
        'expected_competitors',
        'order_of_entry',
        'cogs',
        'development_cost',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
