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
	
	if($akcja === 'uzytkownik_przywroc'){
		$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
		
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
				
		$db->przywroc_wartosc('uzytkownik', $id);
		
		dodaj_wpis_histori($id, 'uzytkownik_id', 'Aktywowanie użytkownika', '', '' , 'uzytkownik_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Użytkownik został przywrócony!!!'
		);
		echo json_encode($dane);
		return;
		
	}