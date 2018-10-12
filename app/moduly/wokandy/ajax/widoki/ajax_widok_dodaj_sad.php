<?php require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php'); ?>

<div class="input_50p sad_dodaj_nowy_dane">
    <div class="dropdown lista_typow_sadow">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <span class="element_grupa_opcja_naglowek nazwa_woj sad_typ " data-wartosc_domyslna="" value="" >Typ sądu</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <?php
            $lista_typow = $db->pobierz_wiersze('slownik_sad_typ', 'czy_usuniety', '0');
            while ($poj_lista_typow = $lista_typow->fetch_object()) {
                echo '<li id="sad_typ_'.$poj_lista_typow->id.'" class="typ_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p " data-wartosc="'.mb_ucfirst($poj_lista_typow->wartosc).'" data-element_id="'.$poj_lista_typow->id.'">';
                echo '<i class="fa fa-check" aria-hidden="true"></i>';
                echo mb_ucfirst($poj_lista_typow->wartosc);
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    <div class="form-group sad_nazwa_pole">
        <input class="form-control pole_input_fokus sad_nazwa" placeholder="Nazwa" type="text" data-wartosc_domyslna ="" value="" >
        <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="form-group sad_ulica_pole">
        <input class="form-control pole_input_fokus sad_ulica" placeholder="Ulica" type="text" data-wartosc_domyslna ="" value="" >
        <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="form-group">
        <input class="form-control pole_input_fokus sad_miasto" placeholder="Miasto" type="text" data-miasto_id="" data-wartosc_domyslna ="" value="" >
        <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="form-group sad_kod_pocztowy_pole">
        <input class="form-control pole_input_fokus sad_kod_pocztowy" placeholder="Kod pocztowy" type="text" data-wartosc_domyslna ="" value="" >
        <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
    </div>
    <?php lista_wojewodz(); ?>
    <div class="clear_b"></div>
    <?php if(in_array(16, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
        <button type="button" class="btn btn-default btn-block przycisk_zapisz_zmiany text-uppercase dodaj <?php echo ($_POST['popUp']) ? 'sad_dodaj_pop_up' : '' ; ?> sad_dodaj">Zapisz</button>
    <?php } ?>
</div>