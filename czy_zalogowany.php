<?php
	if(!isset($_SERVER['HTTP_REFERER'])){
		session_start();
		session_destroy();
		header ( 'Location: https://'.$_SERVER ['HTTP_HOST'] );
		die();
	}
	
	if ( !defined('APP_PATH') )
		define('APP_PATH', dirname(__FILE__) . '/');
	
	if (session_status() === PHP_SESSION_NONE){
		session_start();
	}
		
	require_once APP_PATH.'app/autoload.php';
	
	if(isset($_SESSION['uzytkownik']) AND is_serialized($_SESSION['uzytkownik'])){
		$uzytkownik = maybe_unserialize($_SESSION['uzytkownik']);	
		
		
		if(!$uzytkownik->__Get('_zalogowany')){
			session_destroy();
			header ( 'Location: https://'.$_SERVER ['HTTP_HOST'] );
			die();
		}
	
	}
	
	if(isset($_SESSION['polaczenie_do_bazy']) AND is_serialized($_SESSION['polaczenie_do_bazy'])){
		$db = maybe_unserialize($_SESSION['polaczenie_do_bazy']);
	}else{
		$db = new baza_danych();
		$_SESSION['polaczenie_do_bazy'] = maybe_serialize($db);
	}

