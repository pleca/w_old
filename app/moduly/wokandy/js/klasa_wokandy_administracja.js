if(!isset(sad)){
    var sad = new Sad();
}

if(!isset(substytut)){
	var substytut = new Substytut();
}	

function Sad(){
	this.sadDodaj = function(_dane, _popUp, _klasaRodzic){
		this.sprawdzPola(_dane, _klasaRodzic);
		
		
		if($('.'+_klasaRodzic+' .brak_wartosci').size() === 0){
				
				var formData = new FormData();
					formData.append('akcja', 'sad_dodaj');
					formData.append('nazwa', _dane['_nazwa']);
					formData.append('ulica', _dane['_ulica']);
					formData.append('miasto', _dane['_miasto']);
					formData.append('kod_pocztowy', _dane['_kod_pocztowy']);
					formData.append('wojewodztwo_id', _dane['_wojewodztwo_id']);
					formData.append('typ_id', _dane['_typ_id']);

							
				var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_dodaj', formData);
					
				odpowiedz = $.parseJSON(odpowiedz); 
							
				var powidomienie_rodzaj;
				
				if(odpowiedz[0] === 1){
                    powidomienie_rodzaj = 'sukces';

					if(!_popUp){
                        setCookie('zakladka', 'lista_sadow');
                        setCookie('zakladka_tytul', 'Lista sądów');

                        var widok_url = adres_hosta+'/app/moduly/wokandy/zakladki/zakladka_lista_sadow';
                        przeladujWidokZadanieAjax(widok_url, 'lista_sadow', 'zawartosc_strona_p', '', 'Lista sądów');
                        odswiez_sesje();

					}else{
                        $('.dane_sadu .form-group').removeClass('brak_wartosci has-error has-feedback');
                        $('.dane_sadu .lista_wojewodztw button').removeClass('brak_wartosci has-error has-feedback');
                        $('.dane_sadu .lista_typow_sadow button').removeClass('brak_wartosci has-error has-feedback');

						$('#slownik_sad_id').attr('value',odpowiedz[2]);
						$('.wokanda_szczegoly_sad_dane .sad_nazwa').val(_dane['_nazwa']);
                        $('.wokanda_szczegoly_sad_dane .sad_nazwa').attr('value',_dane['_nazwa']);

                        $('.wokanda_szczegoly_sad_dane .sad_ulica').val(_dane['_ulica']);
                        $('.wokanda_szczegoly_sad_dane .sad_ulica').attr('value',_dane['_ulica']);

                        $('.wokanda_szczegoly_sad_dane .sad_miasto').val(_dane['_miasto']);
                        $('.wokanda_szczegoly_sad_dane .sad_miasto').attr('value',_dane['_miasto']);

                        $('.wokanda_szczegoly_sad_dane .sad_kod_pocztowy').val(_dane['_kod_pocztowy']);
                        $('.wokanda_szczegoly_sad_dane .sad_kod_pocztowy').attr('value',_dane['_kod_pocztowy']);

                        $('.wokanda_szczegoly_sad_dane .sad_wojewodztwo').attr('value',_dane['_wojewodztwo_id']);
                        $('.wokanda_szczegoly_sad_dane .sad_wojewodztwo').text(_dane['_wojewodztwo_nazwa']);

                        $('.wokanda_szczegoly_sad_dane .sad_typ').attr('value',_dane['_typ_id']);
                        $('.wokanda_szczegoly_sad_dane .sad_typ').text(_dane['_typ_nazwa']);

                        $('#popUp2').modal('hide');

					}

					
				}
				
				if(odpowiedz[0] === 0){
					powidomienie_rodzaj = 'blad';
				}
				
				powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
				
			
		}
		
	},

	this.sadAktualizuj = function(_dane){	
		var nazwa_tmp = $('.sad_nazwa').data('wartosc_domyslna');
		var ulica_tmp = $('.sad_ulica').data('wartosc_domyslna');
		var miasto_tmp = $('.sad_miasto').data('wartosc_domyslna');
		var kod_pocztowy_tmp = $('.sad_kod_pocztowy').data('wartosc_domyslna');
		var wojewodztwo_id_tmp = $('.sad_wojewodztwo').data('wartosc_domyslna');
		var typ_id_tmp = $('.sad_typ').data('wartosc_domyslna');
		
		var nazwa = (nazwa_tmp == _dane['_nazwa']) ? '' : _dane['_nazwa'] ;
		var ulica = (ulica_tmp == _dane['_ulica']) ? '' : _dane['_ulica'] ;
		var miasto = (miasto_tmp == _dane['_miasto']) ? miasto_tmp : _dane['_miasto'] ;
		var kod_pocztowy = (kod_pocztowy_tmp == _dane['_kod_pocztowy']) ? '' : _dane['_kod_pocztowy'] ;
		var wojewodztwo_id = (wojewodztwo_id_tmp == _dane['_wojewodztwo_id']) ? wojewodztwo_id_tmp : _dane['_wojewodztwo_id'] ;
		var typ_id = (typ_id_tmp == _dane['_typ_id']) ? typ_id_tmp : _dane['_typ_id'] ;
		
		if(nazwa == '' && ulica == '' && miasto == '' && kod_pocztowy == '' && wojewodztwo_id == '' ){
			powiadomienie('blad', 'Nie wykryto zmian!!!', '');
			return;
		}
		
		var formData = new FormData();
			formData.append('nazwa', nazwa);
			formData.append('id', $('.element_szczegoly').data('element_id'));
			formData.append('ulica', ulica);
			formData.append('miasto', miasto);
			formData.append('kod_pocztowy', kod_pocztowy);
			formData.append('wojewodztwo_id', wojewodztwo_id);
			formData.append('akcja', 'aktualizuj_sad');
			formData.append('typ_id', typ_id);
					
			main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
		
			main.mainEdytujWidokElement($('.element_szczegoly').data('element_id'), $('.element_szczegoly').data('widok'), 'sad_edytuj');
		
	},
		
	this.sprawdzPola = function(_dane, _rodzic){
		$('.'+_rodzic+' .form-group').removeClass('brak_wartosci has-error has-feedback');
		$('.'+_rodzic+' .lista_wojewodztw button').removeClass('brak_wartosci has-error has-feedback');
        $('.'+_rodzic+' .lista_typow_sadow button').removeClass('brak_wartosci has-error has-feedback');

		$.each(_dane, function(element, wartosc){			
			if(wartosc == ''){
				$('.'+_rodzic+' .sad'+element).parent().addClass('brak_wartosci has-error has-feedback');
				$('.'+_rodzic+' .sad'+element).next().addClass('glyphicon-remove');
			}		
		});
		
		if(_dane['_wojewodztwo_id'] == ''){
			$('.'+_rodzic+' .lista_wojewodztw button').addClass('brak_wartosci has-error has-feedback');
		}
		
		if(_dane['_typ_id'] == ''){
			$('.'+_rodzic+' .lista_typow_sadow button').addClass('brak_wartosci has-error has-feedback');
		}
		
		if($('.brak_wartosci').size() !== 0){
			powiadomienie('blad', 'Uzupełnij wszystkie pola!!!', '');
		}
	}
}

