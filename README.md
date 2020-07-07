# Описание скриптов

#### get_instagram.php
класс для получения постов-картинок с помощью Instagram API, для использования нужен токен, [как получить токен](https://habr.com/ru/sandbox/141670/)
Токен обновляется автоматически

Пример кода
```php
$insta = new GetInstagram();
foreach($insta as $item) {
  echo '<img src="'.$item->media_url" />';
}
```
