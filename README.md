# Developer-Service

## 說明

這是我個人習慣的開發模式，將業務邏輯寫在Service中。其靈感來自於Controller-Service-Repository設計模式，但簡化了Repository模式，把原本Repository的部分也改在Service處理。

這個主要是方便我快速調用Laravel Eloquent Model。因為習慣集中所有Eloquent Model，所以封裝了一些方法方便使用

# 安裝

```bash
composer require stormsq/developer-service
```

如果你的laravel <= 5.4或是你的Laravel專案沒有啟動自動擴充包導入，你需要在你的config/app.php下面引入：

```php
'providers' => [
     STORMSQ\Developer\DeveloperServiceProvider::class,
 ];
'aliases' => [
    'ServiceBuilder' => STORMSQ\Developer\ServiceBuilder::class,
 ],
```

別忘了生成一個設定檔

```bash
php artisan vendor:publish
```

你會在config底下看到一個developer.php

# 設定

config/developer.php

目前裡面有兩組可調整參數組，分別是Model與Presenter

Model只有一個placepath，是設定Eloquent Model的位置，預設是app底下

Presenter裡有以下：

```php
[
    'icon'=>[
        'useitag'=>true, //是否使用<i>標籤，如果設定為false則以下排序設定將失效
        'default'=>'fa fa-sort', //沒有排序時的i tag class參數
        'asc'=>'fa fa-sort-asc', // 順序時i tag class的參數
        'desc'=>'fa fa-sort-desc', //倒序時i tag class的參數
    ]
]

```



# 使用方法

## Service

產生一個Service

```bash
php artisan developer:make:service  "Service名稱" //Services/Admin/DemoService
```

**p.s.基本路徑是app/**

完成後你會在app/Services/Admin目錄下得到DemoService.php

```php

namespace App\Services\Admin;
use STORMSQ\Developer\ServiceBuilder;

class DemoService extends ServiceBuilder{

    public function __construct()
    {
        //
    }
}
```

你可以在這個Service裡面使用...

```php
$this->getModel("Eloquent Model名稱") //User
```

如果Eloquent Model是存在且正確的，則這個方法會返回該Eloquent Model

## Presenter

presenter是一個搭配blade使用的開發概念，將不好維護的blade語句獨立到presenter中，使用時再注入到blade

產生一個Presenter

```bash
php artisan developer:make:presenter "Presenter名稱" //Presenters/Admin/DemoPresenter
```

基本路徑與Service一樣，在app底下

```php
<?php
namespace App\Prestenters;
use STORMSQ\Developer\PresenterBuilder;

class DemoPresenter extends Presenter{

    public function __construct()
    {
        //
    }
}
```

presenter可用方法

getTableHeader(array)

參數array 格式為 '排序名'=>'欄位名稱'