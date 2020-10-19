<?

class Debug {

	public static $line = '-------------------------------';

	public static function log($path,$var) {
		$log = date('Y-m-d H:i:s') . ' / '.self::$line.PHP_EOL;
		$log .= 'script: '.$_SERVER['SCRIPT_NAME'].PHP_EOL;
		//Если это массив
		if(is_array($var)) {
			$log .= print_r($var, true).PHP_EOL;
		} else {
			$log .= $var.PHP_EOL;
		}
		$log .= PHP_EOL.PHP_EOL;

		self::write($path,$log);
	}

	public static function write($path,$var) {
		file_put_contents($path, $var . PHP_EOL, FILE_APPEND);
	}

}

?>
