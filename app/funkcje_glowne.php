<?php
mb_internal_encoding("UTF-8");

if (session_status() === PHP_SESSION_NONE){
		session_start();
	}

function adres_strony(){
	if($_SERVER['HTTPS'] === 'on'){
		$adres = 'https://'.$_SERVER['HTTP_HOST'].'/';
	}else{
		$adres = 'http://'.$_SERVER['HTTP_HOST'].'/';
	}	
	return $adres;
}

function tytul_strony(){
	return 'Wokandy | KAIRP';
}

function pobierz_Naglowek(){
	echo '<!DOCTYPE html>
			<html lang="pl_PL">
			<head>
				<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<script src="'.adres_strony().'app/js/funkcje"></script>



				<!--[if lt IE 9]>
					<script src="'.adres_strony().'js/html5.js"></script>
				<![endif]-->
				<link rel="shortcut icon" href="'.adres_strony().'favicon.png" />
				<link rel="shortcut icon" href="'.adres_strony().'favicon.ico" />
				
				<link rel="stylesheet" href="'.adres_strony().'app/css/normalize.css" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'app/css/bootstrap.css" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'app/css/font-awesome.css" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'app/css/animate.css" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'app/css/dataTables.bootstrap.css" type="text/css" />
                <link rel="stylesheet" href="'.adres_strony().'app/css/bootstrap-timepicker.css" type="text/css" />
                <link rel="stylesheet" href="'.adres_strony().'biblioteki/bootstrap-datetimepicer/css/bootstrap-datetimepicker.css" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'app/css/style.css" type="text/css" />		
				<link id="mobile_css" rel="stylesheet" href="" type="text/css" />
				<link rel="stylesheet" href="'.adres_strony().'biblioteki/telerik/styles/kendo.common.min.css" />
                <link rel="stylesheet" href="'.adres_strony().'biblioteki/telerik/styles/kendo.default.min.css" />
                <link rel="stylesheet" href="'.adres_strony().'biblioteki/telerik/styles/kendo.default.mobile.min.css" />
                <script class="skryptJs" type="text/javascript" src="'.adres_strony().'biblioteki/bootstrap-datetimepicer/js/bootstrap-datetimepicker.min.js"></script>
                <script class="skryptJs" type="text/javascript" src="'.adres_strony().'biblioteki/telerik/js/kendo.all.min.js"></script>
                <script class="skryptJs" type="text/javascript" src="'.adres_strony().'biblioteki/telerik/js/jszip.min.js"></script>
                <script class="skryptJs" type="text/javascript" src="'.adres_strony().'app/js/jquery.tabletojson.js"></script>
						
				<title>'.tytul_strony().'</title>
			</head>
			<body>
								
	';
	
}

function pobierz_Stopke(){
	echo '
    			
    			
    					
    			'.zaladuj_Widok('widok_pasek_dolny','').'
    			<div id="preloader">
    					<div class="preloader">
    						<div class="loader_info">Ładowanie...</div>
	    					<div class="spinner">
								<div class="double-bounce1"></div>
								<div class="double-bounce2"></div>   					
							</div> 
    					</div>					   				
				</div> 
    			<div class="load">
				   <div class="dot"></div>
				   <div class="outline"><span></span></div>
				</div>
    			<div class="modal_pop_up modal fade bs-example-modal-lg" id="myModal" role="dialog" aria-labelledby="myModalLabel" style="padding-right: 0px !important;">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h5 class="modal-title popup_tytul" id="myModalLabel"></h5>
				      </div>
				      <div id="popup_tresc" class="modal-body">
				        ...
				      </div>
				    </div>
				  </div>
				</div>
  			</body>
			</html>';
}

function czy_zalogowany(){
	if(isset($_SESSION['uzytkownik']) AND is_serialized($_SESSION['uzytkownik'])){
		$uzytkownik = unserialize($_SESSION['uzytkownik']);
		
		if($uzytkownik->__GET('_zalogowany') === true){
			return true;
		}		
	}
	return false;
}

function zaladuj_Widok($nazwa_pliku, $tytul_strony){
	
	$plik = $_SERVER['DOCUMENT_ROOT'].'app/widoki/'.$nazwa_pliku.'.php';
	
	if(file_exists($plik) AND is_readable($plik)){	
		if(!empty($tytul_strony)){
			$tytul = $tytul_strony;
		}
		$_SERVER['HTTP_REFERER'] = 'https://'.$_SERVER ['HTTP_HOST'];
		$logo = zaladuj_Logo();
		require_once $plik;		
	}
}

