<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraInfo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'year',
        'expected_competitors',
        'order_of_entry',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
