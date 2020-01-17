<?php

namespace App\Http\Controllers;

use App\WTBToken;
use Sentinel;
use Illuminate\Http\Request;
use App\Broadcast;

class BroadcastController extends Controller
{
    public function broadcastViewPage($id)
    {
        $broadcast = Broadcast::find($id);

        if($broadcast->is_start == 0) {
            return redirect()->back()->with('broadcast_stop_msg', trans('general/message.broadcast_stop'));
        }

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

        $data['broadcast'] = $broadcast;
        $data['token'] = $token;

        return view('broadcast.broadcast-view', $data);
    }

    public function broadcastLivePage()
    {
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

        $data['user'] = $user;
        $broadcast = $user->broadcast();

        if ($broadcast->title == "" || !$broadcast->type || !$broadcast->category_id || $broadcast->type == "" || $broadcast->category_id == "")
            return redirect()->route('setting.broadcast');

        $data['token'] = $token;
        $data['broadcast'] = $broadcast;

        return view('broadcast.broadcast-live', $data);
    }
}