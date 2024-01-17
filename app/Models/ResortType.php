<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
    ];

    public function resorts()
    {
        return $this->hasMany(Resort::class, 'resort_type');
    }
}
