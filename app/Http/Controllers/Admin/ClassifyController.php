<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\JoshController;
use App\Http\Requests\ClassifyRequest;
use App\Classify;
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


class ClassifyController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        $classifies = Classify::where('status', 1)->get();

        // Show the page
        return view('admin.classify.index', compact('classifies'));
    }

    public function create() {
        return view('admin.classify.create');
    }

    public function store(ClassifyRequest $request) {

        //upload image
        if ($file = $request->file('logo_file')) {
            $extension = $file->extension()?: 'png';
            $destinationPath = public_path() . '/uploads/classify/';
            $safeName = str_random(20) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $request['pic'] = 'uploads/classify/' . $safeName;
        }

        $classify = new Classify($request->only(['title', 'pic', 'status']));
//
        if ($classify->save()) {
            return redirect('admin/classify')->with('success', trans('classify/message.success.create'));
        } else {
            return redirect('admin/classify')->with('error', trans('classify/message.error.create'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Classify $Classify
     * @return view
     */
    public function edit(Classify $classify)
    {
        return view('admin.classify.edit', compact('classify'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Classify $Classify
     * @return Response
     */
    public function update(ClassifyRequest $request, Classify $classify)
    {
        if ($classify->update($request->only(['title', 'status']))) {
            // is new image uploaded?
            if ($file = $request->file('logo_file')) {
                $extension = $file->extension()?: 'png';
                $destinationPath = public_path() . '/uploads/classify/';
                $safeName = str_random(20) . '.' . $extension;
                $file->move($destinationPath, $safeName);
                //delete old pic if exists
                if (File::exists(public_path() . '/' . $classify->pic)) {
                    File::delete(public_path() . '/' . $classify->pic);
                }
                //save new file path into db
                $classify->pic = 'uploads/classify/' . $safeName;
            }

            //save record
            $classify->save();

            return redirect('admin/classify')->with('success', trans('message.success.update'));
        } else {
            return redirect('admin/classify')->withInput()->with('error', trans('message.error.update'));
        }
    }

    public function destroy(Classify $classify) {
        if ($classify->update(['status' => 0])) {
            return redirect('admin/classify')->with('success', trans('classify/message.success.delete'));
        } else {
            return Redirect::route('admin/classify')->withInput()->with('error', trans('classify/message.error.delete'));
        }
    }

    public function getModalDelete(Classify $classify)
    {
        $model = 'Classify';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.classify.delete', ['id' => $classify->id]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('classify/message.error.delete', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }
}
