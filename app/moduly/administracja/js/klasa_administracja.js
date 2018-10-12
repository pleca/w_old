

if(!isset(osoba)){
	var osoba = new Uzytkownik();
}	

wyswietl_panel_body();

	if($('#dodaj_uzytkownika').hasClass('aktywny')){		
		

		$('.uzytkownik_dodaj').click(function(){
			main_dane = {
					'_imie' : $('.uzytkownik_imie').val()
					,'_nazwisko' : $('.uzytkownik_nazwisko').val()
					,'_login' : $('.uzytkownik_login').val()
					,'_email' : $('.uzytkownik_email').val()
					,'_telefon' : $('.uzytkownik_telefon').val()
					,'_haslo' : $('.uzytkownik_haslo').val()
					,'_haslo_powtorz' : $('.uzytkownik_haslo_powtorz').val()
			};
						
			osoba.uzytkownikDodaj(main_dane);

		});
		

		$('.uzytkownik_nazwisko').blur(function(){
			if($('.uzytkownik_imie').val() !== '' && $('.uzytkownik_nazwisko').val()){
				main_dane = {
					'_imie' : $('.uzytkownik_imie').val()
					,'_nazwisko' : $('.uzytkownik_nazwisko').val()
				};
				var login = osoba.generujLogin(main_dane);				
				$('.uzytkownik_login').val(login);
				
				var email = osoba.generujEmail(main_dane);
				$('.uzytkownik_email').val(email); 
			}
		});
				
	}
	
	if($('#lista_uzytkownikow').hasClass('aktywny')){
		
		if(!$('.tabela_lista_uzytkownikow').hasClass('dataTable')){
			$('.tabela_lista_uzytkownikow').DataTable({
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
		        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]]
		                  
		    });
			$('[data-toggle="tooltip"]').tooltip();
			//$('.ukryj').css({'display':'none'});
		}
		
		if(!$('.tabela_historia_uzytkownika').hasClass('dataTable')){
			$('.tabela_historia_uzytkownika').DataTable({
		        "language": {
		            "url": adres_hosta+'/app/jezyki/dataTable_pl.json'
		        },
		        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Wszystkie"]],
		        "order": [[ 0, "desc" ]]
		                  
		    });
			$('[data-toggle="tooltip"]').tooltip();
			//$('.ukryj').css({'display':'none'});
		}
		
		$('.uzytkownik_edytuj').click(function(){
			var id = $(this).parent().parent().data('element_id');
			var tab = 'aktywni';
			if($('#usunieci').hasClass('active')){
				tab = 'usunieci';
			}
			osoba.uzytkownikEdytuj(id, tab);
		});
		

		$('.uzytkownik_aktualizuj').click(function(){
			main_dane = {
					'_imie' : $('.uzytkownik_imie').val()
					,'_nazwisko' : $('.uzytkownik_nazwisko').val()
					,'_email' : $('.uzytkownik_email').val()
					,'_telefon' : $('.uzytkownik_telefon').val()
					
			};
			
			if($('.uzytkownik_haslo').val() !== ''){
				main_dane['_haslo'] = $('.uzytkownik_haslo').val();
				main_dane['_haslo_powtorz'] = $('.uzytkownik_haslo_powtorz').val();
			}
						
			osoba.uzytkownikAktualizuj(main_dane);

		});
		
		
		$('.uzytkownik_usun_przycisk').click(function(){
			$('.uzytkownik_usun').click(function(){
				 var id = $('.uzytkownik_szczegoly').data('element_id');					
										
				osoba.uzytkownikUsun(id);
			});
		});	
		

		$('.uzytkownik_przywroc_przycisk').click(function(){
			var klikniety = $(this);
			$('.uzytkownik_przywroc').click(function(){
				 var id = klikniety.parent().parent().data('element_id')					
										
				osoba.uzytkownikPrzywroc(id);
			});
		});
		
		$('.uzytkownik_grupa_opcja').click(function(){
			main_dane = {
					'_pole_wartosc' : $(this).data('element_id')
					,'_pole_nazwa' : 'uzytkownik_grupy_id'
					,'_nazwa_elementu' : $(this).data('wartosc')
			};
						
			osoba.uzytkownikAktualizujWartosc(main_dane);

		});
				
		$('.panel_heading_tytul').click(function(){
			$(this).parent().next().slideToggle();
		});
		
		$('.aktualizuj_uprawnienie').click(function(){
			
			var element_id = $(this).data('element_id');
			var uprawnienie_akcja;
			var uprawnienie_rodzaj;
			
			if($(this).hasClass('fa-check-square-o')){
				$(this).removeClass('fa-check-square-o').addClass('fa-square-o');
				uprawnienie_akcja = 'usun';
				
				powiadomienie_strona('<p><b>UWAGA!!!</b> Czy chcesz wymusic wylogowanie użytkownika?</p><button type="button" class="uzytkownik_wymus_wylogowanie btn btn-danger">TAK</button><div class="clear_b"></div>', 'danger');
				
				$('.uzytkownik_wymus_wylogowanie').click(function(){
					osoba.uzytkownikWymusWylogowanie();
				});				
				
			}else{
				$(this).removeClass('fa-square-o').addClass('fa-check-square-o');
				uprawnienie_akcja = 'dodaj';
			}
			
			if($(this).hasClass('poj_modul')){
				uprawnienie_rodzaj = '_moduly'; 
			}
			
			if($(this).hasClass('poj_strona')){
				uprawnienie_rodzaj = '_strony'; 
			}
			
			if($(this).hasClass('poj_zakladka')){
				uprawnienie_rodzaj = '_zakladki'; 
			}
			
			if($(this).hasClass('poj_uprawnienie')){
				uprawnienie_rodzaj = ''; 
			}
			
			main_dane = {
					'_element_id' : element_id
					,'_uprawnienie_akcja' : uprawnienie_akcja
					,'_uprawnienie_rodzaj' : uprawnienie_rodzaj
			};
						
			osoba.uzytkownikAktualizujUprawnienie(main_dane);
			
		});
		
		$('.uzytkownik_wymus_wylogowanie').click(function(){	
			$('.uzytkownik_wymus_wylogowanie_przycisk').click(function(){
				osoba.uzytkownikWymusWylogowanie();
				$('.uzytkownik_wymus_wylogowanie').popover('hide');
			});
		});
		
	}	

	function Uzytkownik(){
		this.uzytkownikDodaj = function(_dane){		
			
			this.sprawdzPola(_dane);
			
			if($('.brak_wartosci').size() === 0){
				
				var formData = new FormData();
					formData.append('akcja', 'uzytkownik_dodaj');
					formData.append('login', _dane['_login']);
					formData.append('haslo', _dane['_haslo']);
					formData.append('imie', _dane['_imie']);
					formData.append('nazwisko', _dane['_nazwisko']);
					formData.append('email', _dane['_email']);
					formData.append('telefon', _dane['_telefon']);
							
				var odpowiedz = zadanieAjax('app/moduly/administracja/ajax/akcje/ajax_dodaj', formData);
					
				odpowiedz = $.parseJSON(odpowiedz); 
							
				var powidomienie_rodzaj;
				
				if(odpowiedz[0] === 1){
					powidomienie_rodzaj = 'sukces';
					
					setCookie('zakladka', 'lista_uzytkownikow');
					setCookie('zakladka_tytul', 'Lista użytkownikw');
					
					var widok_url = adres_hosta+'/app/moduly/administracja/zakladki/zakladka_lista_uzytkownikow'; 
					przeladujWidokZadanieAjax(widok_url, 'lista_uzytkownikow', 'zawartosc_strona_p', '', 'Lista użytkownikw');
					odswiez_sesje();
					
					//this.uzytkownikEdytuj(odpowiedz[2]);
				}
				
				if(odpowiedz[0] === 0){
					powidomienie_rodzaj = 'blad';
				}
				
				powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
				
			}
							
		},
		
		this.uzytkownikEdytuj = function(_id, _tab){
			var formData = new FormData();
				formData.append('id', _id);
				formData.append('tab', _tab);
				
			var odpowiedz = zadanieAjax('app/moduly/administracja/ajax/widoki/ajax_widok_uzytkownik_edytuj', formData);
			
			setCookie('zakladka', 'lista_uzytkownikow');
			setCookie('zakladka_tytul', 'Lista użytkownikw');
			
			$('.przycisk_border').removeClass('aktywny');
			$('#lista_uzytkownikow').addClass('aktywny');
			
			document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;
			
			przeladujFunkcjeWidoku();
			
			odswiez_sesje();
			
		},
		
		this.uzytkownikAktualizuj = function(_dane){
			this.sprawdzPola(_dane);
			
			if($('.brak_wartosci').size() === 0){	
				
				var _imie_wd = $('.uzytkownik_imie').data('wartosc_domyslna');
				var _nazwisko_wd = $('.uzytkownik_nazwisko').data('wartosc_domyslna');
				var _email_wd = $('.uzytkownik_email').data('wartosc_domyslna');
				var _telefon_wd = $('.uzytkownik_telefon').data('wartosc_domyslna');
				
				var _imie = (_dane['_imie'] == _imie_wd) ? '' : _dane['_imie'] ;
				var _nazwisko = (_dane['_nazwisko'] == _nazwisko_wd) ? '' : _dane['_nazwisko'] ;
				var _email = (_dane['_email'] == _email_wd) ? '' : _dane['_email'] ;
				var _telefon = (_dane['_telefon'] == _telefon_wd) ? '' : _dane['_telefon'] ;
				
				if(_imie == '' && _nazwisko == '' && _email == '' && _telefon == '' ){									
						powiadomienie('blad', 'Nie wykryto zmian!!!', '');
						return;													
				}
				
				var formData = new FormData();
					formData.append('akcja', 'uzytkownik_aktualizuj');
					formData.append('id', $('.uzytkownik_szczegoly').data('element_id'));	
					formData.append('imie', _imie);
					formData.append('nazwisko', _nazwisko);
					formData.append('email', _email);
					formData.append('telefon', _telefon);
					
					if(_dane['_haslo'] !== undefined){
						formData.append('haslo', _dane['_haslo']);
					}
							
					main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_aktualizuj', formData);				
				
				this.uzytkownikEdytuj($('.uzytkownik_szczegoly').data('element_id'), $('.uzytkownik_szczegoly').data('widok'));
				
			}
			
		},
		
		this.uzytkownikAktualizujWartosc = function(_dane){
						
			var formData = new FormData();
				formData.append('pole_wartosc', _dane['_pole_wartosc']);
				formData.append('pole_nazwa', _dane['_pole_nazwa']);
				formData.append('akcja', 'uzytkownik_aktualizuj_wartosc');
				formData.append('id', $('.uzytkownik_szczegoly').data('element_id'));
				formData.append('nazwa_elementu', _dane['_nazwa_elementu']);
				
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_aktualizuj', formData);
							
				$('.uzytkownik_grupy_nazwa').text(_dane['_nazwa_grupy']);
				$('.uzytkownik_grupa_opcja').removeClass('aktywna');
				$('#uzytkownik_grupa_'+_dane['_pole_wartosc']).addClass('aktywna');
			
		},
		
		this.uzytkownikAktualizujUprawnienie = function(_dane){		
			var formData = new FormData();
				formData.append('element_id', _dane['_element_id']);
				formData.append('uprawnienie_rodzaj', _dane['_uprawnienie_rodzaj']);
				formData.append('akcja', 'uzytkownik_'+_dane['_uprawnienie_akcja']+'_uprawnienie');
				formData.append('uzytkownik_id', $('.uzytkownik_szczegoly').data('element_id'));
				
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_'+_dane['_uprawnienie_akcja'], formData);
				
		},
		
		this.uzytkownikUsun = function(_id){
			var formData = new FormData();
				formData.append('akcja', 'uzytkownik_usun');
				formData.append('id', _id);
				
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_usun', formData);
				
				var odpowiedz = zadanieAjax('app/moduly/administracja/zakladki/zakladka_lista_uzytkownikow', formData);
							
				document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;
				
				przeladujFunkcjeWidoku();
		},
		
		this.uzytkownikPrzywroc = function(_id){
			var formData = new FormData();
				formData.append('akcja', 'uzytkownik_przywroc');
				formData.append('id', _id);
				
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_przywroc', formData);
				
				var odpowiedz = zadanieAjax('app/moduly/administracja/zakladki/zakladka_lista_uzytkownikow', formData);
				
				setCookie('zakladka', 'lista_uzytkownikow');
				setCookie('zakladka_tytul', 'Lista użytkownikw');
				
				$('.przycisk_border').removeClass('aktywny');
				$('#lista_uzytkownikow').addClass('aktywny');
				
				document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;
				
				przeladujFunkcjeWidoku();
		},
		
		this.uzytkownikWymusWylogowanie = function(){
			var formData = new FormData();
				formData.append('akcja', 'uzytkownik_wyloguj');
				formData.append('id', $('.uzytkownik_szczegoly').data('element_id'));
			
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_aktualizuj', formData);
				
				$('.alert_na_stronie').slideUp(function(){
					$(this).remove();				
				});
				
				this.uzytkownikEdytuj($('.uzytkownik_szczegoly').data('element_id'), $('.uzytkownik_szczegoly').data('widok'));
		},
				
		this.poprawnoscHasla = function(_haslo){	
			var wartosc = _haslo;
			 
			var male_litery = /[a-z]/;
			var duze_litery = /[A-Z]/;
			var znaki_specjalne = /[\!\@\#\$\%\^\&\*\(\)\-\=\+\_\;\:\,\.\(/)\?\*]/;
			
			var t1 = '';
			var t2 = '';
			var t3 = '';
			var t4 = '';
			
			if (wartosc.length < 8){
				t1 = '<li>Minimalna długość 8 znaków</li>';
		    }
		    if (!male_litery.test(wartosc)){
		    	t2 = '<li>Minimum 1 mała litera</li>';
		    }
		    if (!duze_litery.test(wartosc)){
		    	t3 = '<li>Minimum 1 wielka litera</li>';
		    }
		    if (!znaki_specjalne.test(wartosc)){
		    	t4 = '<li>Minimum 1 znak specjalny ( ! @ # $ % ^ & * ( ) - = + _ ; : , . / ? * )</li>';
		    }
		    
		    return t1+t2+t3+t4;	     
		},
		
		this.sprawdzPola = function(_dane){
			$('.form-group').removeClass('brak_wartosci has-error has-feedback');

			$.each(_dane, function(element, wartosc){			
				if(wartosc == ''){
					$('.uzytkownik'+element).parent().addClass('brak_wartosci has-error has-feedback');
					$('.uzytkownik'+element).next().addClass('glyphicon-remove');
				}						
			});
			
			if($('.brak_wartosci').size() !== 0){
				powiadomienie('blad', 'Uzupełnij wszystkie pola!!!', '');
			}
			
			if(_dane['_email'] !== ''){
				if(!(/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/).test(_dane['_email'])){
					powiadomienie('blad', 'Wpisz poprawny adres email!!!', '');
					$('.pole_email').addClass('brak_wartosci has-error has-feedback');
					$('.pole_email span').addClass('glyphicon-remove');
				}
			}
			if(_dane['_haslo'] !== undefined){
				if(_dane['_haslo'] !== _dane['_haslo_powtorz']){
					powiadomienie('blad', 'Podane hasła są różne!!!', '');
					$('.pole_haslo').addClass('brak_wartosci has-error has-feedback');
					$('.pole_haslo span').addClass('glyphicon-remove');
				}else{
					if(_dane['_haslo'] !== ''){			
						var wynik = this.poprawnoscHasla(_dane['_haslo']);
							
						if(wynik !== ''){
							powiadomienie('blad', 'Hasło nie spełnia minimalnych wymagań!!!', '<ul class="margin_t_10 margin_b_0">'+wynik+'</ul>');  
							$('.pole_haslo').addClass('brak_wartosci has-error has-feedback');
							$('.pole_haslo span').addClass('glyphicon-remove');
						}				
					}
				}
			}
														
		},
		
		this.generujLogin = function(_dane){
			var _imie = _dane['_imie'];
			var _nazwisko = _dane['_nazwisko'];
			
			var _login = _imie.charAt(0)  + _nazwisko;
			_login = usun_polskie_znaki(_login);
			return _login.toLowerCase();
		},
		
		this.generujEmail = function(_dane){
			var _imie = _dane['_imie'];
			var _nazwisko = _dane['_nazwisko'];
			
			var _email = _imie +'.'+ _nazwisko;
			_email = usun_polskie_znaki(_email);
			return _email.toLowerCase();
		}
	}