<?php

namespace Subash\Esewa\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\ServiceProvider;

class EsewaServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * @throws FileNotFoundException
     */
    public function boot()
    {
        if (is_plugin_active('payment')) {
            $this->setNamespace('plugins/esewa')
                ->loadRoutes(['web'])
                ->loadAndPublishViews()
                ->publishAssets();

            $this->app->register(HookServiceProvider::class);

            $config = $this->app->make('config');

            $config->set([
                'esewa.publicKey'     => get_payment_setting('public', ESEWA_PAYMENT_METHOD_NAME),
                'esewa.secretKey'     => get_payment_setting('secret', ESEWA_PAYMENT_METHOD_NAME),
                'esewa.merchantEmail' => get_payment_setting('merchant_email', ESEWA_PAYMENT_METHOD_NAME),
                'esewa.paymentUrl'    => ESEWA_PAYMENT_URL,
            ]);
        }
    }
}
