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
	
	if($akcja === 'aktualizuj_sad'){
		$nazwa = (isset($_POST['nazwa'])) ? htmlspecialchars($_POST['nazwa']) : '' ;
		$ulica = (isset($_POST['ulica'])) ? htmlspecialchars($_POST['ulica']) : '' ;
		$miasto = (isset($_POST['miasto'])) ? htmlspecialchars($_POST['miasto']) : '' ;
		$kod_pocztowy = (isset($_POST['kod_pocztowy'])) ? htmlspecialchars($_POST['kod_pocztowy']) : '' ;
		if($kod_pocztowy != ''){
			$kod_pocztowy = substr($kod_pocztowy, 0, 6);
		}
		$wojewodztwo_id = (isset($_POST['wojewodztwo_id'])) ? htmlspecialchars($_POST['wojewodztwo_id']) : '' ;
		$typ_id = (isset($_POST['typ_id'])) ? htmlspecialchars($_POST['typ_id']) : '' ;
				
		if($miasto != '' || $wojewodztwo_id != ''){
			$sad_dane = array(
					'nazwa' => $miasto
					,'wojewodztwo_id' => $wojewodztwo_id
					,'czy_usuniety' => '0'
			);
			
			$miasto_sad_baza_przed = $db->pobierz_wartosc('miasto_id', 'slownik_sad', 'id', $id);
			$miasto_baza_przed = $db->pobierz_wiersz('slownik_miasto', 'id', $miasto_sad_baza_przed->miasto_id);
									
			$miasto_id = $db->wywolaj_procedure('slownik_miasto_aktualizuj_lub_dodaj_miasto', $sad_dane, 1);
			
			$miasto_baza_po = $db->pobierz_wiersz('slownik_miasto', 'id', $miasto_id);
			
			if($miasto_baza_przed->nazwa != $miasto_baza_po->nazwa){
				dodaj_wpis_histori($id, 'sad_id', 'Zmiana - Miasto', $miasto_baza_przed->nazwa, $miasto_baza_po->nazwa, 'slownik_sad_historia_zmian');
			}
			
						
			if($miasto_baza_przed->wojewodztwo_id != $miasto_baza_po->wojewodztwo_id){
				$woj_po = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $miasto_baza_po->wojewodztwo_id);
				$woj_przed = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $miasto_baza_przed->wojewodztwo_id);
				dodaj_wpis_histori($id, 'sad_id', 'Zmiana - Wojewodztwo', mb_ucfirst($woj_przed->nazwa), mb_ucfirst($woj_po->nazwa), 'slownik_sad_historia_zmian');					
			}
			
			
		}
								
		$sad_dane = array(
				'nazwa' => $nazwa
				,'ulica' => $ulica
				,'miasto_id' => $miasto_id
				,'kod_pocztowy' => $kod_pocztowy
		);
		
		
		foreach($sad_dane as $klucz => $wartosc){
			if($wartosc !== '' && $klucz !== 'miasto_id'){
				$wartosc_tabela = $db->pobierz_wartosc($klucz, 'slownik_sad', 'id', $id);
				
				$warosc_klucz = $klucz;
				
				if($klucz == 'kod_pocztowy'){
					$warosc_klucz = 'kod pocztowy';
				}
				
				dodaj_wpis_histori($id, 'sad_id', 'Zmiana - '.mb_ucfirst($warosc_klucz), $wartosc_tabela->$klucz, $wartosc, 'slownik_sad_historia_zmian');	
			}				
		}
		
		$db->aktualizuj_wartosc('slownik_sad', $sad_dane, $id);
		
		$slownik_sad_typ_przed = $db->pobierz_wartosc('slownik_sad_typ_id', 'slownik_sad', 'id', $id);

		if($slownik_sad_typ_przed->slownik_sad_typ_id != $typ_id){
			$sad_dane = array(
					'slownik_sad_typ_id' => $typ_id
			);
			
			$slownik_sad_typ_przed_nazwa = $db->pobierz_wartosc('wartosc', 'slownik_sad_typ', 'id', $slownik_sad_typ_przed->slownik_sad_typ_id);
			$slownik_sad_typ_po_nazwa = $db->pobierz_wartosc('wartosc', 'slownik_sad_typ', 'id', $typ_id);
				
			$db->aktualizuj_wartosc('slownik_sad', $sad_dane, $id);
			dodaj_wpis_histori($id, 'sad_id', 'Zmiana - Typ sądu', $slownik_sad_typ_przed_nazwa->wartosc, $slownik_sad_typ_po_nazwa->wartosc, 'slownik_sad_historia_zmian');
				
		}
						
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
		);
		echo json_encode($dane);
		return;
	
	}

	if($akcja === 'aktualizuj_czas'){
		$data = (isset($_POST['data'])) ? htmlspecialchars($_POST['data']) : '' ;
		$czas_start = (isset($_POST['czas_start'])) ? htmlspecialchars($_POST['czas_start']) : '' ;
		$czas_stop = (isset($_POST['czas_stop'])) ? htmlspecialchars($_POST['czas_stop']) : '' ;		
		
		$start_tmp = $data.' '.$czas_start;
		$stop_tmp = $data.' '.$czas_stop;
		
		$wokanda_dane = array(
				'start' => $start_tmp
				,'stop' => $stop_tmp
		);
		
		$wokanda_start_baza = $db->pobierz_wartosc('start', 'wokanda', 'id', $id);
		$wokanda_stop_baza = $db->pobierz_wartosc('stop', 'wokanda', 'id', $id);
		
		if($start_tmp != $wokanda_start_baza->start || $stop_tmp != $wokanda_stop_baza->stop){
			$wokanda_start_baza_tmp = explode(' ', $wokanda_start_baza->start);
			$wokanda_stop_baza_tmp = explode(' ', $wokanda_stop_baza->stop);
			$start_tmp_f = explode(' ', $start_tmp);
			$stop_tmp_f = explode(' ', $stop_tmp);
			
			if($start_tmp_f[0] != $wokanda_start_baza_tmp[0]){
				dodaj_wpis_histori($id, 'wokanda_id', 'Zmiana daty', $wokanda_start_baza_tmp[0], $start_tmp_f[0], 'wokanda_historia_zmian');
			}
			
			if($wokanda_start_baza_tmp[1] != $start_tmp_f[1] || $wokanda_stop_baza_tmp[1] != $stop_tmp_f[1]){
				dodaj_wpis_histori($id, 'wokanda_id', 'Zmiana czasu', 'od: '.$wokanda_start_baza_tmp[1].'<br/>do: '.$wokanda_stop_baza_tmp[1], 'od: '.$start_tmp_f[1].'<br/>do: '.$stop_tmp_f[1], 'wokanda_historia_zmian');
			}
			
			
		}
				
		$db->aktualizuj_wartosc('wokanda', $wokanda_dane, $id);
				
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'aktualizuj_substytuta'){
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
				
		$substytu_baza = $db->pobierz_wiersz('substytut', 'id', $id);
				
		if($imie != $substytu_baza->imie){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana imienia', $substytu_baza->imie, $imie, 'substytut_historia_zmian');				
		}
		
		if($koszt_stawiennictwa_domyslny != $substytu_baza->koszt_stawiennictwa_domyslny){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana kosztu', $substytu_baza->koszt_stawiennictwa_domyslny, $koszt_stawiennictwa_domyslny, 'substytut_historia_zmian');
		}
		
		if($nazwisko != $substytu_baza->nazwisko){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana nazwiska', $substytu_baza->nazwisko, $nazwisko, 'substytut_historia_zmian');
		}
		
		if($forma_platnosci_id_domyslna != $substytu_baza->forma_platnosci_id_domyslna){
			$forma_platnosci_wartosc_przed = $db->pobierz_wartosc('wartosc', 'slownik_substytut_forma_platnosci', 'id', $substytu_baza->forma_platnosci_id_domyslna);
			$forma_platnosci_wartosc_po = $db->pobierz_wartosc('wartosc', 'slownik_substytut_forma_platnosci', 'id', $forma_platnosci_id_domyslna);
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana formy płatnośći', mb_ucfirst($forma_platnosci_wartosc_przed->wartosc), mb_ucfirst($forma_platnosci_wartosc_po->wartosc), 'substytut_historia_zmian');
		}
		
		if($slownik_substytut_uprawnienia_id != $substytu_baza->slownik_substytut_uprawnienia_id){
			$ssu_przed = $db->pobierz_wartosc('wartosc', 'slownik_substytut_uprawnienia', 'id', $substytu_baza->slownik_substytut_uprawnienia_id);
			$ssu_po = $db->pobierz_wartosc('wartosc', 'slownik_substytut_uprawnienia', 'id', $slownik_substytut_uprawnienia_id);
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana uprawnień', mb_ucfirst($ssu_przed->wartosc), mb_ucfirst($ssu_po->wartosc), 'substytut_historia_zmian');
		}
		
		if($ulica != $substytu_baza->ulica){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana ulicy', $substytu_baza->ulica, $ulica, 'substytut_historia_zmian');
		}
		
		
		
		$miasto_dane = array(
				'nazwa' => $miasto
				,'wojewodztwo_id' => $wojewodztwo_id
				,'czy_usuniety' => '0'
		);
		
		$miasto_id = $db->wywolaj_procedure('slownik_miasto_aktualizuj_lub_dodaj_miasto', $miasto_dane, 1);
		
		$miasto_baza_przed = $db->pobierz_wiersz('slownik_miasto', 'id', $substytu_baza->slownik_miasto_id);
		$miasto_baza_po = $db->pobierz_wiersz('slownik_miasto', 'id', $miasto_id);
		
		if($miasto_baza_przed->nazwa != $miasto_baza_po->nazwa){

			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana miasta', mb_ucfirst($miasto_baza_przed->nazwa), mb_ucfirst($miasto_baza_po->nazwa), 'substytut_historia_zmian');
					
		}
				
		if($miasto_baza_przed->wojewodztwo_id != $miasto_baza_po->wojewodztwo_id){
			$woj_przed = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $miasto_baza_przed->wojewodztwo_id);
			$woj_po = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $miasto_baza_po->wojewodztwo_id);
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana województwa', mb_ucfirst($woj_przed->nazwa), mb_ucfirst($woj_po->nazwa), 'substytut_historia_zmian');
		}
		
		if($kod_pocztowy != $substytu_baza->kod_pocztowy){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana kod pocztowy', $substytu_baza->kod_pocztowy, $kod_pocztowy, 'substytut_historia_zmian');
		}
		
		if($email != $substytu_baza->email){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana email', $substytu_baza->email, $email, 'substytut_historia_zmian');
		}
		
		if($email2 != $substytu_baza->email2){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana email2', $substytu_baza->email2, $email2, 'substytut_historia_zmian');
		}
		
		if($nr_telefonu != $substytu_baza->nr_telefonu){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana telefon', $substytu_baza->nr_telefonu, $nr_telefonu, 'substytut_historia_zmian');
		}
		
		if($opis != $substytu_baza->opis){
			dodaj_wpis_histori($id, 'substytut_id', 'Zmiana opisu', $substytu_baza->opis, $opis, 'substytut_historia_zmian');
		}
		
		if($czy_votum != $substytu_baza->czy_votum){
			$czy_votum_przed = ($substytu_baza->czy_votum == '1') ? 'TAK' : 'NIE' ;
			$czy_votum_po = ($czy_votum == '1') ? 'TAK' : 'NIE' ;
			dodaj_wpis_histori($id, 'substytut_id', 'Czy z Kancelarii', $czy_votum_przed, $czy_votum_po, 'substytut_historia_zmian');
		}
		
		$substytut_dane = array(
				'id' => $id
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
		
		$db->wywolaj_procedure('substytut_aktualizuj_lub_dodaj_substytut', $substytut_dane, 1);
		
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	if($akcja === 'wokanda_zapisz'){
		$dane = (isset($_POST['dane'])) ? htmlspecialchars($_POST['dane']) : '' ;
		$dane = json_decode(str_replace('&quot;', '"', $dane), true);

		if($dane['id'] != ''){
			$wokanda_baza = $db->pobierz_wiersz('wokanda', 'id', $dane['id']);
		}
		$wokanda_sprawa_id_glowna = $dane['wokanda_sprawa_id_glowna'];
		if($dane['id'] != '0'){
			if($wokanda_baza->wokanda_sprawa_id_glowna != '0'){
				$sprawa_baza_przed = $db->pobierz_wiersz('wokanda_sprawa', 'id', $wokanda_baza->wokanda_sprawa_id_glowna);

				if($sprawa_baza_przed->klient_imie != $dane['klient_imie']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana klient imie', $sprawa_baza_przed->klient_imie , $dane['klient_imie'] , 'wokanda_historia_zmian');		
				}
				
				if($sprawa_baza_przed->klient_nazwisko != $dane['klient_nazwisko']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana klient nazwisko', $sprawa_baza_przed->klient_nazwisko , $dane['klient_nazwisko'] , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_prawnik != $dane['sprawa_prawnik']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana prawnika', $sprawa_baza_przed->sprawa_prawnik , $dane['sprawa_prawnik'] , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_druga_strona != $dane['sprawa_druga_strona']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana pozwany', $sprawa_baza_przed->sprawa_druga_strona , $dane['sprawa_druga_strona'] , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_pelnomocnik_glowny != $dane['sprawa_pelnomocnik_glowny']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana Pełnomocnik', $sprawa_baza_przed->sprawa_pelnomocnik_glowny , $dane['sprawa_pelnomocnik_glowny'] , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_pelnomocnik_kairp != $dane['sprawa_pelnomocnik_kairp']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana Pełnomocnik KAIRP', $sprawa_baza_przed->sprawa_pelnomocnik_kairp , $dane['sprawa_pelnomocnik_kairp'] , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_wps != $dane['sprawa_wps']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana WPS', $sprawa_baza_przed->sprawa_wps , $dane['sprawa_wps'] , 'wokanda_historia_zmian');
				}
                if($sprawa_baza_przed->sprawa_wps != $dane['sprawa_wpz']){
                    dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana WPZ', $sprawa_baza_przed->sprawa_wps , $dane['sprawa_wpz'] , 'wokanda_historia_zmian');
                }
				
				if($sprawa_baza_przed->slownik_wokanda_typ_umowy_id != $dane['slownik_wokanda_typ_umowy_id']){
					$tu_przed = $db->pobierz_wiersz('slownik_wokanda_typ_umowy', 'id', $sprawa_baza_przed->slownik_wokanda_typ_umowy_id);
					$tu_po = $db->pobierz_wiersz('slownik_wokanda_typ_umowy', 'id', $dane['slownik_wokanda_typ_umowy_id']);
					
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zmiana Umowy', mb_ucfirst($tu_przed->wartosc) , mb_ucfirst($tu_po->wartosc) , 'wokanda_historia_zmian');
				}
				
				if($sprawa_baza_przed->sprawa_zgoda_na_substytuta != $dane['sprawa_zgoda_na_substytuta']){
					dodaj_wpis_histori($wokanda_baza->id, 'wokanda_id', 'Zgoda na substytuta', ($sprawa_baza_przed->sprawa_zgoda_na_substytuta == '1') ? 'TAK' : 'NIE' , ($dane['sprawa_zgoda_na_substytuta'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
				}

                $sprawa_dane = array(
                    'id' => $dane['wokanda_sprawa_id_glowna']
                    ,'sprawa_pce_numer' => $dane['sprawa_pce_numer']
                    ,'sprawa_pce_id' => $dane['sprawa_pce_id']
                    ,'klient_imie' => $dane['klient_imie']
                    ,'klient_nazwisko' => $dane['klient_nazwisko']
                    ,'sprawa_prawnik' => $dane['sprawa_prawnik']
                    ,'sprawa_druga_strona' => $dane['sprawa_druga_strona']
                    ,'sprawa_pelnomocnik_glowny' => $dane['sprawa_pelnomocnik_glowny']
                    ,'sprawa_pelnomocnik_kairp' => $dane['sprawa_pelnomocnik_kairp']
                    ,'sprawa_wps' => $dane['sprawa_wps']
                    ,'sprawa_wpz' => $dane['sprawa_wpz']
                    ,'sprawa_koszt' => $dane['sprawa_koszt']
                    ,'slownik_wokanda_typ_umowy_id' => $dane['slownik_wokanda_typ_umowy_id']
                    ,'sprawa_zgoda_na_substytuta' => $dane['sprawa_zgoda_na_substytuta']
                );
                $wokanda_sprawa_id_glowna = $db->wywolaj_procedure('wokanda_sprawa_aktualizuj_lub_dodaj_sprawe', $sprawa_dane, 1);
			}
		}
		if($dane['wokanda_sprawa_id_glowna'] == '0' && $dane['id'] != '0'){
		    if(!empty($dane['klient_imie']) || !empty($dane['klient_nazwisko'])){
		        if(empty($dane['slownik_wokanda_typ_umowy_id'])){
		            $slownik_wokanda_typ_umowy_id = 'null';
                }else{
                    $slownik_wokanda_typ_umowy_id = $dane['slownik_wokanda_typ_umowy_id'];
                }
                $sprawa_dane = array(
                    'id' => $dane['wokanda_sprawa_id_glowna']
                    ,'sprawa_pce_numer' => $dane['sprawa_pce_numer']
                    ,'sprawa_pce_id' => $dane['sprawa_pce_id']
                    ,'klient_imie' => $dane['klient_imie']
                    ,'klient_nazwisko' => $dane['klient_nazwisko']
                    ,'sprawa_prawnik' => $dane['sprawa_prawnik']
                    ,'sprawa_druga_strona' => $dane['sprawa_druga_strona']
                    ,'sprawa_pelnomocnik_glowny' => $dane['sprawa_pelnomocnik_glowny']
                    ,'sprawa_pelnomocnik_kairp' => $dane['sprawa_pelnomocnik_kairp']
                    ,'sprawa_wps' => $dane['sprawa_wps']
                    ,'sprawa_wpz' => $dane['sprawa_wpz']
                    ,'sprawa_koszt' => $dane['sprawa_koszt']
                    ,'slownik_wokanda_typ_umowy_id' => $slownik_wokanda_typ_umowy_id
                    ,'sprawa_zgoda_na_substytuta' => $dane['sprawa_zgoda_na_substytuta']
                );
                $wokanda_sprawa_id_glowna = $db->wywolaj_procedure('wokanda_sprawa_aktualizuj_lub_dodaj_sprawe', $sprawa_dane, 1);
            }
		}
        $nazwa = $db->pobierz_wiersz('slownik_miasto', 'id', $dane['slownik_miasto_id']);

		$wokanda_dane = array(
				'id' => $dane['id'] 
				,'uzytkownik_id' => $dane['wokanda_prowadzacy']
                ,'nazwa' => $nazwa->nazwa
				,'start' => $dane['start']
				,'stop' => $dane['stop'] 
				,'czy_usuniety' => '0' 
				,'slownik_miasto_id' => $dane['slownik_miasto_id']
				,'slownik_wokanda_etap_id' => $dane['slownik_wokanda_etap_id']
                ,'slownik_wokanda_etap_2_id' => $dane['slownik_wokanda_etap_2_id']
                ,'slownik_wokanda_etap_sprawy_id' => $dane['slownik_wokanda_etap_sprawy_id']
                ,'slownik_wokanda_rodzaj_id' => $dane['slownik_wokanda_rodzaj_id']
				,'slownik_sad_id' => $dane['slownik_sad_id'] 
				,'sygnatura_akt' => $dane['sygnatura_akt'] 
				,'sala' => $dane['sala'] 
				,'potwierdzony_termin' => $dane['potwierdzony_termin'] 
				,'wokanda_sprawa_id_glowna' => $wokanda_sprawa_id_glowna
				,'wyslano_dokumenty' => $dane['wyslano_dokumenty'] 
				,'otrzymano_notatke' => $dane['otrzymano_notatke'] 
				,'slownik_substytut_forma_platnosci_id' => $dane['slownik_substytut_forma_platnosci_id']
				,'substytut_kwota' => $dane['substytut_kwota']
				,'substytut_pomocnik' => $dane['substytut_pomocnik'] 
				,'substytut_pomocnik_mail' => $dane['substytut_pomocnik_mail']
				,'substytut_id' => $dane['substytut_id']
				,'potwierdzony_substytut' => $dane['potwierdzony_substytut']
				,'faktura_wplynela' => $dane['faktura_wplynela']
				,'faktura_oplacona' => $dane['faktura_oplacona']
				,'faktura_numer' => $dane['faktura_numer']
				,'usluga_wykonana' => $dane['usluga_wykonana']
				,'koszt_ponosi_votum' => $dane['koszt_ponosi_votum']
				,'slownik_wokanda_klient_koszty_id' => $dane['slownik_wokanda_klient_koszty_id']
				,'sprawa_karna' => $dane['sprawa_karna']
				,'dodatkowe_dane_do_fv' => $dane['dodatkowe_dane_do_fv']
                ,'substytut_komentarz' => $dane['substytut_komentarz']
                ,'sprawa_trudna' => $dane['sprawa_trudna']
		);
		$wokanda_id = $db->wywolaj_procedure('wokanda_aktualizuj_lub_dodaj_wokande', $wokanda_dane, 1);

		if($wokanda_id == 0){
            $dane = array(
                0 => 0
                ,1 => 'Podana wokanda istnieje!!!'
                ,2 => $wokanda_id
            );
            echo json_encode($dane);
            return;
        }
			
		if($dane['id'] != $wokanda_id){
			dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Utworzenie wokandy', '', $wokanda_id, 'wokanda_historia_zmian');
		}else{
			
//			if($wokanda_baza->nazwa != $dane['nazwa'] ){
//				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana nazwy', $wokanda_baza->nazwa, $dane['nazwa'], 'wokanda_historia_zmian');
//			}
			
			if($wokanda_baza->start != $dane['start'].':00' ){
				$data_start_przed = explode(' ', $wokanda_baza->start);
				$data_start_po = explode(' ', $dane['start']);
				
				if($data_start_przed[0] != $data_start_po[0]){
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana daty start', $data_start_przed[0], $data_start_po[0], 'wokanda_historia_zmian');						
				}
				if($data_start_przed[1] != $data_start_po[1].':00'){
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana godziny start', $data_start_przed[1], $data_start_po[1].':00', 'wokanda_historia_zmian');
				}
				
			}
			
			if($wokanda_baza->stop != $dane['stop'].':00' ){
				$data_stop_przed = explode(' ', $wokanda_baza->stop);
				$data_stop_po = explode(' ', $dane['stop']);
			
				if($data_stop_przed[0] != $data_stop_po[0]){
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana daty stop', $data_stop_przed[0], $data_stop_po[0], 'wokanda_historia_zmian');
				}
				if($data_stop_przed[1] != $data_stop_po[1].':00'){
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana godziny stop', $data_stop_przed[1], $data_stop_po[1].':00', 'wokanda_historia_zmian');
				}
			
			}
			
			if($wokanda_baza->potwierdzony_termin != $dane['potwierdzony_termin'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Potwierdzenie terminu', ($wokanda_baza->potwierdzony_termin == '1') ? 'TAK' : 'NIE' , ($dane['potwierdzony_termin'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->potwierdzony_substytut != $dane['potwierdzony_substytut'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Potwierdzenie substytuta', ($wokanda_baza->potwierdzony_substytut == '1') ? 'TAK' : 'NIE' , ($dane['potwierdzony_substytut'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->slownik_wokanda_etap_id != $dane['slownik_wokanda_etap_id'] ){
				$zmiana_przed = $db->pobierz_wiersz('slownik_wokanda_etap', 'id', $wokanda_baza->slownik_wokanda_etap_id);
				$zmiana_po = $db->pobierz_wiersz('slownik_wokanda_etap', 'id', $dane['slownik_wokanda_etap_id']);
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana etapu', $zmiana_przed->wartosc , $zmiana_po->wartosc , 'wokanda_historia_zmian');
			
			}
			
			if($wokanda_baza->slownik_wokanda_rodzaj_id != $dane['slownik_wokanda_rodzaj_id'] ){
				$zmiana_przed = $db->pobierz_wiersz('slownik_wokanda_rodzaj', 'id', $wokanda_baza->slownik_wokanda_rodzaj_id);
				$zmiana_po = $db->pobierz_wiersz('slownik_wokanda_rodzaj', 'id', $dane['slownik_wokanda_rodzaj_id']);
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana rodzaju', $zmiana_przed->wartosc , $zmiana_po->wartosc , 'wokanda_historia_zmian');
					
			}
			
			if($wokanda_baza->slownik_sad_id != $dane['slownik_sad_id'] ){
				$zmiana_przed = $db->pobierz_wiersz('slownik_sad', 'id', $wokanda_baza->slownik_sad_id);
				$zmiana_po = $db->pobierz_wiersz('slownik_sad', 'id', $dane['slownik_sad_id']);
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana sądu', $zmiana_przed->nazwa, $zmiana_po->nazwa , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->sygnatura_akt != $dane['sygnatura_akt'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana sygnatury', $wokanda_baza->sygnatura_akt , $dane['sygnatura_akt'] , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->sala != $dane['sala'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana sali', $wokanda_baza->sala , $dane['sala'] , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->wokanda_sprawa_id_glowna != $wokanda_sprawa_id_glowna){
				
				$wokanda_sprawa_glowna = $db->pobierz_wiersz('wokanda_sprawa', 'id', $wokanda_sprawa_id_glowna);
				
				if($wokanda_baza->wokanda_sprawa_id_glowna == '0'){
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Dodanie sprawy głównej', '' , $wokanda_sprawa_glowna->sprawa_pce_numer , 'wokanda_historia_zmian');			
				}else{
					$wokanda_sprawa_glowna_prze = $db->pobierz_wiersz('wokanda_sprawa', 'id', $wokanda_baza->wokanda_sprawa_id_glowna);
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana sprawy głównej', $wokanda_sprawa_glowna_prze->sprawa_pce_numer , $wokanda_sprawa_glowna->sprawa_pce_numer , 'wokanda_historia_zmian');
					
				}
					
			}
			
			if($wokanda_baza->faktura_wplynela != $dane['faktura_wplynela'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Wpłyneła faktura', ($wokanda_baza->faktura_wplynela == '1') ? 'TAK' : 'NIE' , ($dane['faktura_wplynela'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->faktura_oplacona != $dane['faktura_oplacona'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Opłacona faktura', ($wokanda_baza->faktura_wplynela == '1') ? 'TAK' : 'NIE' , ($dane['faktura_oplacona'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->faktura_numer != $dane['faktura_numer'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Numer faktury', $wokanda_baza->faktura_numer , $dane['faktura_numer'] , 'wokanda_historia_zmian');
			}
			
			/*if($wokanda_baza->substytut_id == '0' && $dane['substytut_id'] != 'null'){
				$sub_po = $db->pobierz_wiersz('substytut', 'id', $dane['substytut_id']);
				$sub_po = $sub_po->nazwa;
				
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Substytut', '' , $sub_po , 'wokanda_historia_zmian');
			}*/
			
			if($dane['substytut_id'] != 'null'){
				if($wokanda_baza->substytut_id != $dane['substytut_id'] ){
					$sub_przed = '';
					if($wokanda_baza->substytut_id != '0'){
						$sub_przed = $db->pobierz_wiersz('substytut', 'id', $wokanda_baza->substytut_id);
						$sub_przed = $sub_przed->nazwa;
					}
					$sub_po = $db->pobierz_wiersz('substytut', 'id', $dane['substytut_id']);
					$sub_po = $sub_po->nazwa;
					dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Substytut', $sub_przed , $sub_po , 'wokanda_historia_zmian');
				}
			}
			
			if($wokanda_baza->substytut_kwota != $dane['substytut_kwota'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Koszt stawiennictwa', $wokanda_baza->substytut_kwota , $dane['substytut_kwota'] , 'wokanda_historia_zmian');
			}
			
			
			if($wokanda_baza->slownik_substytut_forma_platnosci_id != $dane['slownik_substytut_forma_platnosci_id'] ){
				$subf_przed='';
				if($wokanda_baza->slownik_substytut_forma_platnosci_id != '0'){
					$subf_przed = $db->pobierz_wiersz('slownik_substytut_forma_platnosci', 'id', $wokanda_baza->slownik_substytut_forma_platnosci_id);
					$subf_przed = $subf_przed->wartosc;
				}
				
				$subf_po = $db->pobierz_wiersz('slownik_substytut_forma_platnosci', 'id', $dane['slownik_substytut_forma_platnosci_id']);
				$subf_po = $subf_po->wartosc;
			
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Substytut forma płatności', mb_ucfirst($subf_przed) , mb_ucfirst($subf_po) , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->wyslano_dokumenty != $dane['wyslano_dokumenty'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Wysłano dokumenty', ($wokanda_baza->wyslano_dokumenty == '1') ? 'TAK' : 'NIE' , ($dane['wyslano_dokumenty'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->otrzymano_notatke != $dane['otrzymano_notatke'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Otrzymano notatkę', ($wokanda_baza->otrzymano_notatke == '1') ? 'TAK' : 'NIE' , ($dane['otrzymano_notatke'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->substytut_pomocnik_mail != $dane['substytut_pomocnik_mail'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana pomocnik email', $wokanda_baza->substytut_pomocnik_mail , $dane['substytut_pomocnik_mail'] , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->substytut_pomocnik != $dane['substytut_pomocnik'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Zmiana pomocnik Substytuta', $wokanda_baza->substytut_pomocnik , $dane['substytut_pomocnik'] , 'wokanda_historia_zmian');
			}
			
			if($wokanda_baza->usluga_wykonana != $dane['usluga_wykonana'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Usługa wykonana', ($wokanda_baza->usluga_wykonana == '1') ? 'TAK' : 'NIE' , ($dane['usluga_wykonana'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			if($wokanda_baza->koszt_ponosi_votum != $dane['koszt_ponosi_votum'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Koszt ponosi VOTUM', ($wokanda_baza->koszt_ponosi_votum == '1') ? 'TAK' : 'NIE' , ($dane['koszt_ponosi_votum'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			/*kamyk 2017-01-02*/
			
			if($wokanda_baza->slownik_wokanda_klient_koszty_id != $dane['slownik_wokanda_klient_koszty_id'] ){
				$zmiana_przed = $db->pobierz_wiersz('slownik_wokanda_klient_koszty', 'id', $wokanda_baza->slownik_wokanda_klient_koszty_id);
				$zmiana_po = $db->pobierz_wiersz('slownik_wokanda_klient_koszty', 'id', $dane['slownik_wokanda_klient_koszty_id']);
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Klient ponosi koszty', $zmiana_przed->wartosc , $zmiana_po->wartosc , 'wokanda_historia_zmian');
					
			}
			
			if($wokanda_baza->sprawa_karna != $dane['sprawa_karna'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Sprawa karna', ($wokanda_baza->sprawa_karna == '1') ? 'TAK' : 'NIE' , ($dane['sprawa_karna'] == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
			}
			
			/*------------------------------------------------------------------*/
			
			/*kamyk 2017-01-02*/
			
			if($wokanda_baza->dodatkowe_dane_do_fv != $dane['dodatkowe_dane_do_fv'] ){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Dod. dane do FV', $wokanda_baza->dodatkowe_dane_do_fv  , $dane['dodatkowe_dane_do_fv'] ,'wokanda_historia_zmian');
			}

            if($wokanda_baza->substytut_komentarz != $dane['substytut_komentarz'] ){
                dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Substytut komentarz', $wokanda_baza->substytut_komentarz  , $dane['substytut_komentarz'] ,'wokanda_historia_zmian');
            }
			/*------------------------------------------------------------------*/
		}
		$dane = array(
				0 => 1
				,1 => 'Zmiany zostały zapisane!!!'
				,2 => $wokanda_id
		);
		echo json_encode($dane);
		return;
	}
	if($akcja === 'wokanda_sprawa_powiazana_dodaj_usun'){
		$zadanie = (isset($_POST['zadanie'])) ? htmlspecialchars($_POST['zadanie']) : '' ;
		$sprawa_powiazana_id = (isset($_POST['sprawa_powiazana_id'])) ? htmlspecialchars($_POST['sprawa_powiazana_id']) : '' ;
		$wokanda_id = (isset($_POST['wokanda_id'])) ? htmlspecialchars($_POST['wokanda_id']) : '' ;

		$sprawa_pce_numer = (isset($_POST['sprawa_pce_numer'])) ? htmlspecialchars($_POST['sprawa_pce_numer']) : '' ;
		$sprawa_pce_id = (isset($_POST['sprawa_pce_id'])) ? htmlspecialchars($_POST['sprawa_pce_id']) : '' ;
		$klient_imie = (isset($_POST['klient_imie'])) ? htmlspecialchars($_POST['klient_imie']) : '' ;
		$klient_nazwisko = (isset($_POST['klient_nazwisko'])) ? htmlspecialchars($_POST['klient_nazwisko']) : '' ;
		$sprawa_prawnik = (isset($_POST['sprawa_prawnik'])) ? htmlspecialchars($_POST['sprawa_prawnik']) : '' ;
		$sprawa_druga_strona = (isset($_POST['sprawa_druga_strona'])) ? htmlspecialchars($_POST['sprawa_druga_strona']) : '' ;
		$sprawa_pelnomocnik_glowny = (isset($_POST['sprawa_pelnomocnik_glowny'])) ? htmlspecialchars($_POST['sprawa_pelnomocnik_glowny']) : '' ;
		$sprawa_pelnomocnik_kairp = (isset($_POST['sprawa_pelnomocnik_kairp'])) ? htmlspecialchars($_POST['sprawa_pelnomocnik_kairp']) : '' ;
		$sprawa_wps = (isset($_POST['sprawa_wps'])) ? htmlspecialchars($_POST['sprawa_wps']) : '' ;
		
		if($zadanie == 'usun'){
			
			$db->delete_wartosc('wokanda_id_wokanda_sprawa_id', "wokanda_id = $wokanda_id AND wokanda_sprawa_id = $sprawa_powiazana_id");
			
			$sprawa_powiazana_numer = $db->pobierz_wartosc('sprawa_pce_numer', 'wokanda_sprawa', 'id', $sprawa_powiazana_id);
			dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Usunięcie sprawy powiązanej', $sprawa_powiazana_numer->sprawa_pce_numer , '' , 'wokanda_historia_zmian');
				
			$db->delete_wartosc('wokanda_sprawa', "id = $sprawa_powiazana_id");
			
			$dane = array(
					0 => 0
					,1 => 'Sprawa usunięta z wokandy!!!'
			);
			echo json_encode($dane);
			return;
		}
		
		
		$sprawa_dane = array(
				'id' => $sprawa_powiazana_id
				,'sprawa_pce_numer' => $sprawa_pce_numer
				,'sprawa_pce_id' => $sprawa_pce_id
				,'klient_imie' => $klient_imie
				,'klient_nazwisko' => $klient_nazwisko
				,'sprawa_prawnik' => $sprawa_prawnik
				,'sprawa_druga_strona' => $sprawa_druga_strona
				,'sprawa_pelnomocnik_glowny' => $sprawa_pelnomocnik_glowny
				,'sprawa_pelnomocnik_kairp' => $sprawa_pelnomocnik_kairp
				,'sprawa_wps' => $sprawa_wps
				,'sprawa_wpz' => '0'
				,'sprawa_koszt' => '0'
				,'slownik_wokanda_typ_umowy_id' => '1'
				,'sprawa_zgoda_na_substytuta' => '0'
		);
		$sprawa_powiazana_id = $db->wywolaj_procedure('wokanda_sprawa_aktualizuj_lub_dodaj_sprawe', $sprawa_dane, 1);

		$wartosci = array(
				'wokanda_id' => $wokanda_id
				,'wokanda_sprawa_id' => $sprawa_powiazana_id
		);
		$db->wstaw_wartosc('wokanda_id_wokanda_sprawa_id', $wartosci);
		$sprawa_powiazana_numer = $db->pobierz_wartosc('sprawa_pce_numer', 'wokanda_sprawa', 'id', $sprawa_powiazana_id);
			
		dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Dodanie sprawy powiązanej', '' , $sprawa_powiazana_numer->sprawa_pce_numer , 'wokanda_historia_zmian');
			
		
		$dane = array(
				0 => 1
				,1 => 'Sprawa dodana do wokandy!!!'
				,2 => $sprawa_powiazana_id
		);
		echo json_encode($dane);
		return;
		
	}
	
	if($akcja === 'wokanda_aktualizuj_wartosc'){
		$kolumna = (isset($_POST['kolumna'])) ? htmlspecialchars($_POST['kolumna']) : '' ;
		$element_id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;
		$wartosc = (isset($_POST['wartosc'])) ? htmlspecialchars($_POST['wartosc']) : '' ;
					
		$wokanda_baza = $db->pobierz_wiersz('wokanda', 'id', $element_id);
		
		$db->aktualizuj_wartosc('wokanda', array($kolumna => $wartosc), $element_id);
		
		if($kolumna == 'faktura_oplacona'){
			if($wokanda_baza->faktura_oplacona != $wartosc ){
				dodaj_wpis_histori($element_id, 'wokanda_id', 'Opłacona faktura(z listy)', ($wokanda_baza->faktura_oplacona == '1') ? 'TAK' : 'NIE' , ($wartosc == '1') ? 'TAK' : 'NIE' , 'wokanda_historia_zmian');
					
			}
				
		}
		
		$dane = array(
				0 => 1
				,1 => 'Zapisano zmiany w wokandzie!!!'
		);
		echo json_encode($dane);
		return;
	
	}
	
	if($akcja === 'wokanda_wyslij_dane_do_PCE'){
		$wokanda_id = (isset($_POST['wokanda_id'])) ? htmlspecialchars($_POST['wokanda_id']) : '' ;
		
		if($wokanda_id == ''){
			$dane = array(
					0 => 0
					,1 => 'Brak id wokandy!!!'
			);
			echo json_encode($dane);
			return;
		}
		
		$wartosci = array(
				'wokanda_id' => $wokanda_id
		);
		
		
		
		$wokanda_baza = $db->wywolaj_procedure('wokanda_pobierz_wokande', array( 'wokanda_id' => $wokanda_id ) );
		$wokanda_baza = $wokanda_baza->fetch_object();
		
		
		$data_wokandy  = iconv("UTF-8","cp1250",$wokanda_baza->start);
		
		$id_uzytkownik = $db->pobierz_ogolne_zapytanie('uzytkownik', 'login_pce_id', 'id = '.$uzytkownik->__get('_id'));
		$id_uzytkownik  = iconv("UTF-8","cp1250",$id_uzytkownik->login_pce_id);
				
		$etap_wokandy  = iconv("UTF-8","cp1250",$wokanda_baza->etap_id);
		$sygnatura_akt  = iconv("UTF-8","cp1250",$wokanda_baza->sygnatura_akt);
		$nazwa_sad  = iconv("UTF-8","cp1250",$wokanda_baza->sad_nazwa);
		$miasto_sad  = iconv("UTF-8","cp1250",$wokanda_baza->miasto);
		$kod_pocztowy_sad  = iconv("UTF-8","cp1250",$wokanda_baza->kod_pocztowy);
		$adres_sad  = iconv("UTF-8","cp1250",$wokanda_baza->ulica);
		$wojewodztwo_id_sad  = iconv("UTF-8","cp1250",$wokanda_baza->wojewodztwo_id);
		$substytut_imie  = iconv("UTF-8","cp1250",$wokanda_baza->substytut_imie);
		$substytut_nazwisko  = iconv("UTF-8","cp1250",$wokanda_baza->substytut_nazwisko);
		$wokanda_link  = '';
				
		$lista_spraw_wokandy = $db->wywolaj_procedure('wokanda_pobierz_sprawy_po_wokanda_id', array( 'wokanda_id' => $wokanda_id ) );
		
		while ($poj_lista_spraw_wokandy = $lista_spraw_wokandy->fetch_object()) {
			$id_sprawy  = iconv("UTF-8","cp1250",$poj_lista_spraw_wokandy->sprawa_pce_id);
			$wokanda_link  = '';
			
			$polaczenie_mssql = polacz_z_baza_ms_sql();
			
			mssql_query("SET ANSI_WARNINGS ON", $polaczenie_mssql);
			mssql_query("SET ANSI_NULLS ON", $polaczenie_mssql);
			mssql_query("SET CONCAT_NULL_YIELDS_NULL ON", $polaczenie_mssql);
			mssql_query("SET ANSI_PADDING ON", $polaczenie_mssql);
			
			$procedura = mssql_init('wokanda.aktualizuj_sprawe', $polaczenie_mssql);
			
			if($id_sprawy != ''){
				mssql_bind($procedura, '@id_sprawy', $id_sprawy, SQLVARCHAR, false, false, 11);
			}
			
			if($data_wokandy != ''){
				mssql_bind($procedura, '@data_wokandy', $data_wokandy,  SQLVARCHAR, false, false, 15);
			}
			
			if($id_uzytkownik != ''){
				mssql_bind($procedura, '@id_uzytkownik', $id_uzytkownik,  SQLVARCHAR, false, false, 11);
			}
			
			if($etap_wokandy != ''){
				mssql_bind($procedura, '@etap_wokandy', $etap_wokandy,  SQLVARCHAR, false, false, 8);
			}
			
			if($sygnatura_akt != ''){
				mssql_bind($procedura, '@sygnatura_akt', $sygnatura_akt,  SQLVARCHAR, false, false, 60);
			}
			
			if($nazwa_sad != ''){
				mssql_bind($procedura, '@nazwa_sad', $nazwa_sad,  SQLVARCHAR, false, false, 60);
			}
			
			if($miasto_sad != ''){
				mssql_bind($procedura, '@miasto_sad', $miasto_sad,  SQLVARCHAR, false, false, 60);
			}
			
			if($kod_pocztowy_sad != ''){
				mssql_bind($procedura, '@kod_pocztowy_sad', $kod_pocztowy_sad,  SQLVARCHAR, false, false, 60);
			}
			
			if($adres_sad != ''){
				mssql_bind($procedura, '@adres_sad', $adres_sad,  SQLVARCHAR, false, false, 60);
			}
			
			if($wojewodztwo_id_sad != ''){
				mssql_bind($procedura, '@wojewodztwo_id_sad', $wojewodztwo_id_sad,  SQLVARCHAR, false, false, 8);
			}
			
			if($substytut_imie != ''){
				mssql_bind($procedura, '@substytut_imie', $substytut_imie,  SQLVARCHAR, false, false, 60);
			}
			
			if($substytut_nazwisko != ''){
				mssql_bind($procedura, '@substytut_nazwisko', $substytut_nazwisko,  SQLVARCHAR, false, false, 60);
			}
			
			if($wokanda_link != ''){
				mssql_bind($procedura, '@wokanda_link', $wokanda_link,  SQLVARCHAR, false, false, 60);
			}

			$wynik = mssql_execute($procedura);
			
			mssql_query("SET ANSI_WARNINGS OFF" );
			
			mssql_free_statement($procedura);
				
			$wynik = mssql_fetch_assoc($wynik);

			if($wynik['wynik'] == '0'){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Sync z PCE', $poj_lista_spraw_wokandy->sprawa_pce_numer, 'Błąd', 'wokanda_historia_zmian');
				$komunikat = 0;
			}
			if($wynik['wynik'] == '1'){
				dodaj_wpis_histori($wokanda_id, 'wokanda_id', 'Sync z PCE', $poj_lista_spraw_wokandy->sprawa_pce_numer, 'Sukces', 'wokanda_historia_zmian');
				$komunikat = 1;
			}
			if($wynik['wynik'] == '2'){
				$komunikat = 2;
			}
		}
		
		if($komunikat == '0'){
			$komunikat_tresc = 'Zmiany nie zostały zapisane!!!';
		}
		if($komunikat == '1'){
			$komunikat_tresc = 'Zapisano zmiany w systemie PCE!!!';
		}
		if($komunikat == '2'){
			$komunikat_tresc = 'Nie wykryto żadnych zmian!!!';
		}
		
		$dane = array(
				0 => $komunikat
				,1 => $komunikat_tresc
				,2 => 1
		);
		echo json_encode($dane);
		return;
	
	}

    if($akcja === 'wokanda_wyslij_wiadomosc_do_substytuta'){
        $substytut_id = (isset($_POST['substytut_id'])) ? htmlspecialchars($_POST['substytut_id']) : '' ;
        $substytut_email = (isset($_POST['substytut_email'])) ? htmlspecialchars($_POST['substytut_email']) : '' ;
        $dw_email = (isset($_POST['dw_email'])) ? htmlspecialchars($_POST['dw_email']) : '' ;
        $tresc = (isset($_POST['tresc'])) ? $_POST['tresc'] : '' ;

        $substytut_tmp = $db->pobierz_wiersz('substytut', 'id', $substytut_id);

        $tresc = str_replace('<table','<table cellspacing="0"',$tresc);
        $tresc = str_replace('class="naglowekTabeli"','class="naglowekTabeli" bgcolor="#cec4c4"',$tresc);
        $tresc = str_replace('<td','<td style = "border: 1px solid #ccc;  padding: 10px;"',$tresc);

        wyslij_wiadomosc_mail('[LEBEKIWSPOLNICY.PL] Informacje o nadchodzących wokandach',"$substytut_email",$tresc,false);
        if($dw_email != '') {
            wyslij_wiadomosc_mail('[LEBEKIWSPOLNICY.PL] Informacje o nadchodzących wokandach', "$dw_email", $tresc, false);
        }
        $polaczenie_pdo = $db->polaczeniePDO();
        $stmt = $polaczenie_pdo->prepare("call wokandy.wokanda_wyslano_powiadomienie(?);");
        $stmt->bindParam(1, $substytut_id, PDO::PARAM_INT);
        $stmt-> execute();

        $dane = array(
            0 => 'sukces'
            ,1 => 'Wiadomość została wysłana!!!'

        );
        echo json_encode($dane);
        return;
}
	
	
	
