<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
	$wartosc = mb_strtolower((isset($_POST['wartosc'])) ? htmlspecialchars($_POST['wartosc']) : '' );
	$tabela = (isset($_POST['tabela'])) ? htmlspecialchars($_POST['tabela']) : '' ;
	$szukaj_po = (isset($_POST['szukaj_po'])) ? htmlspecialchars($_POST['szukaj_po']) : '' ;
	
	if($akcja === 'wyszukaj_like' && $wartosc != '' && $tabela != '' && $szukaj_po != ''){
		//var_dump($tabela);
		$wyniki_dane = array(
				'tabela' => $tabela
				,'kolumna' => $szukaj_po
				,'wartosc' => $wartosc
		);
		
		$wyniki = $db->wywolaj_procedure('wyszukanie', $wyniki_dane);

			while ($poj_wyniki = $wyniki->fetch_object()) {
                if(!is_null($poj_wyniki)){
                if($tabela == 'slownik_sad')
                {
                    foreach ($poj_wyniki as $key => $sad) {

                        if($key == 'id') {
                            $result = $db->pobierz_wiersz($tabela, 'id', $sad);
                            if ($result->czy_usuniety == '0') {
                                if (mb_strpos($poj_wyniki->nazwa, $wartosc)) {
                                    $nazwa = mb_str_replace($wartosc, '<b>' . $wartosc . '</b>', $poj_wyniki->nazwa);
                                } else {
                                    $nazwa = mb_str_replace(mb_ucfirst($wartosc), '<b>' . mb_ucfirst($wartosc) . '</b>', $poj_wyniki->nazwa);
                                }
                                echo '<div class="pojedynczy_wynik"><span class="float_l">' . $nazwa . '</span><i data-element_id="' . $poj_wyniki->id . '" data-tabela="' . $tabela . '" class="wczytaj_dane_' . $tabela . ' fa fa-plus float_r" aria-hidden="true"></i></div>';
                            };
                        };
                    };
                }else {
                    if (mb_strpos($poj_wyniki->nazwa, $wartosc)) {
                        $nazwa = mb_str_replace($wartosc, '<b>' . $wartosc . '</b>', $poj_wyniki->nazwa);
                    } else {
                        $nazwa = mb_str_replace(mb_ucfirst($wartosc), '<b>' . mb_ucfirst($wartosc) . '</b>', $poj_wyniki->nazwa);
                    }
                    echo '<div class="pojedynczy_wynik"><span class="float_l">' . $nazwa . '</span><i data-element_id="' . $poj_wyniki->id . '" data-tabela="' . $tabela . '" class="wczytaj_dane_' . $tabela . ' fa fa-plus float_r" aria-hidden="true"></i></div>';
                }
			
			}
		}
		
		
	}