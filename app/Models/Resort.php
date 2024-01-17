<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resort extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    
    public static function boot()
    {
        
        parent::boot();
        
        static::restoring(function ($resort) {
            $resort->apartments()->withTrashed()->restore();
            $resort->images()->withTrashed()->restore();
        });

        static::deleting(function ($resort) {
            $resort->apartments()->delete();
            $resort->images()->delete();
        });
    }


    protected $fillable = [
        'city_id',
        'resort_type',
        'resort_name',
        'resort_description',
        'location',
        'priority',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function resortType()
    {
        return $this->belongsTo(ResortType::class, 'resort_type');
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->through('city');
    }

    public function images()
    {
        return $this->hasMany(ResortImage::class, 'resort_id');
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'resort_id');
    }
}