function zaladuj_Logo(){
	return '
			<section id="logo" class="margin_t_30">
				<div class="logo container"><p data-widok="strona_glowna" class="pull-right przeladuj_widok strona_glowna"><img src="'.adres_strony().'app/img/logo.png" /></p></div>
				<div class="clear_b"></div>
			</section>
	';
}

function is_serialized( $data, $strict = true ) {
	// if it isn't a string, it isn't serialized.
	if ( ! is_string( $data ) ) {
		return false;
	}
	$data = trim( $data );
	if ( 'N;' == $data ) {
		return true;
	}
	if ( strlen( $data ) < 4 ) {
		return false;
	}
	if ( ':' !== $data[1] ) {
		return false;
	}
	if ( $strict ) {
		$lastc = substr( $data, -1 );
		if ( ';' !== $lastc && '}' !== $lastc ) {
			return false;
		}
	} else {
		$semicolon = strpos( $data, ';' );
		$brace     = strpos( $data, '}' );
		// Either ; or } must exist.
		if ( false === $semicolon && false === $brace )
			return false;
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 )
				return false;
				if ( false !== $brace && $brace < 4 )
					return false;
	}
	$token = $data[0];
	switch ( $token ) {
		case 's' :
			if ( $strict ) {
				if ( '"' !== substr( $data, -2, 1 ) ) {
					return false;
				}
			} elseif ( false === strpos( $data, '"' ) ) {
				return false;
			}
			// or else fall through
		case 'a' :
		case 'O' :
			return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		case 'b' :
		case 'i' :
		case 'd' :
			$end = $strict ? '$' : '';
			return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
	}
	return false;
}

function maybe_unserialize( $original ) {
	if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
		return @unserialize( $original );
		return $original;
}

function maybe_serialize( $data ) {
	if ( is_array( $data ) || is_object( $data ) )
		return serialize( $data );

		// Double serialization is required for backward compatibility.
		// See https://core.trac.wordpress.org/ticket/12930
		// Also the world will end. See WP 3.6.1.
		if ( is_serialized( $data, false ) )
			return serialize( $data );

			return $data;
}

function gdzie_jestem(){
	
	echo '<div class="container gdzie_jestem">';
		echo '<div class="gdzie_jestem_tlo">';
			echo '<div title="Strona główna" data-widok="strona_glowna" class="gj_element strona_glowna text-uppercase ';
				echo ($_COOKIE['modul']) ? 'przeladuj_widok' : '' ;
			echo '">Strona główna</div>';		
			if(!empty($_COOKIE['modul'])){
				echo '<div id="'.$_COOKIE['modul'].'" data-modul="'.$_COOKIE['modul'].'" title="'.$_COOKIE['modul'].'" class="gj_element modul text-uppercase ';
					echo ($_COOKIE['strona'] OR $_COOKIE['zakladka']) ? 'przeladuj_widok' : '' ;
				echo '"><i class="fa fa-angle-double-right" aria-hidden="true"></i>
			'.$_COOKIE['modul'].'</div>';									
				if(!empty($_COOKIE['strona'])){
					echo '<div id="'.$_COOKIE['strona'].'" data-strona="'.$_COOKIE['strona'].'" data-modul="'.$_COOKIE['modul'].'" title="'.$_COOKIE['strona_tytul'].'" class="gj_element strona text-uppercase "><i class="fa fa-angle-double-right" aria-hidden="true"></i>
			'.$_COOKIE['strona_tytul'].'</div>';
				}else{
					if(!empty($_COOKIE['zakladka'])){
						echo '<div id="'.$_COOKIE['zakladka'].'" data-zakladka="'.$_COOKIE['zakladka'].'" data-modul="'.$_COOKIE['modul'].'" title="'.$_COOKIE['zakladka_tytul'].'" class="gj_element zakladka text-uppercase "><i class="fa fa-angle-double-right" aria-hidden="true"></i>
				'.$_COOKIE['zakladka_tytul'].'</div>';
					}
				}
			}			
			echo '<div class="clear_b"></div>';
		echo '</div>';
	echo'</div>';
	
}

