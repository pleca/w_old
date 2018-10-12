<?php
require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');

$akcja = (isset($_POST['akcja'])) ? htmlspecialchars($_POST['akcja']) : '' ;
if($akcja === 'wczytaj_dane_sadu'){
    $tabela = (isset($_POST['tabela'])) ? htmlspecialchars($_POST['tabela']) : '' ;
    $id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;

    $sad = $db->pobierz_wiersz($tabela, 'id', $id);
    $miasto = $db->pobierz_wiersz('slownik_miasto', 'id',$sad->miasto_id);
    $wojewodztwo = $db->pobierz_wiersz('slownik_wojewodztwo', 'id',$miasto->wojewodztwo_id);
    $typ = $db->pobierz_wiersz('slownik_sad_typ', 'id',$sad->slownik_sad_typ_id);

    $dane = array(
        'sad_id' => $sad->id
    ,'sad_nazwa' => $sad->nazwa
    ,'sad_ulica' => $sad->ulica
    ,'sad_kod_pocztowy' => $sad->kod_pocztowy
    ,'miasto_nazwa' => mb_ucfirst($miasto->nazwa)
    ,'miasto_id' => $miasto->id
    ,'wojewodztwo_id' => $wojewodztwo->id
    ,'wojewodztwo_nazwa' => mb_ucfirst($wojewodztwo->nazwa)
    ,'typ_nazwa' => $typ->wartosc
    ,'typ_id' => $typ->id


    );
    echo json_encode($dane);
    return;

}

if($akcja === 'wczytaj_miasto'){
    $tabela = (isset($_POST['tabela'])) ? htmlspecialchars($_POST['tabela']) : '' ;
    $id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;
    $miasto = $db->pobierz_wiersz($tabela, 'id', $id);
    $dane = array(
        'miasto_id' => $miasto->id,
        'miasto_nazwa' => $miasto->nazwa
    );
    echo json_encode($dane);
    return;

}

