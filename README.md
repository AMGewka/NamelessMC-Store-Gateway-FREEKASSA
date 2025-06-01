# FreeKassa Gateway Integration for NamelessMC Store

This module integrates the [FreeKassa](https://freekassa.ru) payment system into the NamelessMC Store plugin. It provides basic support for payments and a simple callback verification mechanism.

---

## 🛡️ Security

- All payments are signed using a secret key (`secret_key_1`)
- Callback (pingback) verification uses `md5` hash: `md5(merchant_id:amount:secret_key_2:order_id)`
- Redirection is secured via signature to prevent data spoofing

---

## ⚙️ Functionality Overview

### ✅ Payment Acceptance

- Uses `https://pay.freekassa.ru/` for redirect-based payment
- Includes:
    - `m` - merchant ID
    - `oa` - amount
    - `o` - order ID
    - `s` - MD5 signature
- No subscriptions or recurring payments supported
- Requires manual callback verification via `/store/listener?gateway=FreeKassa`

### 💰 Account Balance (Optional)

- Supported through API: `https://api.fk.life/v1/balance`
- Requires API ID and API Key
- Used to display real-time account balance inside admin panel

---

## 🌐 Supported Currencies

- RUB (default)
- USD
- EUR
- and others depending on merchant account settings

---

## 🧱 API Architecture

- Uses HTTP GET for payment redirection
- Callback verification via POST with hash
- Balance check via `X-API-KEY` header (optional)

---

## 🧩 NamelessMC Store Compatibility

- Fully integrated with Store v1.8.3+
- Uses:
    - `GatewayBase`
    - `Order`, `Customer`, `URL`, `Language`
    - `Token::check`, `Session::flash`
- Admin settings UI via `settings.tpl`
- Language files in JSON format (`ru_RU`, `en_UK`, `uk_UA`)

---

## ⚠️ Limitations

- Does not support subscriptions
- Payment confirmation relies on manual pingback matching
- No built-in fraud prevention or dispute management
- Uses `md5` for hashing (less secure than HMAC)

---

## 🔗 Documentation

- [FreeKassa Integration Guide](https://docs.freekassa.net/)
- [NamelessMC Store Module](https://github.com/partydragen/Nameless-Store)
