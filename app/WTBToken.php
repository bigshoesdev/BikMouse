<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WTBToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wtb_tokens';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
