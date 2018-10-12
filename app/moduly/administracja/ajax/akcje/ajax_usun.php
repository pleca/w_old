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
	
	if($akcja === 'uzytkownik_usun'){
		$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
		
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
				
		$db->usun_wartosc('uzytkownik', $id);
		
		dodaj_wpis_histori($id, 'uzytkownik_id', 'Usunięcie użytkownika', '', '' , 'uzytkownik_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Użytkownik został usunięty!!!'
		);
		echo json_encode($dane);
		return;
		
	}
	
	if($akcja === 'uzytkownik_usun_uprawnienie'){
		$uzytkownik_id = (isset($_POST['uzytkownik_id'])) ? htmlspecialchars($_POST['uzytkownik_id']) : '' ;
		$element_id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;
		$uprawnienie_rodzaj = (isset($_POST['uprawnienie_rodzaj'])) ? htmlspecialchars($_POST['uprawnienie_rodzaj']) : '' ;
	
		$tabela = 'uzytkownik_id_uzytkownik_uprawnienia'.$uprawnienie_rodzaj.'_id';
	
		$wartosc_where = 'uzytkownik_id = '.$uzytkownik_id.' AND uzytkownik_uprawnienia'.$uprawnienie_rodzaj.'_id = '.$element_id;
		
	
		$db->delete_wartosc($tabela, $wartosc_where);
		
		
		$nazwa_uprawnienia = $db->pobierz_konkretne_wartosci_where('wartosc', 'uzytkownik_uprawnienia'.$uprawnienie_rodzaj, 'id', $element_id);
		$nazwa_uprawnienia = $nazwa_uprawnienia->fetch_object();
		dodaj_wpis_histori($uzytkownik_id, 'uzytkownik_id', 'Usunięcie uprawnienia', $nazwa_uprawnienia->wartosc, '' , 'uzytkownik_historia_zmian');
		
		$dane = array(
				0 => 2
				,1 => 'Usunięto uprawnienie!!!'
		);
		echo json_encode($dane);
		return;
	}