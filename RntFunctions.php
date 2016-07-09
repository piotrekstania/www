<?php

//funkcja sprawdza czy podana zmienna jest liczbą, jak nie to zwraca stirng NULL
private function numToStr($var) {
		if(empty($var)) return 'NULL';
		else if(!is_numeric($var)) return 'NULL';
		else return $var;
}

?>
