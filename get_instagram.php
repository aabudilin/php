<?
class GetInstagram {
  private $token;
  private $path;

  function __construct() {
    $this->path = $_SERVER['DOCUMENT_ROOT'].'/php/insta_token.txt';
    $this->token = $this->get_token();
    $this->chek_token();
  }

  public function set_token($token) {
    $this->token = $token;
  }

  public function get_media() {
    $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $this->token;
    $instagramCnct = curl_init(); // инициализация cURL подключения
    curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
    curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
    $media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
    curl_close($instagramCnct); // закрываем соединение
    return $media;
  }

  public function get_json() {
    $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $this->token;
    $instagramCnct = curl_init(); // инициализация cURL подключения
    curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
    curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
    $media = curl_exec($instagramCnct); // получаем и декодируем данные из JSON
    curl_close($instagramCnct); // закрываем соединение
    return $media;
  }

  private function update_token() {
    $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $this->token;
    $instagramCnct = curl_init(); // инициализация cURL подключения
    curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
    curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
    $response = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
    curl_close($instagramCnct); // закрываем соединение
    $accessToken = $response->access_token; // обновленный токен
    return $accessToken;
  }

  private function get_token() {
    $token = file_get_contents($this->path);
    return $token;
  }

  private function save_token($token) {
    file_put_contants($this->path);
  }

  private function chek_token() {
    $media = $this->get_media();
    //Если токен ошибочный обновляем его
    if (!$media->data) {
      $this->token = $this->update_token();
      $this->save_token($this->token);
    }
  }
}
?>