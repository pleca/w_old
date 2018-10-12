<?php

	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	$imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
	$nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
	$login = (isset($_POST['login'])) ? htmlspecialchars($_POST['login']) : '' ;
	$haslo = (isset($_POST['haslo'])) ? htmlspecialchars($_POST['haslo']) : '' ;
	
	$bilet = (isset($_POST['bilet'])) ? htmlspecialchars($_POST['bilet']) : '' ;
	
	if($id =='' || $imie =='' || $nazwisko =='' || $login =='' || $haslo =='' || $bilet ==''){
		$dane = array(
				0 => 0,
				1 => 'Błąd - Brak wartośći! Skontaktuj się z administratorem!'
		);
		
		echo json_encode($dane);
		return;
	}
	
	$uzytkownik_id = $db->pobierz_ogolne_zapytanie('uzytkownik', 'id', 'id = '.$id.' AND imie = "'.$imie.'" AND nazwisko = "'.$nazwisko.'" AND login = "'.$login.'" AND link_aktywacyjny = "'.$bilet.'"');
		
	if(is_null($uzytkownik_id)){
		$dane = array(
				0 => 0,
				1 => 'Błąd - Błędne wartości!!! Skontaktuj się z administratorem!!!'
		);
		
		echo json_encode($dane);
		return;
	}
	
	$haslo_hash = password_hash ( $haslo, PASSWORD_BCRYPT, $options_pass );
	$aktualna_data = date("Y-m-d H:i:s"); 
	
	$wartosci = array(
			'haslo' => $haslo_hash
			,'ostatnia_aktywna_sesja' => '0'
			,'link_aktywacyjny' => 'null'
			,'data_zmiana_hasla' => $aktualna_data
	);
	
	$db->aktualizuj_wartosc('uzytkownik', $wartosci, $uzytkownik_id->id);
	
	dodaj_wpis_histori($uzytkownik_id->id, 'uzytkownik_id', 'Zmiana hasła', '', $aktualna_data, 'uzytkownik_historia_zmian');
	
	$dane = array(
			0 => 1,
			1 => 'Hasło zostało pomyślnie zresetowane!!!'
	);
	
	echo json_encode($dane);




