function Substytut(){
	this.substytutDodaj = function(_dane){
		this.sprawdzPola(_dane);
		
		if($('.brak_wartosci').size() === 0){
			
			var formData = new FormData();
				formData.append('akcja', 'substytut_dodaj');
				formData.append('nazwisko', _dane['_nazwisko']);
				formData.append('imie', _dane['_imie']);
				formData.append('slownik_substytut_uprawnienia_id', _dane['_uprawnienia']);
				formData.append('ulica', _dane['_ulica']);
				formData.append('miasto', _dane['_miasto']);
				formData.append('wojewodztwo_id', _dane['_wojewodztwo_id']);
				formData.append('kod_pocztowy', _dane['_kod_pocztowy']);
				formData.append('email', _dane['_email']);
				formData.append('nr_telefonu', _dane['_telefon']);
				formData.append('koszt_stawiennictwa_domyslny', _dane['_koszt_stawiennictwa_domyslny']);
				formData.append('forma_platnosci_id_domyslna', _dane['_forma_platnosci_id_domyslna']);
				formData.append('email2', $('.email2_substytut').val());
				formData.append('opis', _dane['_opis']);
				formData.append('czy_votum', _dane['_czy_votum']);
				
						
			var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_dodaj', formData);
							
			odpowiedz = $.parseJSON(odpowiedz); 
						
			var powidomienie_rodzaj;
			
			if(odpowiedz[0] === 1){
				powidomienie_rodzaj = 'sukces';
				
				var widok_url = adres_hosta+'/app/moduly/wokandy/zakladki/zakladka_lista_substytutow'; 
				przeladujWidokZadanieAjax(widok_url, 'lista_substytutow', 'zawartosc_strona_p', '', 'Lista Substytutów');
				odswiez_sesje();

			}
			
			if(odpowiedz[0] === 0){
				powidomienie_rodzaj = 'blad';
			}
			
			powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
			
		
		}
	},

	this.substytutAktualizuj = function(_dane){
		this.sprawdzPola(_dane);
		
		if($('.brak_wartosci').size() === 0){
			var formData = new FormData();
				formData.append('akcja', 'aktualizuj_substytuta');
				formData.append('id', _dane['_id']);
				formData.append('nazwisko', _dane['_nazwisko']);
				formData.append('imie', _dane['_imie']);
				formData.append('slownik_substytut_uprawnienia_id', _dane['_uprawnienia']);
				formData.append('ulica', _dane['_ulica']);
				formData.append('miasto', _dane['_miasto']);
				formData.append('wojewodztwo_id', _dane['_wojewodztwo_id']);
				formData.append('kod_pocztowy', _dane['_kod_pocztowy']);
				formData.append('email', _dane['_email']);
				formData.append('nr_telefonu', _dane['_telefon']);
				formData.append('koszt_stawiennictwa_domyslny', _dane['_koszt_stawiennictwa_domyslny']);
				formData.append('forma_platnosci_id_domyslna', _dane['_forma_platnosci_id_domyslna']);
				formData.append('email2', $('.email2_substytut').val());
				formData.append('opis', _dane['_opis']);
				formData.append('czy_votum', _dane['_czy_votum']);
							
			main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
			
			main.mainEdytujWidokElement($('.element_szczegoly').data('element_id'), $('.element_szczegoly').data('widok'), 'substytut_edytuj');
		}
		
	},
	
	this.sprawdzPola = function(_dane){
		$('.brak_wartosci').removeClass('brak_wartosci');

		$.each(_dane, function(element, wartosc){			
			if(wartosc == ''){
				$('.substytut'+element).addClass('brak_wartosci');
			}		
		});
		
		if(_dane['_wojewodztwo_id'] == ''){
			$('.wojewodztwo_id').addClass('brak_wartosci');
		}
		
		if($('.brak_wartosci').size() !== 0){
			powiadomienie('blad', 'Uzupełnij wszystkie pola!!!', '');
		}
	}
}














