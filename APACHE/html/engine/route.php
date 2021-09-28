<?php
/**
 * Route
 */
class route
{
	public $debug;
	public $uri;
	function __construct($debug_status)
	{
		$this->debug = $debug_status;
		$this->uri = $_SERVER['REQUEST_URI'];
	}

	function parse_uri(){
		if ($this->uri[-1] != '/') {
			$this->uri = $this->uri.'/';
			//echo '<h1>'.$page_uri.'</h1>';
		}
		return $this->uri;
	}
	//Функция для обоначения после какого / парсить данные
	// Пример: localhost/t/parsedataget/
	// Строка "parsedataget" находится после второго слеша с начала домена (/)
	// Отладка: Array ( [0] => [1] => t [2] => parsedataget [3] => )
	function parse_GET($index = 0){
		if ($index == 0){
			return explode('/', $this->uri);
		}else {
			return explode('/', $this->uri)[$index];
		}
	}
}
?>