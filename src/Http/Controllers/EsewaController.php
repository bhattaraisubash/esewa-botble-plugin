<?php

namespace Subash\Esewa\Http\Controllers;

use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
//use Botble\Payment\Services\Traits\PaymentTrait; //removed in newer versions: uncommend for older versions
use OrderHelper;
use Illuminate\Http\Request;
use Botble\Payment\Supports\PaymentHelper; //added in newer versions: commend for newer versions
use Throwable;

class EsewaController extends BaseController
{
    //use PaymentTrait; //removed in newer versions: uncommend for older versions

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function paymentSuccess(Request $request, BaseHttpResponse $response)
    {
        //sessioned total price
        $amountToBePaid = $request->input('amount_to_pay');
        $data = [
            'amt' => $amountToBePaid,
            'rid' => $_GET['refId'],
            'pid' => $_GET['oid'],
            'scd' => get_payment_setting('public', ESEWA_PAYMENT_METHOD_NAME)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, ESEWA_VERIFICATION_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        //convert xml response to array
        $response = json_decode(json_encode(simplexml_load_string($response)), TRUE);
        $response_code = trim(strtolower($response['response_code'])); //remove whitespaces
        
        $status = PaymentStatusEnum::PENDING;
        $verified = false;

        if (strcmp($response_code, 'success') == 0) {
            //payment verified
            $status = PaymentStatusEnum::COMPLETED;
            $verified = true;
        } else {
            //not verified
            $status = PaymentStatusEnum::FRAUD;
            $verified = false;
        }

        $this->storeLocalPayment([
            'amount'          => ($amountToBePaid),
            'currency'        => $request->input('currency'),
            'charge_id'       => $request->input('refId'),
            'payment_channel' => ESEWA_PAYMENT_METHOD_NAME,
            'status'          => $status,
            'customer_id'     => auth('customer')->check() ? auth('customer')->user()->getAuthIdentifier() : null,
            'payment_type'    => 'direct',
            'order_id'        => $request->input('order_id'),
        ]);

        OrderHelper::processOrder($request->input('order_id'), $request->input('oid'));

        if (!$verified) {
            return $response
                ->setError()
                ->setNextUrl(route('public.checkout.success', OrderHelper::getOrderSessionToken()))
                ->setMessage(__('Order placed. However, payment was not verified. Please contact our administration!'));
        }
        
        return $response
        ->setNextUrl(route('public.checkout.success', OrderHelper::getOrderSessionToken()))
        ->setMessage(__('Checkout Successful!'));
    }

    public function paymentFailure(Request $request, BaseHttpResponse $response){
        return $response
        ->setError()
        -> setNextUrl(route('public.checkout.information', OrderHelper::getOrderSessionToken()))
        ->setMessage(__('eSewa Payment Failed !'));
    }
}
