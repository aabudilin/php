<?
class GetInstagram {
  private $token;
  private $path;
  private $log;

  function __construct() {
	$this->path = 'https://pushe.ru/php/insta_token.txt';
	echo $this->path;
	$this->log = false;
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
	if ($this->log) {
		echo 'Обновление токена<br />';
		echo 'Ответ сервера<br /><pre>';
		print_r($response);
	}
    return $accessToken;
  }

  private function get_token() {
    $token = file_get_contents($this->path);
	if ($this->log) {
		echo 'get_token - '.$token.'<br />';
	}
    return $token;
  }

  private function save_token($token) {
    $result = file_put_contents($this->path,$token);
	if ($this->log) {
		echo 'save_token - '.$result.'<br />';
	}
  }

  private function chek_token() {
    $media = $this->get_media();
    //Если токен ошибочный обновляем его
    if (!$media->data) {
	  $new_token = $this->update_token();
		if ($new_token) {
      		$this->token = $this->update_token();
		    $this->save_token($this->token);
		}
    }
  }

	public function logged() {
		$this->log = true;
	}
}
?>
