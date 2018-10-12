<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
	
	if($akcja === 'sprawdz_aktywna_sesje'){
		$dane = array(
				0 => 0
		);
		
		$sesja_na_bazie = $db->pobierz_wartosc('ostatnia_aktywna_sesja', 'uzytkownik', 'id', $uzytkownik->__get('_id'));
		$sesja_aktywna = session_id();
		
		if($sesja_na_bazie->ostatnia_aktywna_sesja === $sesja_aktywna){
			$dane = array(
					0 => 1
			);
		}
		
	}
	
	echo json_encode($dane);
