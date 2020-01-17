<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'diamonds';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
