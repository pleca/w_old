<?php /* Nazwa: Lista użytkowników */ ?>
<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');		
?>
		
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#aktywni" aria-controls="aktywni" role="tab" data-toggle="tab">Aktywni</a></li>
		<?php if(in_array(8, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<li role="presentation"><a href="#usunieci" aria-controls="usunieci" role="tab" data-toggle="tab">Usunięci</a></li>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="aktywni">
			<?php 	
				$lista_grup = $db->pobierz_wiersze('uzytkownik_grupy', 'czy_usuniety', '0');
				
				if(!is_null($lista_grup)){
					while ($poj_grupa = $lista_grup->fetch_object()) {
						$lista_uzytkownikow_dla_grupy = $db->pobierz_wartosci_where('uzytkownik', 'czy_usuniety = 0 AND uzytkownik_grupy_id ='.$poj_grupa->id);
						$liczba_uzytkownikow_w_grupie = (is_null($lista_uzytkownikow_dla_grupy)) ? '0' : $lista_uzytkownikow_dla_grupy->num_rows ;
						
						if(!is_null($lista_uzytkownikow_dla_grupy)){
							echo '<div class="panel panel-default">';
								echo '<div class="panel-heading cursor_p">'.$poj_grupa->wartosc.'<span class="badge">'.$liczba_uzytkownikow_w_grupie.'</span></div>';
								echo '<div class="panel-body">';
									?>
										<div class="table-responsive moja_tabela lista_uzytkownikow_lista">
											<table id="" class="tabela_lista_uzytkownikow table table-striped">
												<thead>
													<tr>
														<th class="col-md-1">ID</th>
														<th class="col-md-2">Login</th>
														<th class="col-md-2">Imię</th>
														<th class="col-md-3">Nazwisko</th>
														<th class="col-md-3">Ostatnie logowanie</th>
														<th class="col-md-1"></th>
													</tr>
												</thead>
												<tbody>														
													<?php 
														while ($poj_uzytkownik = $lista_uzytkownikow_dla_grupy->fetch_object()) {
															echo '<tr data-element_id="'.$poj_uzytkownik->id.'">';
																echo '<td class="col-md-1">'.$poj_uzytkownik->id.'</td>';
																echo '<td class="col-md-2">'.$poj_uzytkownik->login.'</td>';
																echo '<td class="col-md-2">'.$poj_uzytkownik->imie.'</td>';
																echo '<td class="col-md-3">'.$poj_uzytkownik->nazwisko.'</td>';
																echo '<td class="col-md-3">'.$poj_uzytkownik->data_ostatniego_logowania.'</td>';
																echo '<td class="col-md-1">';
																	if(in_array(7, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
																		echo '<i class="fa fa-pencil uzytkownik_edytuj" aria-hidden="true" ></i>';
																	}												
																echo '</td>';
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
				}
			?>
		</div>
		<?php if(in_array(8, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){ ?>	
			<div role="tabpanel" class="tab-pane" id="usunieci">
				<?php 	
					$lista_grup = $db->pobierz_wiersze('uzytkownik_grupy', 'czy_usuniety', '0');
					
					if(!is_null($lista_grup)){
						$liczba_usunietych = $db->pobierz_wartosc('id', 'uzytkownik', 'czy_usuniety', '1');
						if(empty($liczba_usunietych)){
							echo 'Brak danych...';
						}
						while ($poj_grupa = $lista_grup->fetch_object()) {
							$lista_uzytkownikow_dla_grupy = $db->pobierz_wartosci_where('uzytkownik', 'czy_usuniety = 1 AND uzytkownik_grupy_id ='.$poj_grupa->id);
							$liczba_uzytkownikow_w_grupie = (is_null($lista_uzytkownikow_dla_grupy)) ? '0' : $lista_uzytkownikow_dla_grupy->num_rows ;
							
							if(!is_null($lista_uzytkownikow_dla_grupy)){
								echo '<div class="panel panel-default">';
									echo '<div class="panel-heading cursor_p">'.$poj_grupa->wartosc.'<span class="badge">'.$liczba_uzytkownikow_w_grupie.'</span></div>';
									echo '<div class="panel-body">';
										?>
											<div class="table-responsive moja_tabela">
												<table id="" class="lista_uzytkownikow_lista tabela_lista_uzytkownikow table table-striped">
													<thead>
														<tr>
															<th class="col-md-1">ID</th>
															<th class="col-md-3">Login</th>
															<th class="col-md-3">Imię</th>
															<th class="col-md-4">Nazwisko</th>
															<th class="col-md-1"></th>
														</tr>
													</thead>
													<tbody>														
														<?php 
															while ($poj_uzytkownik = $lista_uzytkownikow_dla_grupy->fetch_object()) {
																echo '<tr data-element_id="'.$poj_uzytkownik->id.'">';
																	echo '<td class="col-md-1">'.$poj_uzytkownik->id.'</td>';
																	echo '<td class="col-md-3">'.$poj_uzytkownik->login.'</td>';
																	echo '<td class="col-md-3">'.$poj_uzytkownik->imie.'</td>';
																	echo '<td class="col-md-4">'.$poj_uzytkownik->nazwisko.'</td>';
																	echo '<td class="col-md-1">';
																		if(in_array(7, $uzytkownik->__get('_lista_przyznanych_uprawnien'))){
																			echo '<i class="fa fa-pencil uzytkownik_edytuj" aria-hidden="true" ></i>';
																		}
																	echo '</td>';
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
					}
				?>
			</div>
		<?php } ?>
	</div>
	