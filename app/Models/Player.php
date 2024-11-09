<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $email
 * @property mixed $group_id
 */
class Player extends Model
{
    protected $hidden = [
        'id'
    ];

    public function Group(): BelongsTo
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }



}
