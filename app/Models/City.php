<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($city) {
            // dd($city->resorts);
            $city->resorts->each(function ($resort) {
                // dd($resort->resort_name);
                $resort->delete();
            });
        });

        static::restoring(function ($city) {
            $city->resorts()->withTrashed()->restore();
        });
    }


    protected $fillable = [
        'city_name',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function resorts()
    {
        return $this->hasMany(Resort::class, 'city_id');
    }

}
