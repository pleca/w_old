<?php

function zaladujKlasy($class_name){
	require_once 'klasy/klasa_'.strtolower($class_name).'.php';
}

spl_autoload_register('zaladujKlasy');
	
require_once APP_PATH.'app/funkcje_glowne.php';
require_once APP_PATH.'app/config.php';