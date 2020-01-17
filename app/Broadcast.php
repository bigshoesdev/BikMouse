<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'broadcasts';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['avatar', 'user'];

    public function getAvatarAttribute()
    {
        if ($this->pic == '') {
            if ($this->type == 'game') {
                $avatar = 'assets/img/general/game.jpg';
            } else {
                $avatar = 'assets/img/general/showbiz.jpg';
            }
        } else
            $avatar = $this->pic;

        return $avatar;
    }

    public function getUserAttribute()
    {
        return User::find($this->user_id);
    }

    public static function gameList($classify, $offset, $limit)
    {
        if ($classify == 0) {
            $broadcasts = Broadcast::where(['active' => 1, 'is_start' => 1, 'type' => 'game'])->offset($offset)->limit($limit)->orderBy('title')->get();
        } else {
            $broadcasts = Broadcast::where(['active' => 1, 'is_start' => 1, 'type' => 'game', 'category_id' => $classify])->offset($offset)->limit($limit)->orderBy('title')->get();
        }

        return $broadcasts;
    }

    public static function liveList($country, $offset, $limit)
    {
        if ($country == 0) {
            $broadcasts = Broadcast::where(['active' => 1, 'is_start' => 1, 'type' => 'live'])->offset($offset)->limit($limit)->orderBy('title')->get();
        } else {
            $broadcasts = Broadcast::where(['active' => 1, 'is_start' => 1, 'type' => 'live', 'category_id' => $country])->offset($offset)->limit($limit)->orderBy('title')->get();
        }

        return $broadcasts;
    }

    public static function recommendList($limit)
    {
        $broadcasts = Broadcast::where(['active' => 1, 'is_start' => 1])->limit($limit)->orderBy('user_num')->orderBy('created_at', 'desc')->get();

        return $broadcasts;
    }

    public function getCategoryLabel() {
        if($this->category_id != "") {
            if($this->type == 'game') {
                return Classify::find($this->category_id)->title;
            }else{
                return Country::find($this->category_id)->country_name;
            }
        }
    }

    public function user()
    {
        $user = User::find($this->user_id);
        return $user;
    }
}
