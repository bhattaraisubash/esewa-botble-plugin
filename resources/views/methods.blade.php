@if (get_payment_setting('status', ESEWA_PAYMENT_METHOD_NAME) == 1)
    <li class="list-group-item">
        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}"
               value="{{ ESEWA_PAYMENT_METHOD_NAME }}" data-toggle="collapse" data-target=".payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_wrap"
               data-parent=".list_payment_method"
               @if (setting('default_payment_method') == ESEWA_PAYMENT_METHOD_NAME) checked @endif
        >
        <label for="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}">{{ get_payment_setting('name', ESEWA_PAYMENT_METHOD_NAME) }}</label>
        <div class="payment_{{ ESEWA_PAYMENT_METHOD_NAME }}_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == ESEWA_PAYMENT_METHOD_NAME) show @endif">
            <p>{!! get_payment_setting('description', ESEWA_PAYMENT_METHOD_NAME, __('Payment with ESEWA')) !!}</p>
        </div>
    </li>
@endif
