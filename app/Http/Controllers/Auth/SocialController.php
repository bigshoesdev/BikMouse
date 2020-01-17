<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use App\Social;
use App\Broadcast;
use Auth;
use Sentinel;
use Redirect;

class SocialController extends Controller
{

    public function getSocialRedirect($provider)
    {
        $data['url'] = Socialite::driver($provider)->redirect()->getTargetUrl();
        $data['msg'] = trans('auth/message.sns_account_block_not_login');
        return json_encode($data);
    }

    public function getSocialHandle($provider)
    {
        if (Input::get('denied') != '' || Input::get('error') != '') {
            $data['success'] = false;
            return view('auth.social', $data);
        }

        $socialUserObject = Socialite::driver($provider)->user();

        $socialUser = null;

        // Check if loginid is already registered
        $userCheck = User::where('loginid', '=', $socialUserObject->email)->first();

        $loginid = $socialUserObject->email;

        if (!$socialUserObject->email) {
            $loginid = 'missing' . str_random(10);
        }

        if (empty($userCheck)) {
            $social = Social::where('social_id', '=', $socialUserObject->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($social)) {
                $username = $socialUserObject->nickname;
                if ($username == null)
                    $username = $socialUserObject->name;

                $userData = array();
                $userData['nick_name'] = $username;
                $userData['loginid'] = $loginid;
                $userData['token'] = str_random(64);
                $userData['type'] = 'email';
                $userData['age'] = 0;
                $userData['gender'] = 2;
                $userData['level'] = 1;
                $userData['status'] = 1;
                $userData['active'] = 1;
                $userData['password'] = bcrypt(str_random(40));

                $user = Sentinel::register($userData, true);

                $role = Sentinel::findRoleByName('User');
                $role->users()->attach($user);

                $socialData = new Social;
                $socialData->social_id = $socialUserObject->id;
                $socialData->provider = $provider;
                $user->social()->save($socialData);

                $broadcast = new Broadcast;

                $broadcast->user_id = $user->id;
                $broadcast->bid = str_random(10);
                $broadcast->active = 1;
		$broadcast->user_num = 0;

                $broadcast->save();

                if (!empty($socialUserObject->avatar)) {
                    $image_name = time() . '.png';
                    $img_path = public_path('uploads/logo/' . $image_name);

                    $arrContextOptions = array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );

                    if (file_put_contents($img_path, file_get_contents($socialUserObject->avatar), false, stream_context_create($arrContextOptions))) {
                        $user->pic = 'uploads/logo/' . $image_name;
                    }
                }

                $user->save();
                $socialUser = $user;
            } else {
                $socialUser = $social->user;
            }

            if ($socialUser->status == 0) {
                $data['success'] = false;
                $data['msg'] = trans('auth/message.account_deleted');
                return view('auth.social', $data);
            }

            if ($socialUser->active == 0) {
                $data['success'] = false;
                $data['msg'] = trans('auth/message.account_not_activate');
                return view('auth.social', $data);
            }

            Sentinel::login($socialUser, true);
            $data['success'] = true;
            $data['msg'] = trans('auth/message.login_success');
            return view('auth.social', $data);
        }

        $socialUser = $userCheck;

        if ($socialUser->status == 0) {
            $data['success'] = false;
            $data['msg'] = trans('auth/message.account_deleted');
            return view('auth.social', $data);
        }

        if ($socialUser->active == 0) {
            $data['success'] = false;
            $data['msg'] = trans('auth/message.account_not_activate');
            return view('auth.social', $data);
        }

        Sentinel::login($socialUser, true);
        $data['success'] = true;
        $data['msg'] = trans('auth/message.login_success');
        return view('auth.social', $data);
    }
}
