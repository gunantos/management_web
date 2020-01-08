# management_web
[Document](https://andtho89.github.io/management_web/)

Control dan management license applikasi berbasi web, sehingga dapat mempermudah kita untuk melakukan update, kunci license maupun menghapus aplikasi

install:
>composer require morait/management-web


cara penggunaan:
```php
use ManagementWeb\Management;

$management = new ManagementWeb\Management(array('url'=>URL_JSON, 'email'=>YOUR_EMAIL));
$m::initialize();
```

atau

```php
use ManagementWeb\Management;
Management::$url = URL_JSON;
Management::$email = YOUR_EMAIL
Management::initialize();
```

Buat atau hasilkan json di URL_JSON anda dengan value
```
{
  "status": "active" 
}
```

status bisa diganti dengna
1. active = berarti dalam keadaan active
2. nonaktif = aplikasi akan muncul pemberitahuan license mati
3. hapus = aplikasi akan dihapus dari sistem
