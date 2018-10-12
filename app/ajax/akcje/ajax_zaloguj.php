<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$login = htmlspecialchars($_POST['login']);
	$haslo = htmlspecialchars($_POST['haslo']);
		
	//$haslo_w_bazie = $db->pobierz_wiersz('uzytkownik', 'login', $login);
	
	$haslo_w_bazie = $db->pobierz_konkretne_wartosci_where('haslo, id, czy_usuniety', 'uzytkownik', 'login', $login);
	$haslo_w_bazie = $haslo_w_bazie->fetch_object();
	
	if(empty($haslo_w_bazie->haslo)){
		$dane = array(
				0 => 2,
				1 => 'Podany użytkownik nie istnieje!!!'
		);
		
	}else if($haslo_w_bazie->czy_usuniety === '1'){
		dodaj_wpis_histori($haslo_w_bazie->id, 'uzytkownik_id', 'Logowanie', 'Wyłączone konto', $_SERVER['REMOTE_ADDR'], 'uzytkownik_historia_zmian');
		
		$dane = array(
				0 => 2,
				1 => 'Konto użytkownika zostało wyłączone!!!'
		);
	}else{
		$haslo_hash = password_hash ( $haslo, PASSWORD_BCRYPT, $options_pass );
		
		if(($haslo_w_bazie->haslo) === $haslo_hash){
			dodaj_wpis_histori($haslo_w_bazie->id, 'uzytkownik_id', 'Logowanie', 'Prawidłowe', $_SERVER['REMOTE_ADDR'], 'uzytkownik_historia_zmian');
							
			$uzytkownik = new uzytkownik($db, $login);
									
			$_SESSION['uzytkownik'] = maybe_serialize($uzytkownik);		
			
			$uzytkownik_dane = array(
					'ostatnia_aktywna_sesja' => session_id()
					,'data_ostatniego_logowania' => 'NOW()'
					
			);
			
			$db->aktualizuj_wartosc('uzytkownik', $uzytkownik_dane, $uzytkownik->__get('_id'));
					
			$dane = array(
					0 => 1
			);
		}else{
			dodaj_wpis_histori($haslo_w_bazie->id, 'uzytkownik_id', 'Logowanie', 'Błędne hasło', $_SERVER['REMOTE_ADDR'], 'uzytkownik_historia_zmian');
							
			$dane = array(
					0 => 0,
					1 => 'Błędny użytkownik lub hasło!!!'
			);
		}
	}
		
	echo json_encode($dane);
	
	
