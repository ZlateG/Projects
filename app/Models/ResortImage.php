<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResortImage extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'resort_id',
        'image_path',
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id')->withTrashed();
    }
}
