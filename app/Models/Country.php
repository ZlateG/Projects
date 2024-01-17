<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($country) {
            $country->cities->each(function ($city) {
                $city->resorts->each(function ($resort) {
                    $resort->apartments->each(function ($apartment) {
                        $apartment->delete();
                    });
                    $resort->delete();
                });
                $city->delete();
            });
        });

        static::restoring(function ($country) {
            $country->cities()->withTrashed()->restore();
            $resorts = $country->cities->flatMap(function ($city) {
                return $city->resorts;
            });
            $resorts->each(function ($resort) {
                $resort->restore();
            });
        });
    }

    protected $fillable = [
        'country_name',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function resorts()
    {
        return $this->hasManyThrough(Resort::class, City::class);
    }

    public function apartments()
    {
        return $this->hasManyThrough(Apartment::class, City::class);
    }
}
