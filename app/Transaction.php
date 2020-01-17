<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        $user = User::find($this->user_id);
        return $user;
    }
}