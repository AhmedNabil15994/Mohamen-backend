<?php

namespace Modules\Transaction\Services;

class UPaymentService
{
    /*
     * Live CREDENTIALS
    const MERCHANT_ID = "679";
    const USERNAME = "tocaan";
    const PASSWORD = "ml4nf9wx2utuogcr";
    const API_KEY = "nLuf1cAgcx2KFEViDSzxN785vXqlNx4FawQaQ086";
    */

    /*
     * Test CREDENTIALS
     */
    public const MERCHANT_ID = "1201";
    public const USERNAME = "test";
    public const PASSWORD = "test";
    public const API_KEY = "jtest123";

    protected $paymentMode = 'test_mode';
    protected $test_mode = 1;
    protected $whitelabled = true;
    protected $paymentUrl = "https://api.upayments.com/test-payment";
    protected $apiKey = '';

    public function __construct()
    {
        if (config('setting.payment_gateway.upayment.payment_mode') == 'live_mode') {
            $this->paymentMode = 'live_mode';
            $this->test_mode = 0;
            $this->test_mode = false;
            $this->paymentUrl = "https://api.upayments.com/payment-request";
            $this->apiKey = password_hash(config('setting.payment_gateway.upayment.' . $this->paymentMode . '.API_KEY') ?? self::API_KEY, PASSWORD_BCRYPT);
        } else {
            $this->apiKey = config('setting.payment_gateway.upayment.' . $this->paymentMode . '.API_KEY') ?? self::API_KEY;
        }
    }

    public function send($transaction, $payment, $userToken = '')
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user = [
                'name' => $user->name,
                'mobile' => $user->mobile_code  . $user->mobile,
            ];
        } else {
            $user = [
                'name' => 'Guest User',
                'mobile' => '12345678',
            ];
        }

        $total_price = $transaction->total;
        $extraMerchantsData = [];
        $extraMerchantsData['amounts'][0] = 1;
        $extraMerchantsData['charges'][0] = 0.350;
        $extraMerchantsData['chargeType'][0] = 'fixed'; // or 'percentage'
        $extraMerchantsData['cc_charges'][0] = 2.7; // or 'percentage'
        $extraMerchantsData['cc_chargeType'][0] = 'percentage'; // or 'percentage'
        $extraMerchantsData['ibans'][0] = config('setting.payment_gateway.upayment.' . $this->paymentMode . '.IBAN') ?? '';

        $url = $this->paymentUrls($payment);

        $fields = [
            'api_key' => $this->apiKey,
            'merchant_id' => config('setting.payment_gateway.upayment.' . $this->paymentMode . '.MERCHANT_ID') ?? self::MERCHANT_ID,
            'username' => config('setting.payment_gateway.upayment.' . $this->paymentMode . '.USERNAME') ?? self::USERNAME,
            'password' => stripslashes(config('setting.payment_gateway.upayment.' . $this->paymentMode . '.PASSWORD') ?? self::PASSWORD),
            'order_id' => $transaction->id,
            'CurrencyCode' => 'KWD', //only works in production mode
            'CstFName' => $user['name'],
            'CstMobile' => $user['mobile'],
            'success_url' => $url['success'],
            'error_url' => $url['failed'],
            'ExtraMerchantsData' => json_encode($extraMerchantsData),
            'test_mode' => $this->test_mode, // 1 == test mode enabled
            'whitelabled' => $this->whitelabled, // false == in live mode
            'payment_gateway' => 'knet', // knet / cc
            'reference' => $transaction->id,
            'notifyURL' => route('api.reservations.notify'),
            'total_price' =>   $total_price,
            'userToken' => $userToken,
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paymentUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output, true);
        return $server_output['paymentURL'];
    }

    public function paymentUrls($type)
    {
        $url['success'] = route('api.reservations.success');
        $url['failed'] = route('api.reservations.failed');
        return $url;
    }
}
