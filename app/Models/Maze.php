<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $group_id
 * @property false|mixed $status
 * @property mixed|string|string[] $hash
 */
class Maze extends Model
{

    protected $casts = [
        'status' => 'boolean',
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];
    public function Group(): HasOne
    {
        return $this->hasOne(Group::class,'id','group_id');
    }
}
