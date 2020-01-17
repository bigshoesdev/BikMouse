<?php

namespace App\Http\Controllers;

use App\Classify;
use App\Country;
use App\Transaction;
use App\PayPal;
use Illuminate\Http\Request;
use Sentinel;

class SettingController extends Controller
{
    public function indexPage()
    {
        $data = array();
        $data['user'] = Sentinel::getUser();

        $data['broadcast'] = $data['user']->broadcast();

        return view('setting.index', $data);
    }

    public function profilePage()
    {
        $data = array();
        $data['user'] = Sentinel::getUser();

        return view('setting.profile', $data);
    }

    public function broadcastPage(){
        $data = array();
        $data['user'] = Sentinel::getUser();
        $data['broadcast'] = Sentinel::getUser()->broadcast();

        $data['classifies'] = Classify::allclassifies();
        $data['countries'] = Country::allcountries();

        return view('setting.broadcast', $data);
    }

    public function rechargePage()
    {
        return redirect()->route('setting.recharge.paypal');
    }

    public function paypalPage()
    {
        $data = array();
        $data['user'] = Sentinel::getUser();

        return view('setting.paypal', $data);
    }

    public function rechargeHistoryPage()
    {
        $user = Sentinel::getUser();
        $transactions = Transaction::where('user_id', $user->id)->get();

        $data['transactions'] = $transactions;
        return view('setting.history', $data);
    }

    public function charge(Request $req)
    {
        $method = $req->get('method');
        $diamond = $req->get('diamond');

        switch ($method) {
            case 'paypal' :

                $transaction = new Transaction;

                $transaction->diamond = $diamond;
                $transaction->method = $method;
                $transaction->money = $diamond / 50.4;
                $transaction->user_id = Sentinel::getUser()->id;
                $transaction->currency = 'USD';
                $transaction->success = 0;

                $transaction->save();

                $paypal = new PayPal;

                $response = $paypal->purchase([
                    'amount' => $paypal->formatAmount($transaction->money),
                    'transactionId' => $transaction->id,
                    'currency' => $transaction->currency,
                    'cancelUrl' => $paypal->getCancelUrl($transaction),
                    'returnUrl' => $paypal->getReturnUrl($transaction),
                ]);
                break;
        }

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    public function completePaypal($transactionID, Request $req)
    {
        $transaction = Transaction::findOrFail($transactionID);

        $paypal = new PayPal;

        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($transaction->money),
            'transactionId' => $transaction->id,
            'currency' => $transaction->currency,
            'cancelUrl' => $paypal->getCancelUrl($transaction),
            'returnUrl' => $paypal->getReturnUrl($transaction),
            'notifyUrl' => $paypal->getNotifyUrl($transaction),
        ]);

        if ($response->isSuccessful()) {
            $transaction->update(['tid' => $response->getTransactionReference(), 'success' => 1]);

            $diamond = Sentinel::getUser()->diamond();
            $diamond->amount = $diamond->amount + $transaction->diamond;
            $diamond->save();

            switch ($transaction->method) {
                case 'paypal':
                    return redirect()->route('setting.recharge.paypal')->with([
                        'message' => trans('general/message.recharge_success') . ' ' . $response->getTransactionReference(),
                    ]);
                default:
                    break;
            }
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    public function cancelPaypal($transactionID)
    {
        $transaction = Transaction::find($transactionID);

        switch ($transaction->method) {
            case 'paypal':
                return redirect()->route('setting.recharge.paypal')->with([
                    'message' => trans('general/message.recharge_fail')
                ]);
                break;
        }
    }

    public function saveProfile(Request $req)
    {
        $user = Sentinel::getUser();
        $user->nick_name = $req->get('nick_name');
        $user->age = $req->get('age');
        $user->gender = $req->get('gender');
        $user->address = $req->get('address');
        $user->birthday = $req->get('birthday');
        $user->introduction = $req->get('introduction');

        $user->save();

        $data = array();
        $data['success'] = true;
        $data['msg'] = trans('general/message.profile_save_success');

        return json_encode($data);
    }

    public function saveBroadcast(Request $req)
    {
        $user = Sentinel::getUser();
        $broadcast = $user->broadcast();

        $broadcast->type = $req->get('type');
        $broadcast->category_id = $req->get('category');
        $broadcast->title = $req->get('title');
        $broadcast->save();

        $data = array();
        $data['success'] = true;
        $data['msg'] = trans('general/message.broadcast_save_success');

        return json_encode($data);
    }

    public function uploadAvatar(Request $req)
    {
        $user = Sentinel::getUser();

        if ($user->pic && $user->pic != "") {
            unlink($user->pic);
        }

        $imgData = $req->get('img');
        $filePath = 'uploads/logo/' . time() . '.jpg';
        $data = substr($imgData, strpos($imgData, ","));

        $user->pic = $filePath;
        $user->save();
        file_put_contents($filePath, base64_decode($data));

        $data = array();
        $data['success'] = true;
        $data['msg'] = trans('general/message.avatar_save_success');

        return json_encode($data);
    }

    public function uploadBroadcastAvatar(Request $req)
    {
        $user = Sentinel::getUser();
        $broadcast = $user->broadcast();

        if ($broadcast->pic && $broadcast->pic != "") {
            unlink($broadcast->pic);
        }

        $imgData = $req->get('img');
        $filePath = 'uploads/broadcast/' . time() . '.jpg';
        $data = substr($imgData, strpos($imgData, ","));

        $broadcast->pic = $filePath;
        $broadcast->save();
        file_put_contents($filePath, base64_decode($data));

        $data = array();
        $data['success'] = true;
        $data['msg'] = trans('general/message.avatar_save_success');

        return json_encode($data);
    }
}