<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public static function allcountries()
    {
        $countryList = Country::where('status', 1)->orderBy('country_name')->get();
        return $countryList;
    }

    public static function recommendcountries($num)
    {
        if ($num == 0)
            $countryList = Country::where('status', 1)->orderBy('country_name')->get();
        else
            $countryList = Country::where('status', 1)->orderBy('country_name')->limit($num)->get();

        return $countryList;
    }

}