function lista_modulow_stron_zakladek($rodzaj_tmp, $rodzic_tmp = NULL, $rodzic_nazwa_uproszczona = NULL){
	
	$sciezka = glob($_SERVER['DOCUMENT_ROOT'].'app/moduly/*', GLOB_ONLYDIR);
	$lista = [];
	$i = 0;
	
	if($rodzaj_tmp === 'moduly'){
		foreach($sciezka as $m){
			$mn = end(explode('/',$m));
			$lista[$i] = $mn;
			$i++;
		}
		
		return $lista;
	}
	
	$modul = $_COOKIE['modul'];
	$szukaj = array('?', 'php', '/', '*', 'Nazwa', ':', 'strona_', 'zakladka_', '.', '&lt;', '&gt;');
	
	if($rodzaj_tmp === 'strony'){
		$plik = 'strona_';
	}
	
	if($rodzaj_tmp === 'zakladki'){
		$plik = 'zakladka_';		
	}
	
	$sciezka = glob($_SERVER['DOCUMENT_ROOT'].'app/moduly/'.$modul.'/'.$rodzaj_tmp.'/{'.$plik.'}*.php', GLOB_BRACE);
	
	if(isset($_SESSION['polaczenie_do_bazy']) AND is_serialized($_SESSION['polaczenie_do_bazy'])){
		$db = maybe_unserialize($_SESSION['polaczenie_do_bazy']);
	}
	if(isset($_SESSION['uzytkownik']) AND is_serialized($_SESSION['uzytkownik'])){
		$uzytkownik = maybe_unserialize($_SESSION['uzytkownik']);
	}
	
	foreach($sciezka as $p){
		$pn = fgets(fopen($p, 'r'));
		$pn = htmlentities($pn);
		$pn = str_replace($szukaj, '', $pn);
		$pn = trim($pn);
		$pl = str_replace($szukaj, '',end(explode('/',$p)));
		
		$element_id = $db->pobierz_wartosc('id', 'uzytkownik_uprawnienia_'.$rodzaj_tmp, 'wartosc_uproszczona', $pl);
		if($rodzaj_tmp === 'strony' && is_null($rodzic_tmp)){
			if(!is_null($element_id)){
				if(in_array($element_id->id, $uzytkownik->__get('_lista_przyznanych_stron'))){
					$lista[$i] = array(
						'link' => $pl
						,'modul' => $modul
						,'nazwa' => $pn
					);
				}
			}
		}
		if($rodzaj_tmp === 'zakladki' && $rodzic_tmp === 'strony'){
			$strona_id = $db->pobierz_wartosc('uzytkownik_uprawnienia_strony_id', 'uzytkownik_uprawnienia_zakladki', 'wartosc_uproszczona', $pl);
			$strona_rodzic_id = $db->pobierz_wartosc('id', 'uzytkownik_uprawnienia_strony', 'wartosc_uproszczona', $rodzic_nazwa_uproszczona);

				if(!is_null($strona_id) && $strona_id->uzytkownik_uprawnienia_strony_id === $strona_rodzic_id->id){
					if(!is_null($element_id)){
						if(in_array($element_id->id, $uzytkownik->__get('_lista_przyznanych_zakladek'))){
							$lista[$i] = array(
									'link' => $pl
									,'modul' => $modul
									,'nazwa' => $pn
							);
						}
					}
				}
		}
				
		$i++;
	}
	
	return $lista;
	
}

function aktualizuj_obiekt_w_sesji($nazwa, $obiekt){
	$_SESSION[$nazwa] = maybe_serialize($obiekt);
}

function pobierz_liste_uprawnien($wartosc_ftmp, $tabela_ftmp, $id_ftmp){
	$db = maybe_unserialize( $_SESSION['polaczenie_do_bazy'] );
	
	$lista = array();
	$lista_tmp = $db->pobierz_konkretne_wartosci_where($wartosc_ftmp, $tabela_ftmp, 'uzytkownik_id', $id_ftmp);
		
	if(!is_null($lista_tmp)){
		$i=0;
		while($poj_lista_tmp = $lista_tmp->fetch_object()){
			$lista[$i] = $poj_lista_tmp->$wartosc_ftmp;
			$i++;
		}
	}
	
	return $lista;
}

