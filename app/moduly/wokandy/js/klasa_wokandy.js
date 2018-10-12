wyswietl_panel_body();

require(adres_hosta+'/app/moduly/'+getCookie('modul')+'/js/klasa_'+getCookie('strona')+'.js');

if(getCookie('strona') == 'zarzadzanie_wokandami'){
	zarzadzanie_wokandami();
}

if(getCookie('strona') == 'wokandy_administracja'){
	wokandy_administracja();
}

function wokandy_administracja(){
	if($('#lista_sadow').hasClass('aktywny')){
		if(!$('.tabela_lista_sadow').hasClass('dataTable')){
			$('.tabela_lista_sadow').DataTable({
		        "language": {
		            "url": adres_hosta+'/app/jezyki/dataTable_pl.json'
		        },
		        "aoColumns": [
		                      null,
		                      null,
		                      null,
		                      null,
		                      { "orderSequence": [] }
		                  ],
		        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]],
		        "order": [[ 1, "asc" ]]
		                  
		    });
			$('[data-toggle="tooltip"]').tooltip();
			//$('.ukryj').css({'display':'none'});		
		}
		
		$('.sad_edytuj').click(function(){
			var id = $(this).parent().parent().data('element_id');
			var tab = 'aktywni';
			if($('#usunieci').hasClass('active')){
				tab = 'usunieci';
			}
			sad.sadEdytuj(id, tab);
		});
		
		$('.sad_usun_przycisk').click(function(){
			$('.sad_usun').click(function(){
				var id = $('.element_szczegoly').data('element_id');					
				sad.sadUsun(id);
			});
		});
		
		$('.sad_przywroc_przycisk').click(function(){
			$('.sad_przywroc').click(function(){
				var id = $('.element_szczegoly').data('element_id');					
				sad.sadPrzywroc(id);
			});
		});
		
		$('.sad_aktualizuj').click(function(){
			main_dane = {
					'_nazwa' : $('.sad_nazwa').val()
					,'_ulica' : $('.sad_ulica').val()
					,'_miasto' : $('.sad_miasto').val()
					,'_kod_pocztowy' : $('.sad_kod_pocztowy').val()
					,'_wojewodztwo_id' : $('.sad_wojewodztwo').attr('value')
					,'_typ_id' : $('.sad_typ').attr('value')
					
			};
						
			sad.sadAktualizuj(main_dane);

		});
	}

	if($('#dodaj_sad').hasClass('aktywny')){
		$('.sad_dodaj').click(function(){
			main_dane = {
					'_nazwa' : $('.sad_nazwa').val()
					,'_ulica' : $('.sad_ulica').val()
					,'_miasto' : $('.sad_miasto').val()
					,'_kod_pocztowy' : $('.sad_kod_pocztowy').val()
					,'_wojewodztwo_id' : $('.sad_wojewodztwo').attr('value')
					,'_typ_id' : $('.sad_typ').attr('value')
						
			};
				
			sad.sadDodaj(main_dane);
		});
	}

	if($('#lista_substytutow').hasClass('aktywny')){
		if(!$('.tabela_lista_substytutow').hasClass('dataTable')){
			$('.tabela_lista_substytutow').DataTable({
		        "language": {
		            "url": adres_hosta+'/app/jezyki/dataTable_pl.json'
		        },
		        "aoColumns": [
		                      null,
		                      null,
		                      null,
		                      null,
		                      null,
		                      { "orderSequence": [] }
		                  ],
		        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]],
		        "order": [[ 1, "asc" ]]
		                  
		    });
			$('[data-toggle="tooltip"]').tooltip();
			//$('.ukryj').css({'display':'none'});		
		}
		
		$('.substytut_edytuj').click(function(){
			var id = $(this).parent().parent().data('element_id');
			var tab = 'aktywni';
			if($('#usunieci').hasClass('active')){
				tab = 'usunieci';
			}
			substytut.substytutEdytuj(id, tab);
		});
		
		$('.substytut_aktualizuj').click(function(){
			main_dane = {
					'_imie' : $('.substytut_imie').val()
					,'_nazwisko' : $('.substytut_nazwisko').val()
					,'_koszt_stawiennictwa_domyslny' : $('.substytut_koszt_stawiennictwa_domyslny').val()
					,'_forma_platnosci_id_domyslna' : $('.forma_platnosci_nazwa').attr('value')
					
			};
						
			substytut.substytutAktualizuj(main_dane);
		});
		
		$('.substytut_dodaj').click(function(){
			main_dane = {
					'_imie' : $('.substytut_imie').val()
					,'_nazwisko' : $('.substytut_nazwisko').val()
					,'_koszt_stawiennictwa_domyslny' : $('.substytut_koszt_stawiennictwa_domyslny').val()
					,'_forma_platnosci_id_domyslna' : $('.forma_platnosci_nazwa').attr('value')
					
			};
						
			substytut.substytutDodaj(main_dane);
		});
		
		$('.substytut_usun_przycisk').click(function(){
			$('.substytut_usun').click(function(){
				var id = $('.element_szczegoly').data('element_id');					
				substytut.substytutUsun(id);
			});
		});
		
		$('.substytut_przywroc_przycisk').click(function(){
			$('.substytut_przywroc').click(function(){
				var id = $('.element_szczegoly').data('element_id');					
				substytut.substytutPrzywroc(id);
			});
		});
		
	}
}

