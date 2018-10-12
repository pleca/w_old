<?php /* Nazwa: Raporty */ ?>
<?php
require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');

?>

<h3>Generuj raport: </h3>

<div class="row">
    <div class="col-xs-3">
        <button class="raport1_btn btn btn-default">Raport 1</button>
    </div>
    <div class="col-xs-3">
        <button class="raport2_btn btn btn-default">Raport 2</button>
    </div>
    <div class="col-xs-3">
        <button class="raport3_btn btn btn-default">Raport 3</button>
    </div>
    <div class="col-xs-3">
        <button class="raport4_btn btn btn-default">Raport 4</button>
    </div>
</div>
<div class="row">
    <div class="raport_table col-xs-12">
        <div class="grid1">
            <div id="grid"></div>
            <div class="error"></div>
        </div>
        <div class="grid2">
            <div class="row">
                <div class="col-xs-9">
                    <input id="data_raport2" type="text" class="wymagane form-control data" data-kolumna="data_raport2" placeholder="Wybierz datę">
                </div>
                <div class="col-xs-3">
                    <button class="btn btn-default generuj_raport2_data">
                        Wygeneruj raport
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="grid2"></div>
                    <div class="error"></div>
                </div>
            </div>
        </div>
        <div class="grid3">
            <div id="grid3"></div>
            <div class="error"></div>
        </div>
        <div class="grid4">
            <div id="grid4"></div>
            <div class="error"></div>
        </div>
    </div>
</div>
            <!--<ul class="nav nav-tabs" role="tablist">-->
<!--    <li role="presentation" class="active"><a href="#raport1" class="raport1_tab" aria-controls="raport1" role="tab" data-toggle="tab">Raport 1</a></li>-->
<!--<!--    --><?php ////if(in_array(17, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
<!--        <li role="presentation"><a href="#raport2" class="raport2_tab" aria-controls="raport2" role="tab" data-toggle="tab">Raport 2</a></li>-->
<!--<!--    --><?php ////} ?>
<!--    <li role="presentation" class=""><a href="#raport3" class="raport3_tab" aria-controls="raport3" role="tab" data-toggle="tab">Raport 3</a></li>-->
<!--    <li role="presentation" class=""><a href="#raport4"  class="raport4_tab" aria-controls="raport4" role="tab" data-toggle="tab">Raport 4</a></li>-->
<!--</ul>-->

<!--<div class="tab-content">-->
<!--    <div role="tabpanel" class="tab-pane active" id="raport1">-->
<!--        <div id="grid"></div>-->
<!--    </div>-->
<!--    <div role="tabpanel" class="tab-pane" id="raport2">-->
<!--        <div class="row" >-->
<!--            <div class="col-xs-8">-->
<!--                <input id="data_raport2" type="text" class="wymagane form-control data" data-kolumna="data_raport2" placeholder="Wybierz datę">-->
<!--            </div>-->
<!--            <div class="col-xs-2">-->
<!--                <button class="btn btn-default generuj_raport2_data">-->
<!--                    Wygeneruj raport-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div id="grid2"></div>-->
<!--    </div>-->
<!--    <div role="tabpanel" class="tab-pane" id="raport3">-->
<!--        <div id="grid3"></div>-->
<!--    </div>-->
<!--    <div role="tabpanel" class="tab-pane" id="raport4">-->
<!--        <div id="grid4"></div>-->
<!--    </div>-->
<!--</div>-->