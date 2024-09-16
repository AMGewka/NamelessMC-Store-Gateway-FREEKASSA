<form action="" method="post">
    <div class="card shadow border-left-primary">
        <div class="card-body">
            <h5><i class="icon fa fa-info-circle"></i> Платежная система <a href="https://freekassa.ru/auth/registration" target="_blank">FREEKASSA</a></h5></br>
            - <b>Банковские карты</b>: <b>Карты РФ (МИР\VISA\MasterCard)</b> и <b>Карты Казахстана (KZT\VISA\MasterCard)</b></br>
            - <b>Электронные платежи</b>: <b>Оплата скинами (Steam)</b>, <b>СБЕР Pay</b>, <b>Онлайн банк</b> и <b>СБП</b></br>
            - <b>Электронные кошельки</b>: <b>Perfect Money USD</b> и <b>ЮMoney</b></br>
            - <b>Криптовалюты</b>: <b>Garantex</b>, <b>Bitcoin</b>, <b>Litecoin</b>, <b>Ethereum</b>, <b>USDT (ERC20)</b>, <b>USDT (TRC20)</b>, <b>TON</b>, <b>BNB</b> и <b>Tron</b></br></br>
            - Для регистрации в <b>FREEKASSA</b> используйте <a href="https://freekassa.ru/auth/registration" target="_blank">эту ссылку</a>.</br>
            - Модуль прошел тесты и работает на версиях магазина 1.7.1 и выше.</br>
            - <b>URL Оповещения:</b> https://<Ваш домен>/store/listener/?gateway=FREEKASSA</br>
            - <b>URL успешной оплаты:</b> https://<Ваш домен>/store/checkout/?do=complete</br>
            - <b>URL неудачной оплаты:</b> На ваш выбор :)
        </div>
    </div>

    <br />


<form action="" method="post"><div class="form-group"><label for="inputFREEKASSAId">ID магазина</label>
<input class="form-control" type="text" id="inputFREEKASSAShopId" name="shopid_key" value="{$SHOP_ID_VALUE}" placeholder="ID магазина">
</div>

<form action="" method="post"><div class="form-group"><label for="inputFREEKASSAapi">API магазина</label>
<input class="form-control" type="text" id="inputFREEKASSAShopapi" name="shopapi_key" value="{$SHOP_API_VALUE}" placeholder="API магазина">
</div>

<div class="form-group"><label for="inputFREEKASSAApiKey">Секретный ключ 1</label>
<input class="form-control" type="text" id="inputFREEKASSAApiKey" name="secret1_key" value="{$SHOP_API_KEY_VALUE}" placeholder="Секретный ключ 1">
</div>

<div class="form-group"><label for="inputFREEKASSAApiKey2">Секретный ключ 2</label>
<input class="form-control" type="text" id="inputFREEKASSAApiKey2" name="secret2_key" value="{$SHOP_API_KEY_2_VALUE}" placeholder="Секретный ключ 2">
</div>

<div class="form-group custom-control custom-switch">
<input id="inputEnabled" name="enable" type="checkbox" class="custom-control-input"{if $ENABLE_VALUE eq 1} checked{/if} />
<label class="custom-control-label" for="inputEnabled">Включить способ оплаты</label>
</div>

<div class="form-group"><input type="hidden" name="token" value="{$TOKEN}"><input type="submit" value="{$SUBMIT}" class="btn btn-primary">
</div>
</form>