function dodaj_wpis_histori($id_ftmp, $dotyczy_id_ftmp, $akcja_ftmp, $wprz_ftmp, $wpo_ftmp , $tabela_ftmp){
	
	$db = maybe_unserialize( $_SESSION['polaczenie_do_bazy'] );
	$zmiany_dokonal = '';
	
	if(isset($_SESSION['uzytkownik'])){		
		$uzytkownik = maybe_unserialize( $_SESSION['uzytkownik'] );
		$zmiany_dokonal = $uzytkownik->__get('_id');
	}
	
	
	$historiaDane = array(
			$dotyczy_id_ftmp => $id_ftmp
			,'data_zmiany' => 'NOW()'
			,'akcja' => $akcja_ftmp
			,'wartosc_przed_zmiana' => $wprz_ftmp
			,'wartosc_po_zmianie' => $wpo_ftmp
			,'uzytkownik_adres_ip' => $_SERVER['REMOTE_ADDR']
			,'zmiany_dokonal' => $zmiany_dokonal
	);
	
	$db->wstaw_wartosc($tabela_ftmp, $historiaDane);
	
}

function mb_ucfirst($s) {
	$l = mb_strlen($s);
	for($i=0;$i<$l;$i++) {
		$z = mb_strtolower(mb_substr($s,$i,1));
		if(preg_replace('/[0-9a-ząćęłńóśźż]/','',$z)==='')
			return mb_strtoupper(mb_substr($s,0,$i+1)).mb_substr($s,$i+1);
	}
	return $s;
}

function zakladka_historia($historia_element, $kolumna, $db, $element_id){
	
	$lista_historia_dat = $db->pobierz_konkretne_wartosci_where('distinct cast(data_zmiany as date) as `data`', $historia_element, $kolumna, $element_id, 'order by `data` DESC');
	
	if(is_null($lista_historia_dat)){
		echo 'Brak danych...';
	}else{
		while ($poj_lista_historia_dat = $lista_historia_dat->fetch_object()) {
			$lista_historia_zmian = $db->pobierz_wartosci_where($historia_element, 'cast(data_zmiany as date) = "'.$poj_lista_historia_dat->data.'" AND '.$kolumna.' = '.$element_id.' ORDER BY data_zmiany DESC ');
			echo '<div class="panel panel-default">';
				echo '<div class="panel-heading cursor_p">'.$poj_lista_historia_dat->data.'<span class="badge">'.$lista_historia_zmian->num_rows.'</span></div>';
				echo '<div class="panel-body">';
					echo '<div class="table-responsive moja_tabela">';
						echo '<table id="" class="tabela_historia table_data_table table table-striped table-hover">';
							echo '<thead>';
								echo '<tr>';
									echo '<th class="col-md-1">Data</th>';
										echo '<th class="col-md-3">Akcja</th>';
										echo '<th class="col-md-3">Przed</th>';
										echo '<th class="col-md-3">Po</th>';
										echo '<th class="ukryj">Adres IP</th>';
										echo '<th class="col-md-2">Edytował</th>';
										echo '<th class="ukryj"></th>';
									echo '</tr>';
								echo '</thead>';
							echo '<tbody>';														
								while ($poj_lista_historia_zmian = $lista_historia_zmian->fetch_object()) {
									$godzina = explode(' ',$poj_lista_historia_zmian->data_zmiany);
									$zmiany_dokonal_imie = '';
									$zmiany_dokonal_nazwisko = '';
									$zmiany_dokonal_id = '';
									
									$zmiany_dokonal = $db->pobierz_wartosc('imie, nazwisko', 'uzytkownik', 'id', $poj_lista_historia_zmian->zmiany_dokonal);
									if(!is_null($zmiany_dokonal)){
										$zmiany_dokonal_imie = $zmiany_dokonal->imie;
										$zmiany_dokonal_nazwisko = $zmiany_dokonal->nazwisko;
										$zmiany_dokonal_id = $poj_lista_historia_zmian->zmiany_dokonal;
									}	
										echo '<tr data-toggle="tooltip" data-placement="top" title="Adres IP: '.$poj_lista_historia_zmian->uzytkownik_adres_ip.'">';
											echo '<td class="col-md-1">'.$godzina[1].'</td>';
											echo '<td class="col-md-2">'.$poj_lista_historia_zmian->akcja.'</td>';
											echo '<td class="col-md-3">'.$poj_lista_historia_zmian->wartosc_przed_zmiana.'</td>';
											echo '<td class="col-md-3">'.$poj_lista_historia_zmian->wartosc_po_zmianie.'</td>';
											echo '<td class="ukryj">'.$poj_lista_historia_zmian->uzytkownik_adres_ip.'</td>';
											echo '<td class="col-md-2">'.$zmiany_dokonal_imie.' '.$zmiany_dokonal_nazwisko.'('.$zmiany_dokonal_id.')</td>';
											echo '<td class="ukryj"></td>';
										echo '</tr>';
								}														
							echo '</tbody>';
						echo '</table>';
					echo '</div>';														
				echo '</div>';
			echo '</div>';
		}
	}															

}