if($akcja === 'klient_pce'){
    $imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
    $nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
    $nr_sprawy = (isset($_POST['nr_sprawy'])) ? htmlspecialchars($_POST['nr_sprawy']) : '' ;

    $akcja_sprawa = (isset($_POST['akcja_sprawa'])) ? htmlspecialchars($_POST['akcja_sprawa']) : '' ;

    if($imie == '' && $nazwisko == '' && $nr_sprawy == ''){
        echo 'brak_danych';
        return;
    }

    if($akcja_sprawa == ''){
        echo 'brak_danych';
        return;
    }

    $imie  = iconv("UTF-8","cp1250",$imie);
    $nazwisko  = iconv("UTF-8","cp1250",$nazwisko);
    $nr_sprawy  = iconv("UTF-8","cp1250",$nr_sprawy);

    $polaczenie_mssql = polacz_z_baza_ms_sql();

    $procedura = mssql_init('wokanda.dane_sprawy', $polaczenie_mssql);

    mssql_bind($procedura, '@numer', $nr_sprawy,  SQLVARCHAR);
    mssql_bind($procedura, '@imie_klienta', $imie,  SQLVARCHAR);
    mssql_bind($procedura, '@nazwisko_klienta', $nazwisko,  SQLVARCHAR);

    $wynik = mssql_execute($procedura);

    mssql_free_statement($procedura);

    if($akcja_sprawa == 'sprawa_glowna'){
        $klasa_akcji = 'dodaj_klienta_do_wokandy';
    }

    if($akcja_sprawa == 'sprawa_powiazana'){
        $klasa_akcji = 'dodaj_klienta_powiazany_do_wokandy';
    }

    echo '<div class="panel panel-default margin_t_10">';
    echo '<div class="panel-heading aktywny">Wyniki<span class="badge">'.mssql_num_rows($wynik).'</span></div>';
    echo '<div class="panel-body" style="display:block">';
    ?>
    <div class="table-responsive moja_tabela ">
        <table id="tabela_lista_klientow" class="tabela_lista_klientow lista_klientow_lista_pce table_data_table table table-striped table-hover">
            <thead>
            <tr>
                <th class="col-md-3">Imię</th>
                <th class="col-md-3">Nazwisko</th>
                <th class="col-md-3">Prawnik</th>
                <th class="col-md-2">Nr sprawy</th>
                <th class="ukryj"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(mssql_num_rows($wynik) != 0){
                while ($poj_lista_klientow = mssql_fetch_object($wynik)) {
                    $id = iconv("cp1250","UTF-8",$poj_lista_klientow->id);
                    $imie_klienta = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->imie_klienta));
                    $nazwisko_klienta = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->nazwisko_klienta));
                    $numer_sprawy = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->numer_sprawy));
                    $prawnik_prowadzacy = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->prawnik_prowadzacy));
                    $druga_strona = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->druga_strona));
                    $pelnomocnik_glowny = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->pelnomocnik_glowny));
                    $pelnomocnik_substytucyjny = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->pelnomocnik_substytucyjny));
                    $wps = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->wps));
                    $typ_umowy = trim(iconv("cp1250","UTF-8",$poj_lista_klientow->typ_umowy));

                    echo '<tr class="'.$klasa_akcji.' cursor_p" data-id="'.$id.'" data-numer_sprawy="'.$numer_sprawy.'" data-prawnik_prowadzacy="'.$prawnik_prowadzacy.'" data-nazwisko_klienta="'.$nazwisko_klienta.'" data-imie_klienta="'.$imie_klienta.'" data-typ_umowy="'.$typ_umowy.'" data-wps="'.$wps.'" data-pelnomocnik_substytucyjny="'.$pelnomocnik_substytucyjny.'" data-prawnik_prowadzacy="'.$prawnik_prowadzacy.'" data-druga_strona="'.$druga_strona.'" data-pelnomocnik_glowny="'.$pelnomocnik_glowny.'">';
                    echo '<td class="col-md-3" >'.$imie_klienta.'</td>';
                    echo '<td class="col-md-3" >'.$nazwisko_klienta.'</td>';
                    echo '<td class="col-md-3">'.$prawnik_prowadzacy.'</td>';
                    echo '<td class="col-md-2">'.$numer_sprawy.'</td>';
                    echo '<td class="ukryj"></td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <?php
    echo '</div>';
    echo '</div>';
}

if($akcja === 'klient_pce_odswiez'){
    $imie = (isset($_POST['imie'])) ? htmlspecialchars($_POST['imie']) : '' ;
    $nazwisko = (isset($_POST['nazwisko'])) ? htmlspecialchars($_POST['nazwisko']) : '' ;
    $nr_sprawy = (isset($_POST['nr_sprawy'])) ? htmlspecialchars($_POST['nr_sprawy']) : '' ;
    $akcja_sprawa = (isset($_POST['akcja_sprawa'])) ? htmlspecialchars($_POST['akcja_sprawa']) : '' ;

    if($imie == '' && $nazwisko == '' && $nr_sprawy == ''){
        echo 'brak_danych';
        return;
    }

    if($akcja_sprawa == ''){
        echo 'brak_danych';
        return;
    }

    $imie  = iconv("UTF-8","cp1250",$imie);
    $nazwisko  = iconv("UTF-8","cp1250",$nazwisko);
    $nr_sprawy  = iconv("UTF-8","cp1250",$nr_sprawy);

    $polaczenie_mssql = polacz_z_baza_ms_sql();

    $procedura = mssql_init('wokanda.dane_sprawy', $polaczenie_mssql);

    mssql_bind($procedura, '@numer', $nr_sprawy,  SQLVARCHAR);
    mssql_bind($procedura, '@imie_klienta', $imie,  SQLVARCHAR);
    mssql_bind($procedura, '@nazwisko_klienta', $nazwisko,  SQLVARCHAR);

    $wynik = mssql_execute($procedura);

    mssql_free_statement($procedura);

    if($akcja_sprawa == 'sprawa_glowna'){
        $klasa_akcji = 'dodaj_klienta_do_wokandy';
    }

    if($akcja_sprawa == 'sprawa_powiazana'){
        $klasa_akcji = 'dodaj_klienta_powiazany_do_wokandy';
    }

    if(mssql_num_rows($wynik) != 0){
        while ($poj_lista_klientow = mssql_fetch_object($wynik)) {
            $result = array(
                'id' => iconv("cp1250","UTF-8",$poj_lista_klientow->id),
                'imie_klienta' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->imie_klienta)),
                'nazwisko_klienta' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->nazwisko_klienta)),
                'numer_sprawy' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->numer_sprawy)),
                'prawnik_prowadzacy' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->prawnik_prowadzacy)),
                'druga_strona' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->druga_strona)),
                'pelnomocnik_glowny' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->pelnomocnik_glowny)),
                'pelnomocnik_substytucyjny' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->pelnomocnik_substytucyjny)),
                'wps' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->wps)),
                'wpz' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->wpz)),
                'typ_umowy' => trim(iconv("cp1250","UTF-8",$poj_lista_klientow->typ_umowy)),
            );
        }
    }
    echo json_encode( $result );
}


