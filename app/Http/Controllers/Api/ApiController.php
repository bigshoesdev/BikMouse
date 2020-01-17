<?php
namespace App\Http\Controllers\Api;

use App\Broadcast;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classify;
use App\Country;
use App\User;
use App\WTBToken;
use Sentinel;


class ApiController extends Controller {
    public function countryList() {
        $countryList = Country::allcountries();

        $data['msg'] = "success";

        $data["data"] = array();
        foreach($countryList as $country) {
            $data['data'][$country->country_code] = $country;
        }

        return json_encode($data);
    }

    public function viewToken() {
        $data = array();

        if (Sentinel::check()) {
            $user = Sentinel::getUser();

            $ip = \Request::ip();
            $token = WTBToken::where(['ip' => $ip, 'user_id' => $user->id])->first();

            if (count($token) != 0) {
                $token->delete();
            }

            $token = new WTBToken;
            $token->ip = $ip;
            $token->user_id = Sentinel::getUser()->id;
            $token->ts = date_create();
            $token->token = md5(uniqid());
            $token->save();

            $data['token'] = $token;
        }else {
            $data['token'] = null;
        }

        return json_encode($data);
    }

    public function classifyList() {
        $classifyList = Classify::allclassifies();

        return json_encode($classifyList);
    }

    public function gameList(Request $req) {
        $classify = $req->get('classify');
        $offset = $req->get('offset');
        $limit = $req->get('limit');
        $gameList = Broadcast::gameList($classify, $offset, $limit);

        return json_encode($gameList);
    }

    public function liveList(Request $req) {
        $country = $req->get('country');
        $offset = $req->get('offset');
        $limit = $req->get('limit');
        $gameList = Broadcast::liveList($country, $offset, $limit);

        return json_encode($gameList);
    }

    public function advertise() {
        $data = new \stdClass;
        $data->url = "http://yycall.bs2.yy.com/yycall_7905e6c11839cd7b9d7eae23a1a0fbdc.png?token=ak_yycall:w6NmEd7X2r7MQhgL3fk-HY4tD7A=:0&checkMd5=7905e6c11839cd7b9d7eae23a1a0fbdc";
        $data->go_url = "http://www.cubetv.sg";

        $result = array();
        array_push($result, $data);

        return json_encode($result);
    }

    public function recommendList(){
        $list = Broadcast::recommendList(6);

        if(count($list) > 4)
        return json_encode($list);
        else
            return json_encode('[]');
    }

    public function mostViewUserList() {
        $users = User::mostviewusers(20);

        return json_encode($users);
    }

    public function mostBeanUserList() {
        $users = User::mostbeanusers(20);

        return json_encode($users);
    }
}