function zarzadzanie_wokandami(){		
	if($('#kalendarz').hasClass('aktywny')){
		if($('.element_szczegoly').size() == 0){
			
			if($('#kalendarz_tresc').size() != 0){
				aktywuj_kalendarz();
			}
			
			
		}else{
			wstaw_dane_sadu();
			wczytaj_dane_substytut();
			wokanda_usun_przywroc('kalendarz', 'Kalendarz');
		}
	}

	if($('#dodaj_wokande').hasClass('aktywny')){
		wyszukaj_klienta();
		wstaw_dane_sadu();
		wczytaj_dane_substytut();
	}

	if($('#lista_wokand').hasClass('aktywny')){
		
		if(!$('.tabela_lista_wokand').hasClass('dataTable')){
			$('.tabela_lista_wokand').DataTable({
		        "language": {
		            "url": adres_hosta+'/app/jezyki/dataTable_pl.json'
		        },
		        "aoColumns": [
		                      null,
		                      null,
		                      null,
		                      null,
		                      null,
		                      null,
		                      { "orderSequence": [] }
		                  ],
		        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]],
		        "order": [[ 2, "desc" ]]
		                  
		    });
			$('[data-toggle="tooltip"]').tooltip();
			//$('.ukryj').css({'display':'none'});		
		}
			
		wyszukaj_klienta();
		wstaw_dane_sadu();
		wczytaj_dane_substytut();
		
		$('.wokanda_edytuj').click(function(){
			main_dane = {
					'_id' : $(this).parent().parent().data('element_id')
					,'_tab' : $('.tab-pane.active').attr('id')
			};
	        
	        wokanda.wokandaSzczegoly(main_dane);
		});
		
		wokanda_usun_przywroc('lista_wokand', 'Lista Wokand');
	}
}


function aktywuj_kalendarz(){
	require(adres_hosta+'/biblioteki/fullcalendar/fullcalendar.js');
	require(adres_hosta+'/biblioteki/fullcalendar/locale/pl.js');
	
	var formData = new FormData();
	var odpowiedz = zadanieAjax('app/ajax/akcje/ajax_lista_uprawnien', formData);
	var uprawnienia = $.parseJSON(odpowiedz);
	
	var lista_wokand = wokanda.wokandyLista('kalendarz');
	
	setTimeout(function(){ 
			
		$('#kalendarz_tresc').fullCalendar({
			events: lista_wokand,
		    lang: 'pl',
		    timezone: 'local',
		    header: {
		        left: 'prev,next today',
		        center: 'title',
		        right: 'month,agendaWeek,agendaDay'
		    },
		    defaultView: 'agendaWeek',
		    editable: sprawdz_uprawnienie(uprawnienia[3], 21),
		    height: 'auto',
		    droppable: sprawdz_uprawnienie(uprawnienia[3], 21),
		    slotDuration: '00:20:00',
		    minTime: '08:00:00',
		    maxTime: '18:00:00'
		    ,timeFormat: 'H:mm'
		    	
		    ,dayClick: function (date, allDay, jsEvent, view) {
		    	if(sprawdz_uprawnienie(uprawnienia[2], 9)){
		    		main_dane = {
							'_data' : moment(date).format('YYYY-MM-DD')
							,'_czas' : moment(date).format('HH:mm:ss')
					};
			        
			        wokanda.wokandaDodaj(main_dane);
		    	}
		    },eventClick: function (calEvent, jsEvent, view) {
		    	if(sprawdz_uprawnienie(uprawnienia[3], 24)){
			    	main_dane = {
							'_id' : calEvent.id
							,'_tab' : 'aktywni'
					};
			    			        
			        wokanda.wokandaSzczegoly(main_dane);
		    	}
		    },eventResize: function (event, delta, revertFunc) {
		    	if(sprawdz_uprawnienie(uprawnienia[3], 21)){
		        	main_dane = {
							'_data' : moment(event.start).format('YYYY-MM-DD')
							,'_czas_start' : moment(event.start).format('HH:mm:ss')
							,'_czas_stop' : moment(event.end).format('HH:mm:ss')
							,'_id' : event.id
					};
		        	
		        	wokanda.wokandaAktualizujCzas(main_dane);
		    	}
	        },eventDrop: function (event, delta, revertFunc) {
		        	
	        	if(sprawdz_uprawnienie(uprawnienia[3], 21)){
		        	main_dane = {
							'_data' : moment(event.start).format('YYYY-MM-DD')
							,'_czas_start' : moment(event.start).format('HH:mm:ss')
							,'_czas_stop' : moment(event.end).format('HH:mm:ss')
							,'_id' : event.id
					};
		        	
		        	wokanda.wokandaAktualizujCzas(main_dane);
	        	}
	        }
		});

		kalendarz_czysczenie(uprawnienia);

		$('.fc-toolbar button').click(function(){
			kalendarz_czysczenie(uprawnienia);
		});
		
	}, 1);
	
}

