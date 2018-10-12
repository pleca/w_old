<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
?>
<div class="well well-sm margin_b_0 wyszukaj_dane_pce_pola">
	<div class="input_25p">
		<div class="form-group">
			<input type="text" class="form-control klient_imie_pop" value="" placeholder="Imię">
		</div>
		<div class="form-group">
			<input type="text" class="form-control klient_nazwisko_pop" value="" placeholder="Nazwisko">
		</div>
		<div class="form-group">
			<input type="text" class="form-control klient_nr_sprawy_pop" value="" placeholder="Numer sprawy">
		</div>
		<div class="form-group">		
			<button class="btn btn-default btn-block text-uppercase  szukaj_danych_w_bazie">Szukaj</button>
		</div>	
		<div class="clear_b"></div>			
	</div>
</div>
<div id="wyniki_wyszukiwania" class="wyniki_wyszukiwania">

	<div class="panel panel-default margin_t_10">
			<div class="panel-heading aktywny">Wyniki<span class="badge">0</span></div>
			<div class="panel-body" style="display:block">
				
					<div class="table-responsive moja_tabela ">
						<table id="" class="tabela_lista_klientow lista_klientow_lista_pce table_data_table table table-striped table-hover">
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
								
							</tbody>
						</table>
					</div>
				
			</div>
		</div>

</div>