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

if($akcja === 'wokanda_duplikuj_wokande'){
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
        'wokanda_id' => $wokanda_id,
        'uzytkownik_id' => $uzytkownik->__get('_id')
    );
    $newId = $db->wywolaj_procedure('wokanda_duplikuj_wokande', $wartosci, 1 );
    //$newId = $newId->fetch_object();
    $dane = array(
        0 => $newId
    );
    echo json_encode($dane);
    return;

}




