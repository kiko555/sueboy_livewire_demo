# Livewire Demo

## 主要展示 Livewire 自動 Render 的核心價值

## Laravel Relation 及 With 使用方式

在開發時，在資料快速提取方面，有加速效果

## Windows 開發環境建立

https://sueboy.blogspot.com/2023/06/laravel-livewire-with-winnmp.html

## 在未啟動 container 前就先完成 composer install

因為如果是已經有寫程式了，有些套件得先下載，不然程式一起動，就會發生各種相依套件無法啟動的問題

這個 $(pwd) 是指程式碼所在的位置

```
docker run --rm -v $(pwd):/app composer install
```

## compose config for non bitnami docker????

```
command: bash -c "php artisan key:generate && php artisan migrate --force --seed && php artisan serve --host=0.0.0.0"
```

## 如果發 CSS 在 https 下無法正常的問題

因為 CSS 取用的方式有可能在反向代理下會出問題，
所以可以設計成，判斷環境是否是在 DEV 或 PROD，
做出不同的判斷。

```
//redirect http to https
if (App::environment('production')) {
    Url::forceScheme('https');
}
```

參考資料：

-   https://hoohoo.top/blog/laravel-asset-how-to-support-http/
-   https://www.jhanley.com/blog/laravel-redirecting-http-to-https/
