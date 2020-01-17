<?php namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use Sentinel;
use App\Country;
use App\Classify;
use View;

class BasicController extends Controller {

    /**
     * Message bag.
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $messageBag = null;

    public function __construct()
    {
        $this->messageBag = new MessageBag;
    }

    public function homePage()
    {
        $data = array();
        $data['recommendClassifies'] = Classify::recommendclassifies(4);
        $data['recommendCountries'] = Country::recommendcountries(4);
        return view('home', $data);
    }

}