if($akcja === 'wczytaj_dane_substytut'){
    $tabela = (isset($_POST['tabela'])) ? htmlspecialchars($_POST['tabela']) : '' ;
    $id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;


    $substytut = $db->pobierz_wiersz($tabela, 'id', $id);
    $forma_platnosci = $db->pobierz_wiersz('slownik_substytut_forma_platnosci', 'id',$substytut->forma_platnosci_id_domyslna);
    $miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $substytut->slownik_miasto_id);
    $wojewodztwo = $db->pobierz_wiersz('slownik_wojewodztwo', 'id', $miasto->wojewodztwo_id);
    $uprawnienia = $db->pobierz_wiersz('slownik_substytut_uprawnienia', 'id', $substytut->slownik_substytut_uprawnienia_id);

    $dane = array(

            'substytut_id' => $substytut->id
    ,'imie' => $substytut->imie
    ,'nazwisko' => $substytut->nazwisko
    ,'koszt_stawiennictwa' => $substytut->koszt_stawiennictwa_domyslny
    ,'forma_platnosci_nazwa' => mb_ucfirst($forma_platnosci->wartosc)
    ,'uprawnienia' => mb_ucfirst($uprawnienia->wartosc)
    ,'ulica' => $substytut->ulica
    ,'miasto' => mb_ucfirst($miasto->nazwa)
    ,'wojewodztwo' => mb_ucfirst($wojewodztwo->nazwa)
    ,'forma_platnosci_id' => $forma_platnosci->id
    ,'email' => $substytut->email
    ,'email2' => $substytut->email2
    ,'telefon' => $substytut->nr_telefonu
    ,'czy_votum' => $substytut->czy_votum


    );
    echo json_encode($dane);
    return;
}

