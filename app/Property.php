<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{

    protected $table = 'properties';

    protected $fillable = [
        'name', 'user_id', 'latitude', 'longitude',
    ];

    /**
     * Belongs to one user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeOwner($query, $user_id)
    {
        if(!$user_id) return $query;

        return $query->where('user_id',$user_id);
    }

    /**
     * @param $query
     * @param $latitude
     * @param $longitude
     * @param $radius in km
     * @return mixed
     */
    public function scopeDistance($query, $latitude, $longitude, $radius)
    {
        if(!$latitude || !$longitude || !$radius) return $query;

        $distance = "( 6371 * acos( cos( radians({$latitude}) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians({$longitude}) ) + sin( radians({$latitude}) ) * sin( radians( latitude ) ) ) ) AS distance";
        
        return $query
            ->select(['*',DB::raw($distance)])
            ->orderBy('distance')
            ->having('distance','<',ceil($radius));
    }
}
