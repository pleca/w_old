<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$widok = (isset($_POST['widok'])) ? htmlspecialchars($_POST['widok']) : '' ;
	$i=0;
	
	if($widok === ''){
		$dane = array(
				0 => 0
				,1 => 'Brak akcji do wykonania!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	
	if($widok === 'kalendarz'){
		$wartosci = array(
				'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
				,'czy_usuniety_tmp' => '0'
				,'lista' => 'moje'
				,'id' => '0'
				,'nazwa' => ''
				,'start' => ''
				,'stop' => ''
				,'potwierdzony_termin' => '2'
				,'sad_miasto' => ''
				,'wokanda_miasto' => ''
                ,'wokanda_prowadzacy' => ''
				,'sygnatura_akt' => ''
				,'klient_imie' => ''
				,'klient_nazwisko' => ''
				,'sprawa_pce_numer' => ''
				,'imie_substytut'  => ''
				,'nazwisko_substytu' => ''
				,'substytut_votum' => '2'
				,'sprawa_druga_strona' => '2'
				,'sprawa_prawnik_prowadzacy' => ''
				,'faktura_numer' => ''
				,'faktura_zrealizowana' => '2'
				,'koszt_ponosi_votum' => '2'
                ,'wokanda_etap' => ''
                ,'wokanda_etap2' => ''
                ,'wps_od' => '0'
                ,'wps_do' => '0'
                ,'wokanda_rodzaj' => ''
                ,'sprawa_trudna' => '2'
                ,'substytut_uprawnienie' => '2'
                );
		$lista_wokand = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci);
		if($lista_wokand->num_rows != 0){
			while ($poj_lista_wokand = $lista_wokand->fetch_object()) {

			    if($poj_lista_wokand->slownik_wokanda_etap_id == 5
                    || $poj_lista_wokand->slownik_wokanda_etap_id == 9
                    || $poj_lista_wokand->slownik_wokanda_etap_id == 8){
                    $kolor = 'rgb(92, 184, 92)';
                }else{
                    $kolor = 'rgb(201, 37, 44)';
                }

				$dane[$i] = array(
						'id' => $poj_lista_wokand->id
						,'title' => '<p class="fc-title_nazwa">'.$poj_lista_wokand->nazwa.'</p>'
						,'start' => $poj_lista_wokand->start
						,'end' => $poj_lista_wokand->stop
						,'backgroundColor' => $kolor
				);
				$i++;
			}
		}else{
			$dane = array(
					0 => ''
			);
		}
		
		if(in_array(23, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
			$wartosci = array(
					'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
					,'czy_usuniety_tmp' => '0'
					,'lista' => ''
					,'id' => '0'
					,'nazwa' => ''
					,'start' => ''
					,'stop' => ''
					,'potwierdzony_termin' => ''
					,'sad_miasto' => ''
					,'wokanda_miasto' => ''
					,'wokanda_prowadzacy' => ''
					,'sygnatura_akt' => ''
					,'klient_imie' => ''
					,'klient_nazwisko' => ''
					,'sprawa_pce_numer' => ''
					,'imie_substytut'  => ''
					,'nazwisko_substytu' => ''
					,'substytut_votum' => ''
					,'sprawa_druga_strona' => ''
					,'sprawa_prawnik_prowadzacy' => ''
					,'faktura_numer' => ''
					,'faktura_zrealizowana' => ''
					,'koszt_ponosi_votum' => ''
                    ,'wokanda_etap' => ''
                    ,'wokanda_etap2' => ''
                    ,'wps_od' => ''
                    ,'wps_do' => ''
                    ,'wokanda_rodzaj' => ''
                    ,'sprawa_trudna' => ''
                    ,'substytut_uprawnienie' => ''
			);
			
			$lista_wokand = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci);
			if($lista_wokand->num_rows != 0){
				while ($poj_lista_wokand = $lista_wokand->fetch_object()) {
                    if($poj_lista_wokand->slownik_wokanda_etap_id == 5
                        || $poj_lista_wokand->slownik_wokanda_etap_id == 9
                        || $poj_lista_wokand->slownik_wokanda_etap_id == 8){
                        $kolor = 'rgb(92, 184, 92)';
                    }else{
                        $kolor = 'rgb(201, 37, 44)';
                        //$kolor = 'rgb(0, 114, 196)';
                    }

					$dane[$i] = array(
							'id' => $poj_lista_wokand->id
							,'title' => '<p class="fc-title_nazwa">'.$poj_lista_wokand->nazwa.'</p>'
							,'start' => $poj_lista_wokand->start
							,'end' => $poj_lista_wokand->stop
							,'backgroundColor' => $kolor
					);
					$i++;
				}
			}
		}
		
		echo json_encode($dane);
		return;
	}
	