<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;


        
    protected $dates = ['deleted_at'];
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($apartment) {
            $apartment->prices->each(function ($prices) {
                $prices->delete();
            });
        });

        static::restoring(function ($apartment) {
            
            $apartment->prices()->withTrashed()->restore();
        });
    }
    
    protected $fillable = [
        'resort_id',
        'apartment_name',
        'apartment_description',
    ];
    

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }
    
    public function prices()
    {
        return $this->hasMany(ApartmantPrice::class, 'apartmant_id');
    }

    public function images()
    {
        return $this->hasMany(ApartmantImage::class, 'apartmant_id');
    }
       

}
