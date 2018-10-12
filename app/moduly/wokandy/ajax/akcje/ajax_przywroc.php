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
	
	if($akcja === 'sad_przywroc'){
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
	
		$db->przywroc_wartosc('slownik_sad', $id);
	
		dodaj_wpis_histori($id, 'sad_id', 'Przywrocenie Sądu', '', '' , 'slownik_sad_historia_zmian');
	
		$dane = array(
				0 => 1
				,1 => 'Sąd został usunięty!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'wokanda_przywroc'){
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
	
		$db->przywroc_wartosc('wokanda', $id);
	
		dodaj_wpis_histori($id, 'wokanda_id', 'Przywrócenie wokandy', '', '' , 'wokanda_historia_zmian');
	
		$dane = array(
				0 => 1
				,1 => 'Wokanda została przywrócona!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'substytut_przywroc'){
		if(empty($id)){
			$dane = array(
					0 => 0
					,1 => 'Błąd!!! BRAK "ID"!!!'
			);
			echo json_encode($dane);
			return;
		}
	
		$db->przywroc_wartosc('substytut', $id);
	
		dodaj_wpis_histori($id, 'substytut_id', 'Przywrócenie substytuta', '', '' , 'substytut_historia_zmian');
	
		$dane = array(
				0 => 1
				,1 => 'Substytut został aktywowany!!!'
		);
		echo json_encode($dane);
		return;
	}