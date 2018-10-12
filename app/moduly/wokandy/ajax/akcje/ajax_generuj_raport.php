<?php require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php'); ?>
<?php
//$element_id = (isset($_POST['element_id'])) ? htmlspecialchars($_POST['element_id']) : '' ;
//$wartosc = (isset($_POST['wartosc'])) ? htmlspecialchars($_POST['wartosc']) : '' ;

//$wokanda_baza = $db->pobierz_wiersz('wokanda', 'id', $element_id);
$raport_nr = (isset($_POST['raport'])) ? htmlspecialchars($_POST['raport']) : '';
$data = (isset($_POST['data'])) ? htmlspecialchars($_POST['data']) : '';

if($raport_nr == '6'){
    $elements = (isset($_POST['elements'])) ? htmlspecialchars($_POST['elements']) : '';
    $raport_dane = array(
        'ids' => $elements
    );
    $raport1 = $db->wywolaj_procedure('raport_ObslugaWokandLista', $raport_dane);
}
else if($raport_nr == '5'){
    $elements = (isset($_POST['elements'])) ? htmlspecialchars($_POST['elements']) : '';
    $raport_dane = array(
        'ids' => $elements
    );
    $raport1 = $db->wywolaj_procedure('raport_ObslugaWokandFinanseZalacznikPodFakture', $raport_dane);

}else if($raport_nr == '4'){
    $raport1 = $db->wywolaj_procedure('raport_ObslugaWokandWyjazdy', null);
}else {
    if(empty($data)){
        $data = date("Y-m-d");
    };
    $wartosci = array(
        'nrRaportu' => $raport_nr,
        'dataRaportu' => $data
    );
    $raport1 = $db->wywolaj_procedure('raport_ObslugaWokand', $wartosci);
}
$raport = array();

while($poj_raport1 = $raport1->fetch_object()){
    array_push($raport, $poj_raport1);
}
echo json_encode($raport);
//return;

?>