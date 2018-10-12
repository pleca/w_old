<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
	$i = 0;
	
	if($akcja === ''){
		$dane = array(
				0 => 0
				,1 => 'Brak akcji do wykonania!!!'
		);
		echo json_encode($dane);
		return;
	}
		 	
	if($akcja === 'uzytkownik_dodaj'){
		$login = (isset($_POST['login'])) ? htmlspecialchars($_POST['login']) : '' ;
		
		$czy_istnieje = $db->pobierz_wartosc('login', 'uzytkownik', 'login', $login);
			
		if(!empty($czy_istnieje->login)){
			$dane = array(
				0 => 0
				,1 => 'Użytkownik o podanym loginie istnieje!!!'
			);
			echo json_encode($dane);
			return;
		}
		
		$haslo = (isset($_POST['haslo'])) ? htmlspecialchars($_POST['haslo']) : '' ;
		$imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
		$nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
		$email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '' ;
		$telefon = (isset($_POST['telefon'])) ? htmlspecialchars($_POST['telefon']) : '' ;
		
		if(empty($login) || empty($haslo) || empty($imie) || empty($nazwisko) || empty($email) || empty($telefon)){
			$dane = array(
					0 => 0
					,1 => 'Uzupełnij wszystkie pola!!!'
			);
			echo json_encode($dane);
			return;
		}
		
		$haslo = password_hash ( $haslo, PASSWORD_BCRYPT, $options_pass );
		
		$uzytkownik_dane = array(
				'login' => $login
				,'haslo' => $haslo
				,'imie' => $imie
				,'nazwisko' => $nazwisko
				,'email' => $email
				,'telefon' => $telefon
		);
		
		$id = $db->wstaw_wartosc('uzytkownik', $uzytkownik_dane);
				
		dodaj_wpis_histori($id, 'uzytkownik_id', 'Utworzenie konta', '', $login, 'uzytkownik_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Użytkownik został dodany!!!'
				,2 => $id
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'uzytkownik_dodaj_uprawnienie'){
		$uzytkownik_id = (isset($_POST['uzytkownik_id'])) ? htmlspecialchars($_POST['uzytkownik_id']) : '' ;
		$element_id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;
		$uprawnienie_rodzaj = (isset($_POST['uprawnienie_rodzaj'])) ? htmlspecialchars($_POST['uprawnienie_rodzaj']) : '' ;

		$tabela = 'uzytkownik_id_uzytkownik_uprawnienia'.$uprawnienie_rodzaj.'_id';
		
		$insert = array(
				'uzytkownik_id' => $uzytkownik_id
				,'uzytkownik_uprawnienia'.$uprawnienie_rodzaj.'_id' => $element_id
		);
		
		$db->wstaw_wartosc($tabela, $insert);
		
		$nazwa_uprawnienia = $db->pobierz_konkretne_wartosci_where('wartosc', 'uzytkownik_uprawnienia'.$uprawnienie_rodzaj, 'id', $element_id);
		$nazwa_uprawnienia = $nazwa_uprawnienia->fetch_object();
		dodaj_wpis_histori($uzytkownik_id, 'uzytkownik_id', 'Nadano uprawnienie', $nazwa_uprawnienia->wartosc, '' , 'uzytkownik_historia_zmian');
				
		$dane = array(
				0 => 1
				,1 => 'Nadano uprawnienie!!!'
		);
		echo json_encode($dane);
		return;
	}
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	