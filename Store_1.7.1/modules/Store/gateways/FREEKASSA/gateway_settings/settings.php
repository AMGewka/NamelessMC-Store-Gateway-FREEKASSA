<?php

/*
 *  Made by AMGewka
 *  https://github.com/AMGewka
 *
 *  License: MIT
 *
 *  Store module
 */
require_once(ROOT_PATH . '/modules/Store/classes/StoreConfig.php');
require_once(ROOT_PATH . '/modules/Store/config.php');
$freekassa_language = new Language(ROOT_PATH . '/modules/Store/gateways/FREEKASSA/language', LANGUAGE);

if (isset($store_conf) && is_array($store_conf)) {
    $GLOBALS['store_config'] = $store_conf;
}

if (Input::exists()) {
    if (Token::check()) {

        $settings = [
            'FREEKASSA/shopid_key' => $_POST['shopid_key'],
            'FREEKASSA/shopapi_key' => $_POST['shopapi_key'],
            'FREEKASSA/secret1_key' => $_POST['secret1_key'],
            'FREEKASSA/secret2_key' => $_POST['secret2_key']
        ];
        StoreConfig::set($settings);

        // Is this gateway enabled
        if (isset($_POST['enable']) && $_POST['enable'] == 'on') $enabled = 1;
        else $enabled = 0;

        DB::getInstance()->update('store_gateways', $gateway->getId(), [
            'enabled' => $enabled
        ]);

        Session::flash('gateways_success', $language->get('admin', 'successfully_updated'));
    } else
        $errors = [$language->get('general', 'invalid_token')];
}

$smarty->assign([
    'SETTINGS_TEMPLATE' => ROOT_PATH . '/modules/Store/gateways/FREEKASSA/gateway_settings/settings.tpl',
    'ENABLE_VALUE' => ((isset($enabled)) ? $enabled : $gateway->isEnabled()),
    'SHOP_ID_VALUE' => ((isset($_POST['shopid_key']) && $_POST['shopid_key']) ? Output::getClean(Input::get('shopid_key')) : StoreConfig::get('FREEKASSA.shopid_key')),
    'SHOP_API_VALUE' => ((isset($_POST['shopapi_key']) && $_POST['shopapi_key']) ? Output::getClean(Input::get('shopapi_key')) : StoreConfig::get('FREEKASSA.shopapi_key')),
    'SHOP_API_KEY_VALUE' => ((isset($_POST['secret1_key']) && $_POST['secret1_key']) ? Output::getClean(Input::get('secret1_key')) : StoreConfig::get('FREEKASSA.secret1_key')),
    'SHOP_API_KEY_2_VALUE' => ((isset($_POST['secret2_key']) && $_POST['secret2_key']) ? Output::getClean(Input::get('secret2_key')) : StoreConfig::get('FREEKASSA.secret2_key')),
    'SHOP_ID' => $freekassa_language->get('shopid'),
    'SHOP_KEY1' => $freekassa_language->get('key1'),
    'SHOP_KEY2' => $freekassa_language->get('key2'),
    'SHOP_API' => $freekassa_language->get('shopapi'),
    'ENABLE_GATEWAY' => $freekassa_language->get('enablegateway'),
    'GATEWAY_NAME' => $freekassa_language->get('gatewayname'),
    'BANK_CARD' => $freekassa_language->get('bankcard'),
    'ONLINE_PAYMENTS' => $freekassa_language->get('onlinepay'),
    'ONLINE_WALLET' => $freekassa_language->get('onlinewal'),
    'CRYPTOCURRENCIES' => $freekassa_language->get('crypto'),
    'GATEWAY_LINK' => $freekassa_language->get('gatewaylink'),
    'GATEWAY_TESTED' => $freekassa_language->get('gatewaytest'),
    'ALERT_URL' => $freekassa_language->get('alerturl'),
    'SUCCESS_URL' => $freekassa_language->get('sucurl'),
    'FAILED_URL' => $freekassa_language->get('failurl')
]);