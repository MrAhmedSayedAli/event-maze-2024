<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $id
 * @property mixed $uuid
 */
class Group extends Model
{


    //=================================================================>
    public function maxScore(): HasOne
    {
        //return $this->hasOne('App\Models\Maze')->orderBy('score', 'desc')->take(1);

        return $this->hasOne('App\Models\Maze')
            ->where('status', true)
            ->orderByRaw('TIMESTAMPDIFF(SECOND, start_datetime, end_datetime) ASC')->take(1);
    }

    //=================================================================>
    public function Maze(): HasMany
    {
        return $this->hasMany('App\Models\Maze');
    }    //=================================================================>
    public function Player(): HasMany
    {
        return $this->hasMany('App\Models\Player');
    }

}