if($akcja === 'wokanda_filtruj'){
    $dane = (isset($_POST['dane'])) ? htmlspecialchars($_POST['dane']) : '' ;
    $dane = json_decode(str_replace('&quot;', '"', $dane), true);
    $wartosci = array(
        'uzytkownik_id_tmp' => $uzytkownik->__get('_id')
    ,'czy_usuniety_tmp' => '0'
    ,'lista' => 'filtr'
    ,'id' => ($dane == '') ? '0' : $dane['id']
    ,'nazwa' => $dane['nazwa']
    ,'start' => $dane['start'].' 00:00:00'
    ,'stop' => $dane['stop'].' 00:00:00'
    ,'potwierdzony_termin' => $dane['potwierdzony_termin']
    ,'sad_miasto' => $dane['sad_miasto']
    ,'wokanda_miasto' => $dane['wokanda_miasto']
    ,'wokanda_prowadzacy' => $dane['wokanda_prowadzacy']
    ,'sygnatura_akt' => $dane['sygnatura_akt']
    ,'klient_imie' => $dane['klient_imie']
    ,'klient_nazwisko' => $dane['klient_nazwisko']
    ,'sprawa_pce_numer' => $dane['sprawa_pce_numer']
    ,'imie_substytut'  => $dane['imie_substytut']
    ,'nazwisko_substytu' => $dane['nazwisko_substytu']
    ,'substytut_votum' => $dane['substytut_votum']
    ,'sprawa_druga_strona' => $dane['sprawa_druga_strona']
    ,'sprawa_prawnik_prowadzacy' => $dane['sprawa_prawnik_prowadzacy']
    ,'faktura_numer' => $dane['faktura_numer']
    ,'faktura_zrealizowana' => $dane['faktura_zrealizowana']
    ,'koszt_ponosi_votum' => $dane['koszt_ponosi_votum']
    ,'wokanda_etap' => $dane['wokanda_etap']
    ,'wokanda_etap2' => $dane['wokanda_etap_2']
    ,'wokanda_etap_sprawy' => $dane['wokanda_etap_sprawy']
    ,'wps_od' => $dane['wps_od']
    ,'wps_do' => $dane['wps_do']
    ,'wokanda_rodzaj' => $dane['wokanda_rodzaj']
    ,'sprawa_trudna' => ''
    ,'substytut_uprawnienie' => ''
    );
    $lista_wynikow = $db->wywolaj_procedure('wokanda_lista_wokand_moje_wszystkie', $wartosci);

    echo '<div class="panel panel-default">';
    echo '<div class="panel-heading aktywny cursor_p">Wyniki<span class="badge">'.$lista_wynikow->num_rows.'</span></div>';
    echo '<div class="panel-body" style="display:block">';
    echo '<div class="table-responsive moja_tabela">';
    echo '<table id="" class="tabela_lista_wokand_filtruj table_data_table table table-striped table-hover">';
    echo '<thead>';
    echo '<tr data-element_id="0">';
    echo '<th class="ukryj">ID</th>';
    echo '<th class="ukryj">Nazwa</th>';
    echo '<th class="ukryj">Koniec</th>';
    echo '<th class="col-md-1">Data</th>';
    echo '<th class="col-md-1">Początek</th>';
    echo '<th class="col-md-2">Nr sprawy</th>';
    echo '<th class="ukryj">Sąd nazwa</th>';
    echo '<th class="col-md-2">Miasto</th>';
    echo '<th class="col-md-2">Prowadzący</th>';
    echo '<th class="col-md-2">Powód</th>';
    echo '<th class="col-md-1">Sygnatura</th>';
    echo '<th class="col-md-1">Sybstytut</th>';
    echo '<th class="col-md-1"><i class="fa ikona_zaznacz_w zaznacz_wszystkie_wyniki fa-square-o" aria-hidden="true"></i></th>';
    echo '<th class="ukryj"></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    if(!is_null($lista_wynikow)){
        $wokanda_edytuj = '';
        if(in_array(24, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
            $wokanda_edytuj = 'wokanda_edytuj';
        }
        //print_r($lista_wynikow->fetch_object());
        while ($poj_lista_wynikow = $lista_wynikow->fetch_object()) {
            $style= '';
            if($poj_lista_wynikow->slownik_wokanda_etap_id == 5
                || $poj_lista_wynikow->slownik_wokanda_etap_id == 9
                || $poj_lista_wynikow->slownik_wokanda_etap_id == 8){
                $style = 'style="color:#FFF; background:rgba(92, 184, 92, 0.7);"';
            }else if($poj_lista_wynikow->slownik_wokanda_etap_id == 3 || $poj_lista_wynikow->slownik_wokanda_etap_id == 4)
            {
                $style = 'style="color:#FFF; background:rgb(234, 160, 1);"';
            }
            echo '<tr '.$style.' data-element_id="'.$poj_lista_wynikow->id.'" class="" data-toggle="tooltip" data-placement="top" title="'.$poj_lista_wynikow->sad_nazwa.', '.$poj_lista_wynikow->sad_ulica.'" data-element_id="'.$poj_lista_wynikow->id.'">';
            echo '<td class="ukryj">'.$poj_lista_wynikow->id.'</td>';
            echo '<td class="ukryj">'.$poj_lista_wynikow->nazwa.'</td>';
            $poj_lista_wokand_data_start = explode(' ',$poj_lista_wynikow->start);
            $poj_lista_wokand_data_stop = explode(' ',$poj_lista_wynikow->stop);
            echo '<td class="ukryj '.$wokanda_edytuj.'">'.$poj_lista_wokand_data_stop[1].'</td>';

            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-1 '.$wokanda_edytuj.'">'.$poj_lista_wokand_data_start[0].'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-1 '.$wokanda_edytuj.'">'.$poj_lista_wokand_data_start[1].'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-2 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->sprawa_pce_numer.'</td>';
            echo '<td class="ukryj '.$wokanda_edytuj.'">'.$poj_lista_wynikow->sad_nazwa.'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-2 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->sad_miasto.'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-2 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->sprawa_prawnik.'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-2 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->klient_imie.' '.$poj_lista_wynikow->klient_nazwisko.'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-1 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->sygnatura_akt.'</td>';
            echo '<td data-element_id="'.$poj_lista_wynikow->id.'" class="col-md-1 '.$wokanda_edytuj.'">'.$poj_lista_wynikow->substytut_nazwisko. ' '.$poj_lista_wynikow->substytut_imie.'</td>';
            echo '<td class="col-md-1"><i class="fa ikona_zaznacz_w zaznacz_wynik fa-square-o" aria-hidden="true"></i></td>';
            echo '<td class="ukryj"></td>';
            echo '</tr>';
        }
    }


    echo '</tbody>';
    ?>

    <div class=" masowe_dzialania well well-sm">
        <div class="dropdown float_l">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="element_grupa_opcja_naglowek float_l" value="0">Masowe działania</span>
                <span class="caret float_r"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="dropdown-menu_opcja element_grupa_opcja" data-element_id="0" data-wartosc="Masowe działania">Brak akcji...</li>

            </ul>
        </div>
        <button disabled type="button" class="float_l btn btn-default masowe_dzialania_p  btn-block text-uppercase"  title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type='button' class='width_100 masowe_dzialanie_dla_zaznaczonych btn btn-danger'>TAK</button>">Zapisz</button>
        <div class="clear_b"></div>
    </div>
    <div class="clear_b margin_b_10"></div>

    <?php
    echo '</table>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
}

