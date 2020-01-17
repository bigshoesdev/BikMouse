<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Sentinel;


class ShowBizController extends Controller {
    public function showBizPage() {
        $data = array();

        $data['countries'] = Country::recommendcountries(0);
        return view('showbiz.index', $data);
    }
}