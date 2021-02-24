<?php

namespace Subash\Esewa\Providers;

use Botble\Ecommerce\Repositories\Interfaces\OrderAddressInterface;
use Botble\Payment\Enums\PaymentMethodEnum;
use Html;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, [$this, 'registerEsewaMethod'], 16, 2);
        $this->app->booted(function () {
            add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, [$this, 'checkoutWithEsewa'], 16, 2);
        });

        add_filter(PAYMENT_METHODS_SETTINGS_PAGE, [$this, 'addPaymentSettings'], 97, 1);

        add_filter(BASE_FILTER_ENUM_ARRAY, function ($values, $class) {
            if ($class == PaymentMethodEnum::class) {
                $values['ESEWA'] = ESEWA_PAYMENT_METHOD_NAME;
            }

            return $values;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == ESEWA_PAYMENT_METHOD_NAME) {
                $value = 'Esewa';
            }

            return $value;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_HTML, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == ESEWA_PAYMENT_METHOD_NAME) {
                $value = Html::tag(
                    'span',
                    PaymentMethodEnum::getLabel($value),
                    ['class' => 'label-success status-label']
                )
                    ->toHtml();
            }

            return $value;
        }, 21, 2);
    }

    /**
     * @param string $settings
     * @return string
     * @throws Throwable
     */
    public function addPaymentSettings($settings)
    {
        return $settings . view('plugins/esewa::settings')->render();
    }

    /**
     * @param string $html
     * @param array $data
     * @return string
     */
    public function registerEsewaMethod($html, array $data)
    {
        return $html . view('plugins/esewa::methods', $data)->render();
    }

    /**
     * @param Request $request
     * @param array $data
     */
    public function checkoutWithEsewa($data, Request $request)
    {
        // echo json_encode($request->input());
        // exit;
        if ($request->input('payment_method') == ESEWA_PAYMENT_METHOD_NAME) {
            $orderAddress = $this->app->make(OrderAddressInterface::class)->getFirstBy(['order_id' => $request->input('order_id')]);
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Payment Via eSewa</title>
            </head>

            <body>

                <form id="esewa-payment-form" action="<?= ESEWA_PAYMENT_URL ?>" method="POST">
                    <input value="<?= round($request->input('amount'), 2); ?>" name="tAmt" type="hidden">
                    <input value="<?= round($request->input('sub_total'), 2); ?>" name="amt" type="hidden">
                    <input value="<?= round($request->input('tax_amount'), 2); ?>" name="txAmt" type="hidden">
                    <input value="0.00" name="psc" type="hidden">
                    <input value="<?= round($request->input('shipping_amount'), 2); ?>" name="pdc" type="hidden">
                    <input value="<?= get_payment_setting('public', ESEWA_PAYMENT_METHOD_NAME); ?>" name="scd" type="hidden">
                    <input value="<?= $request->input('checkout-token'); ?>" name="pid" type="hidden">
                    <input value="<?= route('esewa.payment.success')."?q=su&order_id=".$request->input('order_id')."&currency=".$request->input('currency')."&amount_to_pay=".round($request->input('amount'), 2); ?>" type="hidden" name="su">
                    <input value="<?= route('esewa.payment.failure'); ?>" type="hidden" name="fu">
                </form>

                <script>
                    document.getElementById('esewa-payment-form').submit();
                </script>
            </body>

            </html>
<?php
exit;
        }
    }
}
