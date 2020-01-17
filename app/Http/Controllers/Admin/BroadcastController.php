<?php namespace App\Http\Controllers\Admin;

use App\Broadcast;
use App\Http\Requests\BroadcastRequest;
use App\Category;
use File;
use Hash;
use Redirect;
use Sentinel;
use URL;
use View;
use Validator;
use App\Mail\Restore;
use App\WTBToken;

class BroadcastController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        return redirect('admin/broadcast/gaming');
    }

    public function gaming() {
        $broadcasts = Broadcast::where('type', 'game')->orderby('created_at', 'desc')->get();

        // Show the page
        return view('admin.broadcast.gaming', compact('broadcasts'));
    }

    public function showbiz() {
        $broadcasts = Broadcast::where('type', 'live')->orderby('created_at', 'desc')->get();

        // Show the page
        return view('admin.broadcast.showbiz', compact('broadcasts'));
    }

    public function create() {
        return view('admin.broadcast.create');
    }

    public function show(Broadcast $broadcast)
    {
        return view('admin.broadcast.show', compact('broadcast'));
    }

    public function store(BroadcastRequest $request) {

        //upload image
        if ($file = $request->file('logo_file')) {
            $extension = $file->extension()?: 'png';
            $destinationPath = public_path() . '/uploads/broadcast/';
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $request['logo_url'] = $safeName;
        }

        $broadcast = new Broadcast($request->only(['name', 'logo_url']));

        if ($broadcast->save()) {
            return redirect('admin/broadcast')->with('success', trans('broadcast/message.success.create'));
        } else {
            return Redirect::route('admin/broadcast')->withInput()->with('error', trans('broadcast/message.error.create'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Broadcast $Broadcast
     * @return view
     */
    public function edit(Broadcast $broadcast)
    {
        return view('admin.broadcast.edit', compact('broadcast'));
    }

    public function presents(Broadcast $broadcast) {
        $presents = $broadcast->presents();

        return view('admin.broadcast.presents', compact('presents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Broadcast $Broadcast
     * @return Response
     */
    public function update(BroadcastRequest $request, Broadcast $broadcast)
    {
        if ($broadcast->update($request->only(['status']))) {
            return redirect('admin/broadcast')->with('success', trans('message.success.update'));
        } else {
            return redirect('admin/broadcast')->withInput()->with('error', trans('message.error.update'));
        }
    }

    public function destroy(Broadcast $broadcast) {
        if ($broadcast->update(['active' => 0, 'is_start' => 0])) {
            return redirect('admin/broadcast')->with('success', trans('broadcast/message.success.disable'));
        } else {
            return Redirect::route('admin/broadcast')->withInput()->with('error', trans('broadcast/message.error.disable'));
        }
    }

    public function enable(Broadcast $broadcast) {
        if ($broadcast->update(['active' => 1])) {
            return redirect('admin/broadcast')->with('success', trans('broadcast/message.success.enable'));
        } else {
            return Redirect::route('admin/broadcast')->withInput()->with('error', trans('broadcast/message.error.enable'));
        }
    }

    public function getModalDelete(Broadcast $broadcast)
    {
        $model = 'broadcast';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.broadcast.delete', ['id' => $broadcast->id]);
            return view('admin.layouts.modal_disable', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = trans('broadcast/message.error.delete', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    public function connect(Broadcast $broadcast) {

        $user = Sentinel::getUser();

        $ip = \Request::ip();
        $token = WTBToken::where(['ip'=> $ip, 'user_id'=> $user->id])->first();

        if(count($token ) != 0) {
            $token->delete();
        }

        $token = new WTBToken;
        $token->ip = $ip;
        $token->user_id = Sentinel::getUser()->id;
        $token->ts = date_create();
        $token->token = md5(uniqid());
        $token->save();

        $data['token'] = $token;
        $data['broadcast'] = $broadcast;
        return view('admin.broadcast.connect', $data);
    }
}
