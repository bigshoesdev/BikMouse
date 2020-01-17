<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Sentinel;
use View;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class HomeController extends Controller {

    public function showHome()
    {
        if(Sentinel::check())
            return redirect('admin/users');
        else
            return redirect('admin/signin')->with('error', 'You must be logged in!');
    }
}