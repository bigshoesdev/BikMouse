<?php

namespace App;

use Omnipay\Omnipay;

/**
 * Class PayPal
 * @package App
 */
class PayPal
{
    public function gateway()
    {
        $gateway = Omnipay::create('PayPal_Express');

        $gateway->setUsername(config('services.paypal.username'));
        $gateway->setPassword(config('services.paypal.password'));
        $gateway->setSignature(config('services.paypal.signature'));
        $gateway->setTestMode(config('services.paypal.sandbox'));

        return $gateway;
    }

    public function purchase(array $parameters)
    {
        $response = $this->gateway()
            ->purchase($parameters)
            ->send();

        return $response;
    }

    public function complete(array $parameters)
    {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();

        return $response;
    }

    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function getCancelUrl($transaction)
    {
        return route('setting.recharge.checkout.paypal.cancel', $transaction->id);
    }

    public function getReturnUrl($transaction)
    {
        return route('setting.recharge.checkout.paypal.complete', $transaction->id);
    }

    public function getNotifyUrl($transaction)
    {
        $env = config('paypal.credentials.sandbox') ? "sandbox" : "live";

        return route('setting.recharge.webhook.paypal', [$transaction->id, $env]);
    }
}