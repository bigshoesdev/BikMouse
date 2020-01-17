<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classifies';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['logo'];

    public static function allclassifies()
    {
        $classifyList = Classify::where('status', 1)->orderBy('created_at', 'desc')->get();

        return $classifyList;
    }

    public static function recommendclassifies($num) {
        $classifyList = Classify::where('status', 1)->orderBy('created_at', 'desc')->limit($num)->get();

        return $classifyList;
    }

    public function getLogoAttribute()
    {
        if ($this->pic == '') {
            $logo = 'assets/img/bigo/bigo_auto.png';
        } else
            $logo = $this->pic;

        return $logo;
    }
}