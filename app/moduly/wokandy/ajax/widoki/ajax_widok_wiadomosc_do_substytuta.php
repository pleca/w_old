<?php
    require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');

    $substytut_id = (isset($_POST['substytut_id'])) ? htmlspecialchars($_POST['substytut_id']) : '' ;
    $substytut = $db->pobierz_wiersz('substytut', 'id', $substytut_id);
?>

<div class="well well-sm margin_b_10">
    <?php echo $substytut->imie.' '.$substytut->nazwisko; ?>
</div>

<div class="form-group ">
    <input class="form-control substytut_email border_radius_0" value="<?php echo $substytut->email; ?>" placeholder="Email substytuta" type="text">
</div>

<div class="well well-sm margin_b_10">
    <span>DW:</span>
</div>

<div class="form-group ">
    <input class="form-control dw_email border_radius_0" placeholder="Email" type="text">
</div>




<?php
    $polaczeniePDO = $db->polaczeniePDO();

    $stmt = $polaczeniePDO->prepare("call wokandy.substytut_pobranie_terminow(?);");
    $stmt->bindParam(1, $substytut_id, PDO::PARAM_INT);
    $stmt-> execute();

    $results = $stmt->fetchAll();

?>


<div class="tabela_lista_substytutow_do_pow">
    <table class="table table-bordered ">
        <thead>
            <tr bgcolor="#cec4c4" class="naglowekTabeli">
                <td>Data</td>
                <td>Godzina rozpoczęcia</td>
                <td>Sąd</td>
                <td>Miasto</td>
                <td>Sala</td>
                <td>Sygnatura akt</td>
                <td>Nazwisko i imię klienta</td>
                <td>Osoba prowadząca</td>
                <td id="edit_table" >Usuń wiersz</td>
            </tr>
        </thead>
        <tbody>
        <?php
			$index = 0;
            foreach($results as $element){
				$index++;
				?>
				
                    <tr class="row-<?php echo $index ?>">
                        <td contenteditable="true"><?php echo $element['DataWokandy']; ?></td>
                        <td contenteditable="true"><?php echo $element['GodzinaWokandy']; ?></td>
                        <td contenteditable="true"><?php echo $element['Sad']; ?></td>
                        <td contenteditable="true"><?php echo $element['Miasto']; ?></td>
                        <td contenteditable="true"><?php echo $element['Sala']; ?></td>
                        <td contenteditable="true"><?php echo $element['SygnaturaAkt']; ?></td>
                        <td contenteditable="true"><?php echo $element['Klient']; ?></td>
                        <td contenteditable="true"><?php echo $element['OsobaProwadzaca']; ?></td>
                        <td class="remove_col"><button type="button" class="btn btn-danger removeRow" >X</button></td>
                    </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>
<button type="button" class="btn btn-success width_100 wyslijWiadomoscOTerminachDoSubstytuta" data-substytut_id="<?php echo $substytut_id; ?>">Wyślij wiadomość</button>
