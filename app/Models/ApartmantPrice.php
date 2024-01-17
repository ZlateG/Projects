<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApartmantPrice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'apartmant_id',
        'price',
        'start_date',
        'end_date',
    ];

    
    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartmant_id');
    }


}
