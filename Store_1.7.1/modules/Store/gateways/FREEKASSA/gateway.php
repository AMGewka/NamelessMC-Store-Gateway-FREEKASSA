<?php
/**
 * FreeKassa_Gateway class
 *
 * @package Modules\Store
 * @author AMGewka
 * @version 1.8.3
 * @license MIT
 */
class FREEKASSA_Gateway extends GatewayBase {

    public function __construct() {
        $name = 'FREEKASSA';
        $author = '<a href="https://github.com/AMGewka" target="_blank" rel="nofollow noopener">AMGewka</a>';
        $gateway_version = '1.8.3';
        $store_version = '1.7.1';
        $settings = ROOT_PATH . '/modules/Store/gateways/FREEKASSA/gateway_settings/settings.php';

        parent::__construct($name, $author, $gateway_version, $store_version, $settings);
    }

    public function onCheckoutPageLoad(TemplateBase $template, Customer $customer): void {}

    public function processOrder(Order $order): void {
        $shopId = StoreConfig::get('FREEKASSA/shopid_key');
        $apiKey = StoreConfig::get('FREEKASSA/shopapi_key');
        $secretWord = StoreConfig::get('FREEKASSA/secret1_key');
        
        if ($shopId == null || empty($shopId)) {
            $this->addError('The administration has not completed the configuration of this gateway!');
            return;
        }

        $paymentId = $order->data()->id;
        $orderAmount = $order->getAmount()->getTotalCents() / 100;
        $currency = $order->getAmount()->getCurrency();

        $sign = md5($shopId . ':' . $orderAmount . ':' . $secretWord . ':' . $currency . ':' . $paymentId);

        $paymentUrl = 'https://pay.freekassa.ru/?m=' . $shopId . '&oa=' . $orderAmount . '&o=' . $paymentId . '&s=' . $sign . '&currency=' . $currency;

        header('Location: ' . $paymentUrl);
    }

    public function handleReturn(): bool {
        if (isset($_GET['do']) && $_GET['do'] == 'success') {
            header("Location: " . URL::getSelfURL(), '/') . URL::build('/store/');
        }

        return false;
    }

    public function handleListener(): void {
        $shopId = StoreConfig::get('FREEKASSA/shopid_key');
        $apiKey = StoreConfig::get('FREEKASSA/shopapi_key');
        $secretWord = StoreConfig::get('FREEKASSA/secret2_key');

        $allowedIps = array(
            '168.119.157.136', 
            '168.119.60.227', 
            '138.201.88.124',
            '178.154.197.79',
        );

        if(!in_array($_SERVER['REMOTE_ADDR'], $allowedIps)){
            die("bad ip!");
        }

        $sign = md5($_REQUEST['MERCHANT_ID'] . ':' . $_REQUEST['AMOUNT'] . $secretWord . $_REQUEST['MERCHANT_ORDER_ID']);

        if($sign != $_REQUEST['SIGN']){
            die("Signature error!");
        }

        $paymentId = $_REQUEST['MERCHANT_ORDER_ID'];
        $orderAmount = $_REQUEST['AMOUNT'];
        $currency = $data['currency'];

        $payment = new Payment($paymentId, 'transaction');
        if ($payment->exists()) {
            $data = [
                'transaction' => $paymentId,
                'amount_cents' => Store::toCents($orderAmount),
                'currency' => $currency,
                'fee_cents' => '0'
            ];
        } else {
            $data = [
                'order_id' => $paymentId,
                'gateway_id' => $this->getId(),
                'transaction' => $paymentId,
                'amount_cents' => Store::toCents($orderAmount),
                'currency' => $currency,
                'fee_cents' => '0'
            ];
        }

        $payment->handlePaymentEvent(Payment::COMPLETED, $data);
    }

}

$gateway = new FREEKASSA_Gateway();