<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
		
	$lista_modulow = $uzytkownik->__get('_lista_przyznanych_modulow');
	$lista_stron = $uzytkownik->__get('_lista_przyznanych_stron');
	$lista_zakladek = $uzytkownik->__get('_lista_przyznanych_zakladek');
	$lista_uprawnien = $uzytkownik->__get('_lista_przyznanych_uprawnien');
	
	$dane = array(
			0 => json_encode($lista_modulow)
			,1 => json_encode($lista_stron)
			,2 => json_encode($lista_zakladek)
			,3 => json_encode($lista_uprawnien)
	);
	
	echo json_encode($dane);