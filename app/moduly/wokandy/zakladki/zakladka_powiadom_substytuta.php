<?php /* Nazwa: Powiadom substytuta */ ?>
<?php
    require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');

    $conectionPDO = new PDO('mysql:host='.DB_HOST.'; dbname = '.DB_NAME.'; charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

    $stmt = $conectionPDO->prepare("call wokandy.substytut_liczba_najblizszych_wokand(?);");
    $id = 0;
    $stmt->bindParam(1, $id, PDO::PARAM_STR, 8000);
    $stmt-> execute();
    $results = $stmt->fetchAll();
?>


<table class="table table-striped tabela_lista_substytutow_pow">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Email</th>
            <th>Ilość</th>
            <th>Najbliższy termin</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($results as $element){
            ?>
                <tr id="substytut_<?php echo $element['id']; ?>">
                    <td><?php echo $element['id']; ?></td>
                    <td><?php echo $element['nazwa']; ?></td>
                    <td><?php echo $element['email']; ?></td>
                    <td><?php echo $element['IloscTerminow']; ?></td>
                    <td><?php echo $element['NajwczesniejszyTermin']; ?></td>
                    <td><i data-substytut_id="<?php echo $element['id']; ?>" class="fa fa-envelope-o wygenerujWiadomoscDoSubstytuta" aria-hidden="true"></i></td>
                </tr>
            <?php
        }
    ?>

    </tbody>
</table>
