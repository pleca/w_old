<?php

if ( !defined('APP_PATH') )
	define('APP_PATH', dirname(__FILE__) . '/');

if (session_status() === PHP_SESSION_NONE){
		session_start();
	}
	
require_once APP_PATH.'app/autoload.php';

pobierz_Naglowek();

if(isset($_GET['bilet']) && !empty($_GET['bilet'])){
	zaladuj_Widok('widok_pasek_gorny', 'ustaw hasło');
	echo '<section id="zawartosc_strony">';
		zaladuj_Widok('widok_ustaw_nowe_haslo','');
	echo '</section>';
}else{
	if(czy_zalogowany()){
		zaladuj_Widok('widok_pasek_gorny', 'strona główna');
		zaladuj_Widok('widok_menu_boczne', '');
		zaladuj_Widok('widok_licznik_sesji', '');
		echo '<section id="zawartosc_strony">';
		zaladuj_Widok('widok_strona_glowna','');
		echo '</section>';
	}else{
		zaladuj_Widok('widok_pasek_gorny', 'panel logowania');
		echo '<section id="zawartosc_strony">';
		zaladuj_Widok('widok_panel_logowania','');
		echo '</section>';
	}
}



pobierz_Stopke();


