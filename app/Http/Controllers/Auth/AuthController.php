<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Activation;
use App\Broadcast;
use App\User;
use stdClass;
use Validator;
use URL;
use Mail;
use App\Mail\SendCode;
use Redirect;
use Sentinel;

class AuthController extends \App\Http\Controllers\BasicController
{
    public function postRegister(Request $request)
    {
        $activate = true;
        try {
            $broadcastID = str_random(10);
            $userData = array();
            $userData['type'] = $request->get('type');
            $userData['nick_name'] = 'ID:' . $broadcastID;
            $userData['loginid'] = $request->get('loginid');

            $rules = [
                'loginid' => $userData['type'] == 'email' ? 'required|unique:users|email' : 'required|unique:users'
            ];

            $validator = Validator::make($userData, $rules);

            if ($validator->fails()) {
                $result['success'] = false;
                $result['msg'] = trans('auth/message.account_already_exists');
                return json_encode($result);
            }

            $userData['password'] = $request->get('password');
            $userData['token'] = str_random(64);
            $userData['age'] = 0;
            $userData['gender'] = 2;
            $userData['level'] = 1;
            $userData['status'] = 1;
            $userData['active'] = 1;
            $user = Sentinel::register($userData, $activate);

            $broadcast = new Broadcast;

            $broadcast->user_id = $user->id;
            $broadcast->bid = $broadcastID;
            $broadcast->active = 1;
            $broadcast->user_num = 0;

            $broadcast->save();

            $role = Sentinel::findRoleByName('User');
            $role->users()->attach($user);

            Sentinel::login($user, false);

            $result = array();
            $result['success'] = true;
            $result['msg'] = trans('auth/message.signup.success');
            return json_encode($result);
        } catch (UserExistsException $e) {
            $result['success'] = false;
            $result['msg'] = trans('auth/message.account_already_exists');
            return json_encode($result);
        }
    }

    public function postLogin(Request $request)
    {
        $data = array();
        $data['success'] = false;
        try {
            // Try to log the user in
            if ($user = Sentinel::authenticate($request->only('loginid', 'password'), $request->get('remember-me', 0))) {
                if ($user->status == 0) {
                    Sentinel::logout();
                    $data['msg'] = trans('auth/message.account_deleted');
                    return json_encode($data);
                }

                if ($user->active == 0) {
                    Sentinel::logout();
                    $data['msg'] = trans('auth/message.account_not_activate');
                    return json_encode($data);
                }

                $returnUrl = $request->session()->pull('returnUrl');
                $data['success'] = true;
                if ($returnUrl) {
                    $data['url'] = $returnUrl;
                }
                $data['url'] = Redirect::to('home')->getTargetUrl();
            } else {
                $data['msg'] = trans('auth/message.email_password_incorrect');
            }
        } catch (UserNotFoundException $e) {
            $data['msg'] = trans('auth/message.account_not_found');
        }

        return json_encode($data);
    }

    public function getLogout()
    {
        if (Sentinel::check()) {
            Sentinel::logout();
        }
        return Redirect::route('home');
    }

    public function sendCode(Request $req)
    {
        $type = $req->get('type');
        $loginid = $req->get('loginid');

        $data['success'] = true;

        $user = Sentinel::findByCredentials(['loginid' => $req->get('loginid')]);
        if($user) {
            $data['success'] = false;
            $data['msg'] = trans('auth/message.account_already_exists');
            return json_encode($data);
        }

        if ($type == 'email') {
            $d = new stdClass();
            $d->code = str_random(10);
            Mail::to($loginid)->send(new SendCode($d));
            $data['code'] = $d->code;
            return json_encode($data);
        } else {
            $randomNumber = '';
            for ($i = 0; $i < 8; $i++) {
                $randomNumber .= mt_rand(0, 9);
            }
            $url = "http://sms.radiocorn.co.kr?phonenumber=$loginid&authnumber=$randomNumber";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $answer = json_decode(curl_exec($ch));

            curl_close($ch);

            if ($answer->result == 'success') {
                $data['success'] = true;
                $data['code'] = $randomNumber;
                return json_encode($data);
            } else {
                $data['success'] = false;
                $data['msg'] = trans('auth/general.fail_in_send_code');
                return json_encode($data);
            }
        }
    }

    public function resetPassword(Request $req)
    {
        $user = Sentinel::findByCredentials(['loginid' => $req->get('loginid')]);

        $data = array();
        if (count($user) == 0) {
            $data['success'] = false;
            $data['msg'] = trans('auth/message.reset_account_not_found');

            return json_encode($data);
        } else {
            $user->password = $req->get('password');

            Sentinel::update($user, array('password' => $req->get('password')));

            $data['success'] = true;
            $data['msg'] = trans('auth/message.reset_password_success');

            return json_encode($data);
        }
    }
}
