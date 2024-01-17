<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ApartmantImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'apartmant_id',
        'image_path',
    ];

    public function apartmant()
    {
        return $this->belongsTo(Resort::class, 'apartmant_id')->withTrashed();
    }
}
