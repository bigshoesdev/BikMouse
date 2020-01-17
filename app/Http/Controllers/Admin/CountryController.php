<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\JoshController;
use App\Http\Requests\CountryRequest;
use App\Country;
use App\Category;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
use App\Mail\Restore;
use stdClass;


class CountryController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        $countries = Country::where('status', 1)->get();

        // Show the page
        return view('admin.country.index', compact('countries'));
    }

    public function create() {
        return view('admin.country.create');
    }

    public function store(CountryRequest $request) {

        $country = new Country($request->only(['country_name', 'country_code', 'phone_code', 'status']));

        if ($country->save()) {
            return redirect('admin/country')->with('success', trans('country/message.success.create'));
        } else {
            return Redirect::route('admin/country')->withInput()->with('error', trans('country/message.error.create'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country $Country
     * @return view
     */
    public function edit(Country $country)
    {
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Country $Country
     * @return Response
     */
    public function update(CountryRequest $request, Country $country)
    {
        if ($country->update($request->only(['country_name', 'country_code', 'phone_code']))) {
            return redirect('admin/country')->with('success', trans('message.success.update'));
        } else {
            return redirect('admin/country')->withInput()->with('error', trans('message.error.update'));
        }
    }

    public function destroy(Country $country) {
        if ($country->update(['status' => 0])) {
            return redirect('admin/country')->with('success', trans('country/message.success.delete'));
        } else {
            return Redirect::route('admin/country')->withInput()->with('error', trans('country/message.error.delete'));
        }
    }

    public function getModalDelete(Country $country)
    {
        $model = 'country';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.country.delete', ['id' => $country->id]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('country/message.error.delete', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }
}
