<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$id_sad = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : '' ;
	$tab = (isset($_POST['tab'])) ? htmlspecialchars($_POST['tab']) : '' ;
	
	$sad = $db->pobierz_wiersz('slownik_sad', 'id', $id_sad);
	
	$sad_miasto = $db->pobierz_wiersz('slownik_miasto', 'id', $sad->miasto_id);
	$aktualne_woj = $db->pobierz_wartosc('nazwa', 'slownik_wojewodztwo', 'id', $sad_miasto->wojewodztwo_id);
	
	$sad_typ = $db->pobierz_wiersz('slownik_sad_typ', 'id', $sad->slownik_sad_typ_id);

?>	
<div class="element_szczegoly" data-element_id="<?php echo $id_sad; ?>" data-widok="<?php echo $tab; ?>">
	<div class="text-uppercase">
		<span>szczegóły sądu(<?php echo $id_sad; ?>)</span>
		<?php 
			if($tab === 'aktywni'){
				if(in_array(12, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					echo '<i class="fa fa-trash sad_usun_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 sad_usun btn btn-danger\'>TAK</button>"></i>';						
				}
			}
			
			if($tab === 'usunieci'){
				if(in_array(13, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					echo '<i class="fa fa-undo sad_przywroc_przycisk" aria-hidden="true" title="Czy jesteś pewnien?" data-placement="left" data-toggle="popover" data-content="<button type=\'button\' class=\'width_100 sad_przywroc btn btn-danger\'>TAK</button>"></i>';
				}
			}
		?>
		<div class="clear_b"></div>
	</div>
</div>
	
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#ogolne" aria-controls="ogolne" role="tab" data-toggle="tab">Ogólne</a></li>
		<?php if(in_array(15, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>
			<li role="presentation"><a href="#historia" aria-controls="historia" role="tab" data-toggle="tab">Historia</a></li>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="ogolne"> 
			
			<div class="input_50p">
				<div class="dropdown lista_typow_sadow">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span class="element_grupa_opcja_naglowek sad_typ " data-wartosc_domyslna="<?php echo $sad_typ->id; ?>" value="<?php echo $sad_typ->id; ?>" ><?php echo mb_ucfirst($sad_typ->wartosc); ?></span>
										<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				    	<?php 					
							$lista_typow = $db->pobierz_wiersze('slownik_sad_typ', 'czy_usuniety', '0');
							while ($poj_lista_typow = $lista_typow->fetch_object()) {
								echo '<li id="sad_typ_'.$poj_lista_typow->id.'" class="typ_grupa_opcja element_grupa_opcja  dropdown-menu_opcja cursor_p '.( ($poj_lista_typow->id === $sad->slownik_sad_typ_id) ? 'aktywna' : '' ).'" data-wartosc="'.mb_ucfirst($poj_lista_typow->wartosc).'" data-element_id="'.$poj_lista_typow->id.'">';
									echo '<i class="fa fa-check" aria-hidden="true"></i>';
									echo mb_ucfirst($poj_lista_typow->wartosc);
								echo '</li>';
							}
						?>
			 		</ul>
				</div>
				<div class="form-group sad_nazwa_pole">
					<input class="form-control pole_input_fokus sad_nazwa" placeholder="Nazwa" type="text" data-wartosc_domyslna ="<?php echo $sad->nazwa ?>" value="<?php echo $sad->nazwa ?>" >
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group sad_ulica_pole">
					<input class="form-control pole_input_fokus sad_ulica" placeholder="Ulica" type="text" data-wartosc_domyslna ="<?php echo $sad->ulica ?>" value="<?php echo $sad->ulica ?>" >
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group">
					<input class="form-control pole_input_fokus sad_miasto" placeholder="Miasto" type="text" data-miasto_id="<?php echo $sad->miasto_id ?>" data-wartosc_domyslna ="<?php echo $sad_miasto->nazwa; ?>" value="<?php echo $sad_miasto->nazwa; ?>" >
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>					
				</div>				
				<div class="form-group sad_kod_pocztowy_pole">
					<input class="form-control pole_input_fokus sad_kod_pocztowy" placeholder="Kod pocztowy" type="text" data-wartosc_domyslna ="<?php echo $sad->kod_pocztowy; ?>" value="<?php echo $sad->kod_pocztowy; ?>" >
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				</div>
					<?php lista_wojewodz($sad_miasto->wojewodztwo_id, $aktualne_woj->nazwa); ?>
				<div class="clear_b"></div>
				<?php if(in_array(11, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
					<button type="button" class="btn btn-default przycisk_zapisz_zmiany btn-block text-uppercase aktualizuj sad_aktualizuj">Zapisz zmiany</button>
				<?php } ?>
			</div>
			
		</div>
		<div role="tabpanel" class="tab-pane " id="historia">
			<?php 
				if(in_array(15, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
					zakladka_historia('slownik_sad_historia_zmian', 'sad_id', $db, $id_sad);
				}				 				
			?>
		</div>
	</div>