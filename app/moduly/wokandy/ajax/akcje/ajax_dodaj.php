<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
	
	if($akcja === ''){
		$dane = array(
				0 => 0
				,1 => 'Brak akcji do wykonania!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'sad_dodaj'){
		$nazwa = (isset($_POST['nazwa'])) ? htmlspecialchars($_POST['nazwa']) : '' ;
		$ulica = (isset($_POST['ulica'])) ? htmlspecialchars($_POST['ulica']) : '' ;
		$miasto = (isset($_POST['miasto'])) ? htmlspecialchars($_POST['miasto']) : '' ;
		$kod_pocztowy = (isset($_POST['kod_pocztowy'])) ? htmlspecialchars($_POST['kod_pocztowy']) : '' ;
		$wojewodztwo_id = (isset($_POST['wojewodztwo_id'])) ? htmlspecialchars($_POST['wojewodztwo_id']) : '' ;
		$typ_id = (isset($_POST['typ_id'])) ? htmlspecialchars($_POST['typ_id']) : '' ;
		
		$sad_dane = array(
				'nazwa' => $miasto
				,'wojewodztwo_id' => $wojewodztwo_id
				,'czy_usuniety' => '0'
		);
		
		$miasto_id = $db->wywolaj_procedure('slownik_miasto_aktualizuj_lub_dodaj_miasto', $sad_dane, 1);
		
		$sad_dane = array(
				'nazwa' => $nazwa
				,'ulica' => $ulica
				,'miasto_id' => $miasto_id
				,'kod_pocztowy' => $kod_pocztowy
				,'slownik_sad_typ_id' => $typ_id
		);
		
		$id = $db->wstaw_wartosc('slownik_sad', $sad_dane);
		
		dodaj_wpis_histori($id, 'sad_id', 'Utworzenie sądu', '', $nazwa, 'slownik_sad_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
                ,2 => $id
		);
		echo json_encode($dane);
		return;
	}

	if($akcja === 'substytut_dodaj'){
		$imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
		$nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
		$koszt_stawiennictwa_domyslny = (isset($_POST['koszt_stawiennictwa_domyslny'])) ? htmlspecialchars($_POST['koszt_stawiennictwa_domyslny']) : '' ;
		$forma_platnosci_id_domyslna = (isset($_POST['forma_platnosci_id_domyslna'])) ? htmlspecialchars($_POST['forma_platnosci_id_domyslna']) : '' ;
		$slownik_substytut_uprawnienia_id = (isset($_POST['slownik_substytut_uprawnienia_id'])) ? htmlspecialchars($_POST['slownik_substytut_uprawnienia_id']) : '' ;
		$ulica = (isset($_POST['ulica'])) ? htmlspecialchars($_POST['ulica']) : '' ;
		$miasto = (isset($_POST['miasto'])) ? htmlspecialchars($_POST['miasto']) : '' ;
		$wojewodztwo_id = (isset($_POST['wojewodztwo_id'])) ? htmlspecialchars($_POST['wojewodztwo_id']) : '' ;
		$kod_pocztowy = (isset($_POST['kod_pocztowy'])) ? htmlspecialchars($_POST['kod_pocztowy']) : '' ;
		$email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '' ;
		$nr_telefonu = (isset($_POST['nr_telefonu'])) ? htmlspecialchars($_POST['nr_telefonu']) : '' ;
		$email2 = (isset($_POST['email2'])) ? htmlspecialchars($_POST['email2']) : '' ;
		$opis = (isset($_POST['opis'])) ? htmlspecialchars($_POST['opis']) : '' ;
		$czy_votum = (isset($_POST['czy_votum'])) ? htmlspecialchars($_POST['czy_votum']) : '' ;
		
		$miasto_dane = array(
				'nazwa' => $miasto
				,'wojewodztwo_id' => $wojewodztwo_id
				,'czy_usuniety' => '0'
		);
		
		$miasto_id = $db->wywolaj_procedure('slownik_miasto_aktualizuj_lub_dodaj_miasto', $miasto_dane, 1);
		
		$substytut_dane = array(
				'id' => '0'
				,'imie' => $imie
				,'nazwisko' => $nazwisko
				,'koszt_stawiennictwa_domyslny' => $koszt_stawiennictwa_domyslny
				,'forma_platnosci_id_domyslna' => $forma_platnosci_id_domyslna
				,'nazwa' => $imie.' '.$nazwisko
				,'czy_usuniety' => '0'
				,'ulica' => $ulica
				,'miasto_id' => $miasto_id
				,'kod_pocztowy' => $kod_pocztowy
				,'uprawnienia_id' => $slownik_substytut_uprawnienia_id
				,'nr_telefonu' => $nr_telefonu
				,'email' => $email
				,'email2' => $email2
				,'opis' => $opis
				,'czy_votum' => $czy_votum
		);

		$id = $db->wywolaj_procedure('substytut_aktualizuj_lub_dodaj_substytut', $substytut_dane, 1);
		
		dodaj_wpis_histori($id, 'substytut_id', 'Dodanie substytuta', '', $imie.' '.$nazwisko, 'substytut_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Substytut został dodany!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	