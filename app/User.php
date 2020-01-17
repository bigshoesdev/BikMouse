<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentTaggable\Taggable;


class User extends EloquentUser
{
    use Taggable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $loginNames = ['loginid'];
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $hidden = [
        'remember_token',
        'token',
        'created_at',
        'updated_at'
    ];
    protected $appends = ['avatar', 'bean'];

    public function getAvatarAttribute()
    {
        if ($this->pic == '') {
            $avatar = 'assets/img/general/no_avatar.jpg';
        } else
            $avatar = $this->pic;

        return $avatar;
    }


    public function getBeanAttribute()
    {
        $bean = Bean::where('user_id', $this->id)->first();

        return $bean;
    }

    public function social()
    {
        return $this->hasMany('App\Social');
    }

    public function broadcast()
    {
        $broadcast = $this->hasOne(Broadcast::class, 'user_id')->get();

        if (count($broadcast) == 0)
            return null;
        else
            return $broadcast[0];
    }

    public function diamond()
    {
        $diamond = $this->hasOne(Diamond::class, 'user_id')->get();

        if (count($diamond) == 0) {
            $diamond = new Diamond;

            $diamond->user_id = $this->id;
            $diamond->amount = 0;

            $diamond->save();
            return $diamond;
        } else
            return $diamond[0];
    }

    public function avatar()
    {
        $avatar = "";
        if ($this->pic == "") {
            $avatar = "assets/img/general/no_avatar.jpg";
        } else
            $avatar = $this->pic;

        return $avatar;
    }

    public static function mostviewusers($limit)
    {
        $users = User::where(['active' => 1, 'status' => 1])->limit($limit)->orderBy('view_num', 'desc')->get();

        return $users;
    }

    public static function mostbeanusers($limit)
    {
        $beans = Bean::limit($limit)->orderBy('amount', 'desc')->get();

        $users = array();
        foreach ($beans as $bean) {
            $user = $bean->user();
            if ($user->active == 1 && $user->status == 1)
                array_push($users, $bean->user());
        }

        return $users;
    }

    public function gender() {
        if ($this->gender == 0) {
            return 'Male';
        }
        else if ($this->gender == 1) {
            return 'Female';
        }
        else {
            return 'Keep Secret';
        }
    }
}
