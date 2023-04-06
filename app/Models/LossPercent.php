<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LossPercent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'loss',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
