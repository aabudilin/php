# Описание скриптов

#### get_instagram.php
Класс для получения постов-картинок с помощью Instagram API, для использования нужен токен, [как получить токен](https://habr.com/ru/sandbox/141670/) 

Токен обновляется автоматически, и хранится в текстовом файле, путь необходимо настроить под себя, и туда записать полученный токен

Пример кода
```php
$insta = new GetInstagram();
foreach($insta as $item) {
  echo '<img src="'.$item->media_url" />';
}
```