function kalendarz_czysczenie(uprawnienia){
	$('.fc-time span').text(function(){
		var text_p = $(this).text();
		if(text_p.length == 2){
			$(this).text(text_p+':00');
		}
	});
	$('.fc-axis').css({'width':'37px'});

	$('.fc-day-grid').hide();
	
	$('.fc-day-grid-container .fc-day-grid').show();
			
	$('.fc-button').addClass('btn btn-default').removeClass('fc-button fc-state-default');
	
	if(sprawdz_uprawnienie(uprawnienia[3], 24)){
		$('.fc-event').addClass('cursor_p');
	}
	
	if(sprawdz_uprawnienie(uprawnienia[2], 9)){
		$(".fc-agendaWeek-view .fc-slats .fc-widget-content").each(function () {
	        if(!$(this).hasClass('fc-axis')){
	        	$(this).html('<table><tbody><tr class="poj_godzina"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');            
	        }		
		});
		$(".fc-agendaDay-view .fc-slats .fc-widget-content").each(function () {
	        if(!$(this).hasClass('fc-axis')){
	        	$(this).html('<table><tbody><tr class="poj_godzina"><td></td></tr></tbody></table>');            
	        }		
		});
	}
}

function wstaw_dane_sadu(){
	$('.wczytaj_dane_slownik_sad').click(function(){
		var tabela = $(this).data('tabela');
		var element_id = $(this).data('element_id');
		
		var formData = new FormData();
			formData.append('tabela', tabela);
			formData.append('element_id', element_id);
			formData.append('akcja', 'wczytaj_dane_sadu');
			
		var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);	
		odpowiedz = $.parseJSON(odpowiedz); 
		
		$('.sad_typ').attr('value',odpowiedz['typ_id']);
		$('.sad_typ').text(odpowiedz['typ_nazwa']);
		$('.lista_typow_sadow .element_grupa_opcja').removeClass('aktywna');
		$('#sad_typ_'+odpowiedz['typ_id']).addClass('aktywna');
		
		$('.sad_nazwa').val(odpowiedz['sad_nazwa']);
		$('.sad_ulica').val(odpowiedz['sad_ulica']);
		$('.sad_miasto').val(odpowiedz['miasto_nazwa']);
		$('.sad_kod_pocztowy').val(odpowiedz['sad_kod_pocztowy']);
		
		$('.sad_wojewodztwo').attr('value',odpowiedz['wojewodztwo_id']);
		$('.sad_wojewodztwo').text(odpowiedz['wojewodztwo_nazwa']);
		$('.lista_wojewodztw .element_grupa_opcja').removeClass('aktywna');
		$('#wojewodztwo_'+odpowiedz['wojewodztwo_id']).addClass('aktywna');
		
		$('.wyszukaj_like').popover('hide');
		
	});
}

