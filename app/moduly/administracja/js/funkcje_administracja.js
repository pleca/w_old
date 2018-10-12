var main_dane = null;

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
				
		
		
		aktywujDataTable('tabela_lista_uzytkownikow',0,'asc');
			
		$('.lista_uzytkownikow_lista').off('click','.uzytkownik_edytuj');
		$('.lista_uzytkownikow_lista').on('click','.uzytkownik_edytuj',function(){
			var id = $(this).parent().parent().data('element_id');
			var tab = 'aktywni';
			if($('#usunieci').hasClass('active')){
				tab = 'usunieci';
			}
			main.mainEdytujWidokElement(id, tab, 'uzytkownik_edytuj');
		});
		
		$('#zawartosc_strona_p').off('click','.uzytkownik_aktualizuj');
		$('#zawartosc_strona_p').on('click','.uzytkownik_aktualizuj',function(){
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
		
		$('.uzytkownik_szczegoly').off('click','.uzytkownik_usun');
		$('.uzytkownik_szczegoly').on('click','.uzytkownik_usun',function(){
			 var id = $('.uzytkownik_szczegoly').data('element_id');									
			 main.mainUsunPrzywrocElement(id,'uzytkownik','usun');
		});
		
		

		$('.uzytkownik_szczegoly').off('click','.uzytkownik_przywroc');
		$('.uzytkownik_szczegoly').on('click','.uzytkownik_przywroc',function(){
			var id = $('.uzytkownik_szczegoly').data('element_id');														
			main.mainUsunPrzywrocElement(id,'uzytkownik','przywroc');
		});
		
		$('.uzytkownik_grupa_opcja').click(function(){
			main_dane = {
					'_pole_wartosc' : $(this).data('element_id')
					,'_pole_nazwa' : 'uzytkownik_grupy_id'
					,'_nazwa_elementu' : $(this).data('wartosc')
			};
						
			osoba.uzytkownikAktualizujWartosc(main_dane);
			
			$('.uzytkownik_grupy_nazwa').text($(this).data('wartosc'));

		});
				
		/*rozsuwanie uprawnien na zakladce uprawnienia*/
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
		
		$('.uzytkownik_szczegoly').off('click','.uzytkownik_wymus_wylogowanie_przycisk');
		$('.uzytkownik_szczegoly').on('click','.uzytkownik_wymus_wylogowanie_przycisk',function(){
			osoba.uzytkownikWymusWylogowanie();
			$('.uzytkownik_wymus_wylogowanie').popover('hide');
		});

		
	}	

