<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	/*$2y$11$QlJNSD8/Tmt9IUdZIzM6NO9pVm.Kj.1cA205JtIM6FM8iG7XOCTdi*/

	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
	$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	
	if($akcja === ''){
		$dane = array(
				0 => 0
				,1 => 'Brak akcji do wykonania!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'uzytkownik_aktualizuj'){
				
		$imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
		$nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
		$email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '' ;
		$telefon = (isset($_POST['telefon'])) ? htmlspecialchars($_POST['telefon']) : '' ;
		$haslo = (isset($_POST['haslo'])) ? htmlspecialchars($_POST['haslo']) : '' ;
		
		/*if(empty($imie) || empty($nazwisko) || empty($email) || empty($telefon)){
			$dane = array(
					0 => 0
					,1 => 'Nie wykryto zmian!!!'
			);
			echo json_encode($dane);
			return;
		}*/
		
		$uzytkownik_dane = array(
				'imie' => $imie
				,'nazwisko' => $nazwisko
				,'email' => $email
				,'telefon' => $telefon
		);
		
		if($haslo !== ''){
			$haslo = password_hash ( $haslo, PASSWORD_BCRYPT, $options_pass );
			$uzytkownik_dane['haslo'] = $haslo;
			
			dodaj_wpis_histori($id, 'uzytkownik_id', 'Zmiana hasła', '', '', 'uzytkownik_historia_zmian');
			
		}
		
		foreach($uzytkownik_dane as $klucz => $wartosc){
			if($wartosc !== ''){
				$wartosc_tabela = $db->pobierz_wartosc($klucz, 'uzytkownik', 'id', $id);
				dodaj_wpis_histori($id, 'uzytkownik_id', 'Zmiana - '.mb_ucfirst($klucz), $wartosc_tabela->$klucz, $wartosc, 'uzytkownik_historia_zmian');	
			}				
		}
		
		$db->aktualizuj_wartosc('uzytkownik', $uzytkownik_dane, $id);
					
		if($id === $uzytkownik->__get('_id')){
			if($imie !== '' || $nazwisko !== ''){
					
				if($imie !== ''){
					$uzytkownik->__set('_imie', $imie);
				}
					
				if($imie !== ''){
					$uzytkownik->__set('_nazwisko', $nazwisko);
				}
					
				aktualizuj_obiekt_w_sesji('uzytkownik', $uzytkownik);
			}
		}
		
		
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'uzytkownik_aktualizuj_wartosc'){
		$pole_nazwa = (isset($_POST['pole_nazwa'])) ? htmlspecialchars($_POST['pole_nazwa']) : '' ;
		$pole_wartosc = (isset($_POST['pole_wartosc'])) ? htmlspecialchars($_POST['pole_wartosc']) : '' ;
		$nazwa_elementu = (isset($_POST['nazwa_elementu'])) ? htmlspecialchars($_POST['nazwa_elementu']) : '' ;
		
		$uzytkownik_dane = array(
				$pole_nazwa => $pole_wartosc
		);
		
		if($pole_nazwa === 'uzytkownik_grupy_id'){
			$grupa_id = $db->pobierz_wartosc('uzytkownik_grupy_id', 'uzytkownik', 'id', $id);
			$grupa_nazwa = $db->pobierz_wartosc('wartosc', 'uzytkownik_grupy', 'id', $grupa_id->uzytkownik_grupy_id);
			dodaj_wpis_histori($id, 'uzytkownik_id', 'Zmiana grupy', $grupa_nazwa->wartosc, $nazwa_elementu, 'uzytkownik_historia_zmian');
		}
		
		$db->aktualizuj_wartosc('uzytkownik', $uzytkownik_dane, $id);
		
		if($id === $uzytkownik->__get('_id')){
			$uzytkownik->__set('_uzytkownik_grupy_id', $pole_wartosc);
			aktualizuj_obiekt_w_sesji('uzytkownik', $uzytkownik);
		}
		
		
		
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
		);
		echo json_encode($dane);
		return;
		
	}
	
	if($akcja === 'uzytkownik_wyloguj'){	
		$uzytkownik_dane = array(
				'ostatnia_aktywna_sesja' => '0'
		);
	
		$db->aktualizuj_wartosc('uzytkownik', $uzytkownik_dane, $id);
		
		$dane = array(
				0 => 1
				,1 => 'Użytkownik został prawidłowo wylogowany!!!'
		);
		echo json_encode($dane);
		return;
	
	}
	