function wyszukaj_klienta(){
	$('.wyszukaj_klienta').click(function(){
		formData = null;
		odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/widoki/ajax_widok_wyszukaj_dane_pce', formData);
		popup_wczytaj_tresc('Wyszukaj Dane w systemie PCE', odpowiedz);	
				
		aktualizujWartoscInputTextarea();
		
		$('.szukaj_danych_w_bazie').click(function(){
			var formData = new FormData();
				formData.append('akcja', 'klient_pce');
				formData.append('imie', $('.klient_imie_pop').val());
				formData.append('nazwisko', $('.klient_nazwisko_pop').val());			
				formData.append('nr_sprawy', $('.klient_nr_sprawy_pop').val());	
		
				
			var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);		
			
			if(odpowiedz == 'brak_danych'){
				powiadomienie('blad', 'Uzupełnij przynajmniej jedno pole!!!', '');
				return;
			}
			
			document.getElementById('wyniki_wyszukiwania').innerHTML = odpowiedz ;
			
			if(!$('.tabela_lista_klientow').hasClass('dataTable')){
				$('.tabela_lista_klientow').DataTable({
			        "language": {
			            "url": adres_hosta+'/app/jezyki/dataTable_pl.json'
			        },
			        "aoColumns": [
				                      null,
				                      null,
				                      null,
				                      null,
				                      { "orderSequence": [] }
				                  ],
			        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]],
			        "order": [[ 1, "asc" ]]
			                  
			    });
				$('[data-toggle="tooltip"]').tooltip();
				
				$('.dodaj_klienta_do_wokandy').click(function(){
					$('#myModal').modal('hide');
					
					$('.klient_imie').val($(this).parent().parent().data('imie_klienta'));
					$('.klient_nazwisko').val($(this).parent().parent().data('nazwisko_klienta'));
					$('.klient_nr_sprawy').val($(this).parent().parent().data('numer_sprawy'));
					$('.prawnik_prowadzacy_sprawe').val($(this).parent().parent().data('prawnik_prowadzacy'));
					$('.druga_strona').val($(this).parent().parent().data('druga_strona'));
					$('.pełnomocnik_glowny').val($(this).parent().parent().data('pelnomocnik_glowny'));
					$('.pelnomocnik_substytucyjny_kairp').val($(this).parent().parent().data('pelnomocnik_substytucyjny'));
					$('.wps').val($(this).parent().parent().data('wps'));

					przeladujFunkcjeWidoku();
					
				});
			};
			
		});
		
	});

}

function wczytaj_dane_substytut(){
	$('.wczytaj_dane_substytut').click(function(){
		var tabela = $(this).data('tabela');
		var element_id = $(this).data('element_id');
		
		var formData = new FormData();
			formData.append('tabela', tabela);
			formData.append('element_id', element_id);
			formData.append('akcja', 'wczytaj_dane_substytut');
			
		var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);	
		odpowiedz = $.parseJSON(odpowiedz); 
				
		$('.imie_susbstytuta').val(odpowiedz['imie']);
		$('.nazwisko_susbstytuta').val(odpowiedz['nazwisko']);
		$('.koszt_substytuta').val(odpowiedz['koszt_stawiennictwa']);
		
		$('.forma_platnosci_substytut_nazwa').attr('value',odpowiedz['forma_platnosci_id']);
		$('.forma_platnosci_substytut_nazwa').text(odpowiedz['forma_platnosci_nazwa']);
		$('.forma_platnosci_substytut .element_grupa_opcja').removeClass('aktywna');
		$('#substytut_forma_platnosci_'+odpowiedz['forma_platnosci_id']).addClass('aktywna');
		
		$('.wyszukaj_like').popover('hide');
		
	});
}

function wokanda_usun_przywroc(zakladka, zakldka_tytul){
	$('.wokanda_usun_przycisk').click(function(){
		$('.wokanda_usun').click(function(){
			
			main_dane = {
					'_id' : $('.element_szczegoly').data('element_id')
					,'_zakladka' : zakladka
					,'_zakladka_tytul' : zakldka_tytul
			};
			
			wokanda.wokandaUsun(main_dane);
		});
	});
	$('.wokanda_przywroc_przycisk').click(function(){
		$('.wokanda_przywroc').click(function(){
			
			main_dane = {
					'_id' : $('.element_szczegoly').data('element_id')
					,'_zakladka' : zakladka
					,'_zakladka_tytul' : zakldka_tytul
			};
			
			wokanda.wokandaPrzywroc(main_dane);
		});
	});
}
