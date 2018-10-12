if(!isset(wokanda)){
		var wokanda = new Wokanda();
}

function Wokanda(){
	this.wokandaDodaj = function(_dane){
		var formData = new FormData();
			formData.append('data', _dane['_data']);
			formData.append('czas', _dane['_czas']);
			
		var odpowiedz = zadanieAjax('app/moduly/wokandy/zakladki/zakladka_dodaj_wokande', formData);		
		document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;	
		przeladujFunkcjeWidoku();
		
		odswiez_sesje();								
	};

    this.wokandaDatePicker = function(){
        przeladujDatePicker();
    };
		this.wokandaDatePickerFiltruj = function(){
			przeladujDatePickerFiltruj();
		};


	this.wokandyLista = function(_widok){
		var formData = new FormData();
			formData.append('widok', _widok);

		var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wokandy_lista', formData);	
		var array = $.parseJSON(odpowiedz);
		if(array[0] == ''){
			return;
		}
		
		return array; 
	};
		
	this.wokandaAktualizujCzas = function(_dane){	
		var formData = new FormData();
			formData.append('akcja', 'aktualizuj_czas');
			formData.append('data', _dane['_data']);
			formData.append('czas_start', _dane['_czas_start']);
			formData.append('czas_stop', _dane['_czas_stop']);
			formData.append('id', _dane['_id']);
		
			main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
			
	};
	
	this.wokandaZapisz = function(_dane, _kalendarz, _otworz_okno_edycji){

		var formData = new FormData();
			formData.append('akcja', 'wokanda_zapisz');
			formData.append('dane', JSON.stringify(_dane));
        var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);

        odpowiedz = $.parseJSON(odpowiedz);
        var powidomienie_rodzaj = 'blad';

        if(odpowiedz[0] === 1){
            powidomienie_rodzaj = 'sukces';
        }

        if(odpowiedz[0] === 2){
            powidomienie_rodzaj = 'uwaga';
        }

        powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
        odswiez_sesje();

        if(odpowiedz[0] != 0){
            if($('#kalendarz').hasClass('aktywny')){
                main.mainEdytujWidokElement('', '', 'kalendarz');
            }

            if($('#dodaj_wokande').hasClass('aktywny')){
                main.mainEdytujWidokElement('', '', 'dodaj_wokande');
            }
        }

        if(_otworz_okno_edycji){
            wokanda.wokandaEdytujWidok(odpowiedz[2], '', 'wokanda_szczegoly');
		}



	};
	
	this.wokandaFiltruj = function(_dane){
				
		var formData = new FormData();
			formData.append('akcja', _dane['akcja']);
			formData.append('dane', JSON.stringify(_dane));
						
		var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);
		
		document.getElementById('filtry_wyniki_wokanda').innerHTML = odpowiedz ;		
		aktywujDataTable('tabela_lista_wokand_filtruj',3,'asc', 15);

			//$('.tabela_lista_wokand_filtruj tbody tr').append('<td class="col-md-1"><i class="fa ikona_zaznacz_w zaznacz_wynik fa-square-o" aria-hidden="true"></i></td>');
			//$('.tabela_lista_wokand_filtruj tbody tr .col-md-3').removeClass('col-md-3').addClass('col-md-2');
			
			//$('.tabela_lista_wokand_filtruj thead tr').append('<th class="col-md-1"><i class="fa ikona_zaznacz_w zaznacz_wszystkie_wyniki fa-square-o" aria-hidden="true"></i></th>');
			//$('.tabela_lista_wokand_filtruj thead tr .col-md-3').removeClass('col-md-3').addClass('col-md-2');
			$('.masowe_dzialania .dropdown-menu').append('<li class="dropdown-menu_opcja element_grupa_opcja" data-element_id="faktura_oplacona" data-wartosc="Faktura opłacona">Faktura opłacona</li>');
			$('.masowe_dzialania .dropdown-menu').append('<li class="dropdown-menu_opcja element_grupa_opcja" data-element_id="generuj_raport_dla_finansow" data-wartosc="Generuj raport dla finansów">Generuj raport dla finansów </li>');
			$('.masowe_dzialania .dropdown-menu').append('<li class="dropdown-menu_opcja element_grupa_opcja" data-element_id="generuj_raport" data-wartosc="Generuj raport">Generuj Raport</li>');
			zaznacz_odznacz_box_w();
			$('.masowe_dzialania').show();
			przelacz_element_dropdown();
				
		$('[data-toggle="popover"]').popover({ html : true });
		$('[data-toggle="tooltip"]').tooltip();

	};

	this.wokandaSprawaPowiazanaDodajUsun = function(_dane){

		var formData = new FormData();
			formData.append('akcja', 'wokanda_sprawa_powiazana_dodaj_usun');
			formData.append('zadanie', _dane['zadanie']);
			formData.append('sprawa_powiazana_id', _dane['sprawa_powiazana_id']);
			formData.append('wokanda_id', $('.widok_edycja_wokandy').children('.element_szczegoly').data('element_id'));
		
		if(_dane['sprawa_powiazana_id'] == '0'){
			formData.append('sprawa_pce_numer', _dane['numer_sprawy']);
			formData.append('klient_imie', _dane['imie_klienta']);
			formData.append('klient_nazwisko', _dane['nazwisko_klienta']);
			formData.append('sprawa_prawnik', _dane['prawnik_prowadzacy']);
			formData.append('sprawa_druga_strona', _dane['druga_strona']);
			formData.append('sprawa_wps', _dane['wps']);
			//formData.append('sprawa_wpz', _dane['wpz']);
			formData.append('sprawa_pelnomocnik_glowny', _dane['pelnomocnik_glowny']);
			formData.append('sprawa_pelnomocnik_kairp', _dane['pelnomocnik_substytucyjny']);
			formData.append('sprawa_pce_id', _dane['id']);
		}
									
		var sprawa_powiazana_id_tmp = main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
				
		if(_dane['sprawa_powiazana_id'] == '0'){
			return sprawa_powiazana_id_tmp;
		}
		
	};

    this.wokandaDuplikujWokande = function(_dane){
        var formData = new FormData();
        formData.append('akcja', 'wokanda_duplikuj_wokande');
        formData.append('wokanda_id', _dane['wokanda_id']);

        var odpowiedz = main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_duplikuj', formData);
            wokanda.wokandaEdytujWidok(odpowiedz, '', 'wokanda_szczegoly');

        powiadomienie('info', 'Wokanda została zduplikowana!', '');
        odswiez_sesje();
    };

	this.wokandaWyslijDaneDoPCE = function(_dane){
		var formData = new FormData();
			formData.append('akcja', 'wokanda_wyslij_dane_do_PCE');
			formData.append('wokanda_id', _dane['wokanda_id']);

			var odpowiedz = main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
			if(odpowiedz == '1'){
				wokanda.wokandaEdytujWidok(_dane['wokanda_id'], '', 'wokanda_szczegoly');
			}
	};

  this.generujRaportWidok = function(data, name){
    var formData = data;
    formData.append('popUp', true);
    var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/widoki/ajax_widok_generuj_raport', formData);
    wyswietlPopUp(name, odpowiedz, 'modal-lg',2);

    przeladujFunkcjeWidoku();
    odswiez_sesje();
  };

	this.wokandaEdytujWidok = function(_id, _tab, widok){

        var formData = new FormData();
            formData.append('id', _id);
            formData.append('tab', _tab);
            var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/widoki/ajax_widok_'+widok, formData);
            wyswietlPopUp('Edycja wokandy', odpowiedz, 'modal-lg',1);

            przeladujFunkcjeWidoku();
            odswiez_sesje();
    };

    this.dodajSadPopUpWidok = function(){
        var formData = new FormData();
            formData.append('popUp', true);
        var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/widoki/ajax_widok_dodaj_sad', formData);
        wyswietlPopUp('Dodaj sąd', odpowiedz, 'modal-lg',2);

        przeladujFunkcjeWidoku();
        odswiez_sesje();
    };

	this.wygenerujWiadomoscDoSubstytuta = function(_button){
        var formData = new FormData();
            formData.append('substytut_id', _button.data('substytut_id'));

        var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/widoki/ajax_widok_wiadomosc_do_substytuta', formData);
        wyswietlPopUp('Wiadomość do substytuta', odpowiedz, 'modal-lg',1);

		var rows = document.getElementsByClassName('removeRow');
				
					for(var i=0;i<rows.length;i++){
					rows[i].addEventListener("click", function(){this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)});
				}
		
        przeladujFunkcjeWidoku();
        odswiez_sesje();
    };
	
	this.removeRow = function(_button){
		
	}

	this.wyslijWiadomoscOTerminachDoSubstytuta = function(_button){
		var elem = document.getElementById('edit_table');
		var elements = document.getElementsByClassName('remove_col');
		while(elements.length > 0){
			elements[0].parentNode.removeChild(elements[0]);
		}
		elem.parentNode.removeChild(elem);
		
	    var substytut_email = $('#popUpTresc1').find('.substytut_email').val();
	    if(substytut_email === ''){
            powiadomienie('blad', 'Wprowadź adres email substytuta!!!', '');
            return;
        }

        var dw_email = $('#popUpTresc1').find('.dw_email').val();
        var formData = new FormData();
            formData.append('substytut_id', _button.data('substytut_id'));
            formData.append('substytut_email', substytut_email);
        	if(dw_email !== ''){
                formData.append('dw_email', dw_email);
        	}
            formData.append('akcja', 'wokanda_wyslij_wiadomosc_do_substytuta');
            formData.append('tresc', $('.tabela_lista_substytutow_do_pow').html());

        var odpowiedz = $.parseJSON(zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/akcje/ajax_aktualizuj', formData));
        powiadomienie(odpowiedz[0], odpowiedz[1], '');

        przeladujFunkcjeWidoku();
        odswiez_sesje();

        if(odpowiedz[0] === 'sukces'){
            $('#popUp1').modal('hide');
            //$('#substytut_'+_button.data('substytut_id')).remove();
        }

    }

}



























