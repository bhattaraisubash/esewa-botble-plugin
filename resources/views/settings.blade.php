@php $esewaStatus = get_payment_setting('status', ESEWA_PAYMENT_METHOD_NAME); @endphp
<table class="table payment-method-item">
    <tbody>
    <tr class="border-pay-row">
        <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
        <td style="width: 20%;">
            <img class="filter-black" src="{{ url('vendor/core/plugins/esewa/images/esewa.png') }}"
                 alt="eSewa">
        </td>
        <td class="border-right">
            <ul>
                <li>
                    <a href="https://esewa.com.np" target="_blank">{{ __('eSewa') }}</a>
                    <p>{{ __('Customer can buy product and pay directly via :name', ['name' => 'eSewa']) }}</p>
                </li>
            </ul>
        </td>
    </tr>
    </tbody>
    <tbody class="border-none-t">
    <tr class="bg-white">
        <td colspan="3">
            <div class="float-left" style="margin-top: 5px;">
                <div
                    class="payment-name-label-group @if (get_payment_setting('status', ESEWA_PAYMENT_METHOD_NAME) == 0) hidden @endif">
                    <span class="payment-note v-a-t">{{ trans('plugins/payment::payment.use') }}:</span> <label
                        class="ws-nm inline-display method-name-label">{{ get_payment_setting('name', ESEWA_PAYMENT_METHOD_NAME) }}</label>
                </div>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($esewaStatus == 0) hidden @endif">{{ trans('plugins/payment::payment.edit') }}</a>
                <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($esewaStatus == 1) hidden @endif">{{ trans('plugins/payment::payment.settings') }}</a>
            </div>
        </td>
    </tr>
    <tr class="paypal-online-payment payment-content-item hidden">
        <td class="border-left" colspan="3">
            {!! Form::open() !!}
            {!! Form::hidden('type', ESEWA_PAYMENT_METHOD_NAME, ['class' => 'payment_type']) !!}
            <div class="row">
                <div class="col-sm-6">
                    <ul>
                        <li>
                            <label>{{ trans('plugins/payment::payment.configuration_instruction', ['name' => 'Esewa']) }}</label>
                        </li>
                        <li class="payment-note">
                            <p>{{ trans('plugins/payment::payment.configuration_requirement', ['name' => 'Esewa']) }}
                                :</p>
                            <ul class="m-md-l" style="list-style-type:decimal">
                                <li style="list-style-type:decimal">
                                    <a href="https://esewa.com.np" target="_blank">
                                        {{ __('Register a merchant account on :name', ['name' => 'Esewa']) }}
                                    </a>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>{{ __('After registration at :name, you will have MERCHANT_SCD', ['name' => 'Esewa']) }}</p>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>{{ __('Enter Development, Production SCD into the box in right hand') }}</p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="well bg-white">
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="esewa_name">{{ trans('plugins/payment::payment.method_name') }}</label>
                            <input type="text" class="next-input" name="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_name"
                                   id="esewa_name" data-counter="400"
                                   value="{{ get_payment_setting('name', ESEWA_PAYMENT_METHOD_NAME, __('Online payment via :name', ['name' => 'Esewa'])) }}">
                        </div>
                        <p class="payment-note">
                            {{ trans('plugins/payment::payment.please_provide_information') }} <a target="_blank" href="https://esewa.com.np/">Esewa</a>:
                        </p>
                        <div class="form-group">
                            <label class="text-title-field" for="{{ ESEWA_PAYMENT_METHOD_NAME }}_public">{{ __('MERCHANT SCD') }}</label>
                            <input type="text" class="next-input"
                                   name="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_public" id="{{ ESEWA_PAYMENT_METHOD_NAME }}_public"
                                   value="{{ get_payment_setting('public', ESEWA_PAYMENT_METHOD_NAME) }}">
                        </div>
                        {{-- <div class="form-group">
                            <label class="text-title-field" for="{{ ESEWA_PAYMENT_METHOD_NAME }}_secret">{{ __('Production SCD') }}</label>
                            <input type="text" class="next-input" placeholder="" id="{{ ESEWA_PAYMENT_METHOD_NAME }}_secret"
                                   name="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_secret"
                                   value="{{ get_payment_setting('secret', ESEWA_PAYMENT_METHOD_NAME) }}">
                        </div> --}}
                        <div class="form-group">
                            <label class="text-title-field" for="{{ ESEWA_PAYMENT_METHOD_NAME }}_merchant_email">{{ __('Merchant Email') }}</label>
                            <input type="email" class="next-input" placeholder="{{ __('Email') }}" id="{{ ESEWA_PAYMENT_METHOD_NAME }}_merchant_email"
                                   name="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_merchant_email"
                                   value="{{ get_payment_setting('merchant_email', ESEWA_PAYMENT_METHOD_NAME) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 bg-white text-right">
                <button class="btn btn-warning disable-payment-item @if ($esewaStatus == 0) hidden @endif"
                        type="button">{{ trans('plugins/payment::payment.deactivate') }}</button>
                <button
                    class="btn btn-info save-payment-item btn-text-trigger-save @if ($esewaStatus == 1) hidden @endif"
                    type="button">{{ trans('plugins/payment::payment.activate') }}</button>
                <button
                    class="btn btn-info save-payment-item btn-text-trigger-update @if ($esewaStatus == 0) hidden @endif"
                    type="button">{{ trans('plugins/payment::payment.update') }}</button>
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    </tbody>
</table>