function mb_str_replace($search, $replace, $subject, &$count = 0) {
	if (!is_array($subject)) {
		// Normalize $search and $replace so they are both arrays of the same length
		$searches = is_array($search) ? array_values($search) : array($search);
		$replacements = is_array($replace) ? array_values($replace) : array($replace);
		$replacements = array_pad($replacements, count($searches), '');
		foreach ($searches as $key => $search) {
			$parts = mb_split(preg_quote($search), $subject);
			$count += count($parts) - 1;
			$subject = implode($replacements[$key], $parts);
		}
	} else {
		// Call mb_str_replace for each subject in array, recursively
		foreach ($subject as $key => $value) {
			$subject[$key] = mb_str_replace($search, $replace, $value, $count);
		}
	}
	return $subject;
}

function polacz_z_baza_ms_sql(){

	$server = '192.168.0.8';
	$username = 'wokanda';
	$password = '7kGUR5Epyr';
    $database = 'pce_votum';

	$connection = mssql_connect ( $server, $username, $password );

	if ($connection == FALSE) {
		die ( "Couldn't connect" );
	}

	if (! mssql_select_db ( $database, $connection )) {
		die ( 'Failed to select DB' );
	}

	return $connection;
}

function lista_wojewodz($id = null, $nazwa = null, $disabled = null){
	if(is_null($id)){
		$id = '';
		$nazwa = 'Wybierz województwo';
	}
	if($disabled == '1'){
		$disabled = 'disabled';
	}
	$db = maybe_unserialize($_SESSION['polaczenie_do_bazy']);
	echo '<div class="dropdown lista_wojewodztw ">';
		echo '<button class="btn btn-default wojewodztwo_id dropdown-toggle" '.$disabled.' type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
			echo '<span class="element_grupa_opcja_naglowek nazwa_woj sad_wojewodztwo " data-wartosc_domyslna="'.$id.'" value="'.$id.'" >'.mb_ucfirst($nazwa).'</span>';
			echo '<span class="caret"></span>';
		echo '</button>';
		echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
		    						
			$lista_wojewodztw = $db->pobierz_wiersze('slownik_wojewodztwo', 'czy_usuniety', '0');
				while ($poj_lista_wojewodztw = $lista_wojewodztw->fetch_object()) {
					echo '<li id="wojewodztwo_'.$poj_lista_wojewodztw->id.'" class="woj_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_wojewodztw->id === $id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_wojewodztw->nazwa).'" data-element_id="'.$poj_lista_wojewodztw->id.'">';
						echo '<i class="fa fa-check" aria-hidden="true"></i>';
						echo mb_ucfirst($poj_lista_wojewodztw->nazwa);
					echo '</li>';
				}
				
	 	echo '</ul>';
	echo '</div>';
}

function generuj_link_aktywacyjny($ciag_znakow){
	
	$liczba_rand = rand(); 
	$data = date("Y-m-d H:i:s");
	$liczba_rand2 = rand();
	
	return substr(md5($data.$liczba_rand).md5($liczba_rand2.$data.$ciag_znakow.$liczba_rand).md5($data.$liczba_rand2),0,80);
	
}

function wyslij_wiadomosc_mail($temat_tmp,$odbiorca_tmp,$tresc_tmp, $addLogo = true){
	
	$nazwa_nadawcy = 'KAiRP Wokandy';
	
	//wysylanie maila
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "zimbra.votum-sa.pl";
	$mail->SMTPAuth = true;
	$mail->Username = "automat@votum-sa.pl";
	$mail->Password = "BW8Y2VmX";
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->CharSet= "utf-8";
	$mail->From = "automat@votum-sa.pl";
	$mail->FromName = $nazwa_nadawcy;
	$mail->AddAddress ($odbiorca_tmp);
	$mail->IsHTML(true);
	$mail->Subject = $temat_tmp;
	$mail->Body    = $tresc_tmp;
	if($addLogo){
        $mail->AddEmbeddedImage($_SERVER ['DOCUMENT_ROOT'].'/app/img/logo.png', "mojelogo", 'logo.png');
    }

	
	if(!$mail->Send())
	{
		echo "Nie udało się wysłać maila. <p>";
		echo "Błąd: " . $mail->ErrorInfo;
		exit;
	
	}
	
}






















