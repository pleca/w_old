if(!isset(osoba)){
	var osoba = new Uzytkownik();
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

				}
				
				if(odpowiedz[0] === 0){
					powidomienie_rodzaj = 'blad';
				}
				
				powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
				
			}
							
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
				
				if(_imie == '' && _nazwisko == '' && _email == '' && _telefon == '' && _dane['_haslo'] == undefined){									
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
				
				main.mainEdytujWidokElement($('.uzytkownik_szczegoly').data('element_id'), $('.uzytkownik_szczegoly').data('widok'), 'uzytkownik_edytuj');
				
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
				
		this.uzytkownikWymusWylogowanie = function(){
			var formData = new FormData();
				formData.append('akcja', 'uzytkownik_wyloguj');
				formData.append('id', $('.uzytkownik_szczegoly').data('element_id'));
			
				main.mainWyslijZadanie('app/moduly/administracja/ajax/akcje/ajax_aktualizuj', formData);
				
				$('.alert_na_stronie').slideUp(function(){
					$(this).remove();				
				});
				
				main.mainEdytujWidokElement($('.uzytkownik_szczegoly').data('element_id'), $('.uzytkownik_szczegoly').data('widok'), 'uzytkownik_edytuj');
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