if($akcja === 'substytut_sprawdz_ostatni'){
    $numer_sprawy_pce = (isset($_POST['numer_sprawy_pce'])) ? htmlspecialchars($_POST['numer_sprawy_pce']) : '' ;

    $substytut = $db->wywolaj_procedure('substytut_ostatni_substytut_po_numerze_sprawy', array( 'numer_sprawy_pce' => $numer_sprawy_pce ));

    if(($substytut->num_rows) != 0){

        $substytut = $substytut->fetch_object();

        $dane = array(
            'substytut_id' => $substytut->substytut_id
        ,'imie' => $substytut->substytut_imie
        ,'nazwisko' => $substytut->substytut_nazwisko
        ,'koszt_stawiennictwa' => $substytut->koszt_stawiennictwa_domyslny
        ,'forma_platnosci_nazwa' => mb_ucfirst($substytut->wartosc)
        ,'uprawnienia' => mb_ucfirst($substytut->substytut_uprawnienie)
        ,'ulica' => $substytut->substytut_ulica
        ,'miasto' => mb_ucfirst($substytut->substytut_miasto)
        ,'wojewodztwo' => mb_ucfirst($substytut->substytut_wojewodztwo)
        ,'forma_platnosci_id' => $substytut->forma_platnosci_id_domyslna
        ,'email' => $substytut->email
        ,'email2' => $substytut->email2
        ,'telefon' => $substytut->nr_telefonu
        ,'czy_votum' => $substytut->czy_votum


        );
    }else{
        $dane = array(
            'substytut_id' => '0'
        );
    }

    echo json_encode($dane);

    return;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
