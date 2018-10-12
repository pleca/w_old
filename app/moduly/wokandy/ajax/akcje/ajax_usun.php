<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
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
	
	if($akcja === 'sad_usun'){		
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
				
		$db->usun_wartosc('slownik_sad', $id);
		
		dodaj_wpis_histori($id, 'sad_id', 'Usunięcie Sądu', '', '' , 'slownik_sad_historia_zmian');
		
		$dane = array(
				0 => 1
				,1 => 'Sąd został usunięty!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'wokanda_usun'){
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
	
		$db->usun_wartosc('wokanda', $id);
	
		dodaj_wpis_histori($id, 'wokanda_id', 'Usunięcie wokandy', '', '' , 'wokanda_historia_zmian');
	
		$dane = array(
				0 => 1
				,1 => 'Wokanda została usunięta!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'substytut_usun'){
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
	
		$db->usun_wartosc('substytut', $id);
	
		dodaj_wpis_histori($id, 'substytut_id', 'Usunięcie substytuta', '', '' , 'substytut_historia_zmian');
	
		$dane = array(
				0 => 1
				,1 => 'Substytut został usunięty!!!'
		);
		echo json_encode($dane);
		return;
	}
	
