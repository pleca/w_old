<?php

if(!isset($_SERVER['HTTP_REFERER'])){
		session_start();
		session_destroy();
		header ( 'Location: https://'.$_SERVER ['HTTP_HOST'] );
		die();
	}

if (session_status() === PHP_SESSION_NONE){
	session_start();
}

if(isset($_SESSION['uzytkownik']) && !empty($_SESSION['uzytkownik'])){
	echo '1';
	return;
}

echo '0';
