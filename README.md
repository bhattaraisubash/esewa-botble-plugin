# esewa-botble-plugin
##### This is the payment gateway integration of payment platform esewa. It is a plugin made to work on [Botble CMS](https://1.envato.market/yRg6kB) .
` Note: This plugin works best with [payment] and [ecommerce] plugin activated. But you can modify and make it to work however you like. `
## How to use esewa-botble-plugin ?
- Simply download the repository.
- Move the downloaded folder to `platform/plugins/`
- Login to admin dashboard, go to plugins and activate the plugin eSewa.
- Go to payment methods of payment plugin and fill required credentials and activate eSewa as payment method.

## UPDATE
In newer versions of botble cms, there has been some changes in the controller class. `use Botble\Payment\Services\Traits\PaymentTrait;` has been replaced with `use Botble\Payment\Supports\PaymentHelper;` and `use PaymentTrait;` has been removed. If you are using newer versions, this plugins works as it is and if you are using older versions, just do the reverse of what has been done in `src/ESewaController.php` class, following the comments.
