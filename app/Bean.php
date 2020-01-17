<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bean extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'beans';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        $user = User::find($this->user_id);
        return $user;
    }
}