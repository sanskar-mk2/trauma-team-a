<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operating extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'year',
        'development_cost',
        'litigation_cost',
        'other_cost',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
