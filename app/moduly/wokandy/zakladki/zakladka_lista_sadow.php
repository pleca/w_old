<?php /* Nazwa: Lista Sądów */ ?>
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');	
		
	function wygeneruj_panel_z_tabelka($lista_wynikow, $tytul, $uzytkownik, $db){
		if(!is_null($lista_wynikow)){
			echo '<div class="panel panel-default">';
				echo '<div class="panel-heading cursor_p">'.$tytul.'<span class="badge">'.$lista_wynikow->num_rows.'</span></div>';
				echo '<div class="panel-body">';
				?>
							<div class="table-responsive moja_tabela">
								<table id="" class="tabela_lista_sadow table_data_table table table-striped table-hover">
									<thead>
										<tr>
											<th class="ukryj">ID</th>
											<th class="col-md-5">Nazwa</th>
											<th class="col-md-2">Miasto</th>
											<th class="col-md-3">Ulica</th>
											<th class="col-md-2">Kod pocztowy</th>
											<th class="ukryj"></th>
										</tr>
									</thead>
									<tbody>														
										<?php 
											while ($poj_sad = $lista_wynikow->fetch_object()) {
												$miasto_nazwa = $db-> pobierz_wartosc('nazwa', 'slownik_miasto', 'id', $poj_sad->miasto_id);
												echo '<tr class="';
													if(in_array(11, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
														echo 'sad_edytuj cursor_p';
													}
												echo '" data-element_id="'.$poj_sad->id.'">';
													echo '<td class="ukryj">'.$poj_sad->id.'</td>';
													echo '<td class="col-md-5">'.$poj_sad->nazwa.'</td>';
													echo '<td class="col-md-2">'.$miasto_nazwa->nazwa.'</td>';
													echo '<td class="col-md-3">'.$poj_sad->ulica.'</td>';
													echo '<td class="col-md-2">'.$poj_sad->kod_pocztowy.'</td>';
													echo '<td class="ukryj"></td>';
												echo '</tr>';
											}
										?>
									</tbody>
								</table>
							</div>
						<?php
					echo '</div>';
				echo '</div>';
			}
	}
	
	
	?>
	
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#aktywni" aria-controls="aktywni" role="tab" data-toggle="tab">Aktywne</a></li>
		<?php if(in_array(14, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<li role="presentation"><a href="#usunieci" aria-controls="usunieci" role="tab" data-toggle="tab">Usunięte</a></li>
		<?php } ?>
	</ul> 
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="aktywni">
			<?php 
			
				$lista_rodzajow_sadow = $db->pobierz_wartosci_where('slownik_sad_typ', 'czy_usuniety = 0 order by wartosc ASC');
				if(!is_null($lista_rodzajow_sadow)){
					while ($poj_lista_rodzajow_sadow = $lista_rodzajow_sadow->fetch_object()) {
						
						$lista_sadow = $db->pobierz_wartosci_where('slownik_sad', 'czy_usuniety = 0 AND slownik_sad_typ_id = '.$poj_lista_rodzajow_sadow->id.' ');
						
						wygeneruj_panel_z_tabelka($lista_sadow, 'Sąd '.mb_ucfirst($poj_lista_rodzajow_sadow->wartosc), $uzytkownik, $db);
					}
				}
				
			?>
		</div>
		<div role="tabpanel" class="tab-pane" id="usunieci">
			<?php 
				$liczba_usunietych = $db->pobierz_wartosc('id', 'slownik_sad', 'czy_usuniety', '1');
				if(empty($liczba_usunietych)){
					echo 'Brak danych...';
				}
			
				$lista_rodzajow_sadow = $db->pobierz_wartosci_where('slownik_sad_typ', 'czy_usuniety = 0 order by wartosc ASC');
				if(!is_null($lista_rodzajow_sadow)){
					while ($poj_lista_rodzajow_sadow = $lista_rodzajow_sadow->fetch_object()) {
							
						$lista_sadow = $db->pobierz_wartosci_where('slownik_sad', 'czy_usuniety = 1 AND slownik_sad_typ_id = '.$poj_lista_rodzajow_sadow->id.' ');
							
						wygeneruj_panel_z_tabelka($lista_sadow, 'Sąd '.mb_ucfirst($poj_lista_rodzajow_sadow->wartosc), $uzytkownik, $db);
					}
				}
				
			?>
		</div>
	</div>	
	
	
	
	
	
	
	
	
	
	
