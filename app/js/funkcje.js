var adres_hosta = 'https://'+document.location.hostname;
var czas_sesji;
var aktywna_sesja;

if(!isset(main)){
	var main = new Main();
}	

if(!isset(main_dane)){
	var main_dane = null;
}else{
	main_dane = null;
}

$(window).load(function(){
    $("#preloader").delay(200).fadeOut();
});

$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});



$(document).ready(function(){

    $(this).on('hidden.bs.popover', function (e) {
        $(e.target).data("bs.popover").inState.click = false;
    });

    $(this).on('click', function (e) {
        //did not click a popover toggle or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });

    $('#popUp1').on('hidden.bs.modal', function (){
        document.getElementById('popUpTresc1').innerHTML = ' ';
        document.getElementById('popUpTytul1').innerHTML = ' ';
        document.getElementById('popUpImg1').innerHTML = ' ';
    });

    $('#popUp2').on('hidden.bs.modal', function () {
        document.getElementById('popUpTresc2').innerHTML = ' ';
        document.getElementById('popUpTytul2').innerHTML = ' ';
        document.getElementById('popUpImg2').innerHTML = ' ';

        if($('#popUp1').hasClass('in')){
            $('body').addClass('modal-open')
		}
    });

	
	przeladujWidok();
		
	if(($('#panel_logowania_formularz').size()) == 1){
		$('.plt_zaloguj').click(function(){
			zaloguj();
		});
		$('.strona_glowna').unbind().removeClass('przeladuj_widok');
		$('#panel_logowania_formularz').on('keydown','.uzytkownik_haslo',function(e) {	
			if(e.keyCode == 13){		
				zaloguj();				
			}
		});
		
		$('.reset_hasla').off('click','.reset_hasla_przycisk');
		$('.reset_hasla').on('click','.reset_hasla_przycisk',function(){
			resetuj_haslo();
		});
		
		$('.reset_hasla').off('click','.powrot_do_strony_glownej');
		$('.reset_hasla').on('click','.powrot_do_strony_glownej',function(){
			window.location = adres_hosta;
		});
	}
	
	if(($('#panel_logowania_formularz').size()) == 0){
		$('.wyloguj').click(function(){
			wyloguj();	
		});
		
		czas_sesji = setInterval(function(){ licznik_sesji(); },60000);
		$('.licznik_sesji_ikona').click(function(){
			odswiez_sesje();
		});
		
		var sesja = zadanieAjax('app/ajax/akcje/ajax_sprawdz_sesje', null);
		if(sesja === '1'){
			przeladujNaAktywnaZakladke();
		}else{
			wyloguj();
		}
		
		aktywna_sesja = setInterval(function(){ sprawdz_aktywna_sesje(); }, 5000);
		
	}					
	dodaj_usun_wysun('wysun_menu', 'menu', 'prawo');

    $(this).off('keyup','.wyszukaj_like');
    $(this).on('keyup','.wyszukaj_like',function(e){
        if(e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 97 && e.keyCode <= 122 || e.keyCode == 8){

            var wartosc = $(this).val();
            var tabela = $(this).data('tabela');
            var szukaj_po = $(this).data('szukaj_po');

            if(wartosc != '' && tabela != '' && szukaj_po != '' && wartosc.length > 2){
                var formData = new FormData();
                formData.append('akcja', 'wyszukaj_like');
                formData.append('wartosc', wartosc);
                formData.append('tabela', tabela);
                formData.append('szukaj_po', szukaj_po);

                var odpowiedz = zadanieAjax('app/ajax/akcje/ajax_wyszukaj', formData);

                if(!$(this).parent().find('.popover').hasClass('in')){
                    $(this).popover('show');
                }


                if(odpowiedz == ''){
                    $('.wyszukaj_like_pole .pojedynczy_wynik').remove();
                    $('.wyszukaj_like_pole .popover-content').text('Brak wyników...');
                }else{
                    $('.wyszukaj_like_pole .popover-content').html(odpowiedz);
                    //przeladujFunkcjeWidoku();

                }
            }else{
                $(this).popover('hide');
            }

        }

    });


	
	
		
});

function resetuj_haslo(){
	$('.haslo').removeAttr('required');
	$('#powiadomienie_formularz').remove();
	
	var haslo = $('.uzytkownik_haslo').val();
	var haslo_powtorz = $('.uzytkownik_powtorz_haslo').val();
	
	if(haslo == '' || haslo_powtorz == ''){
		wyswietl_powiadomienie_formularz('Uzupełnij wymagane pola!!!', 0);
		$('.haslo').attr('required','required');
		return;
	}
	
	if(haslo != haslo_powtorz){
		$('.haslo').attr('required','required');
		wyswietl_powiadomienie_formularz('Podane hasła są różne!!!', 0);
		return;
	}
	
	if(main.mainPoprawnoscHasla(haslo)){
		
		wyswietl_loader('Prosze czekać!!!');
		
		var formData = new FormData();
			formData.append('id', $('#panel_logowania_formularz').data('element_id'));
			formData.append('imie', $('.uzytkownik_imie').val());
			formData.append('nazwisko', $('.uzytkownik_nazwisko').val());
			formData.append('login', $('.uzytkownik_login').val());
			formData.append('haslo', haslo);
			formData.append('bilet', $('#panel_logowania_formularz').data('bilet'));
		
		var przypomnij = zadanieAjax('app/ajax/akcje/ajax_ustaw_nowe_haslo', formData);
		
		przypomnij = $.parseJSON(przypomnij);
		
		if(przypomnij[0] === 0){
			wyswietl_loader(przypomnij[1]);
			setTimeout(function(){
				window.location = adres_hosta;
			}, 4000);
			return;
		}
		
		if(przypomnij[0] === 1){
			wyswietl_loader(przypomnij[1]);
			
			setTimeout(function(){
				wyswietl_loader('Trwa przekierowywanie, Proszę czekać!!!');
				setTimeout(function(){
					window.location = adres_hosta;
				}, 1000);
			}, 3000);			
			
			
		}
		
	};
	
}

function wyswietl_panel_body(){
	$('.panel-heading').unbind();
	$('.panel-heading').click(function(){
		if(!$(this).hasClass('uprawnienia_panel')){
			$(this).toggleClass('aktywny');
			$(this).next().slideToggle();
		}		
		
		odswiez_sesje();
	});
}

function przelacz_element_dropdown(){
	$('.element_grupa_opcja').click(function(){
		var element_id = $(this).data('element_id');
		var wartosc = $(this).data('wartosc');
		$(this).parent().parent().find('.element_grupa_opcja_naglowek').text(wartosc).attr('value',element_id);
		$(this).parent().find('.aktywna').removeClass('aktywna');
		$(this).addClass('aktywna');
	});
}

function zaznacz_odznacz_box(){
	$('.ikona_zaznacz').unbind();
	$('.ikona_zaznacz').click(function(){
		if($(this).hasClass('zaznaczony')){
			$(this).removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');			
		}else{
			$(this).addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');	
		}
	});
}

function zaznacz_odznacz_box_w(){
	$('.ikona_zaznacz_w').unbind();
	$('.ikona_zaznacz_w').click(function(){
		if($(this).hasClass('zaznaczony')){
			$(this).removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');			
		}else{
			$(this).addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');	
		}
	});
}

function popup_wczytaj_tresc(tytul, tresc, klasa){
	$('.popup_tytul').text(tytul);
	if(klasa != undefined){
		$('.popup_tytul').addClass(klasa);
	}
		
	document.getElementById('popup_tresc').innerHTML = tresc;	
	
	$('#myModal').on('hidden.bs.modal', function (e) {
		$('.popup_tytul').removeClass(klasa);
		$('.popup_tytul').text('');
		document.getElementById('popup_tresc').innerHTML = '';	
	});
	
	$('#myModal').on('show.bs.modal', function (event) {
		$('#myModal').css({
			  'padding-right' : '0px'
		  });
	});
	
}

function wyswietlPopUp(tytul, tresc, klasa, numer){
    document.getElementById('popUpTresc'+numer).innerHTML = tresc;
    document.getElementById('popUpTytul'+numer).innerHTML = tytul;
    $('.modal-dialog'+numer).removeClass('modal-lg').removeClass('modal-sm').removeClass('modal-lgsm').addClass(klasa);
    $('#popUp'+numer).modal('show');
}

function przeladujNaAktywnaZakladke(){
		
	if(getCookie('modul') != ''){
		
		var modul = getCookie('modul');	
		var widok_url = adres_hosta+'/app/moduly/'+modul+'/index';
		przeladujWidokZadanieAjax(widok_url, modul, 'zawartosc_strony', '', modul);

		if(getCookie('strona') != ''){
			var strona = getCookie('strona');
			widok_url = adres_hosta+'/app/moduly/'+modul+'/strony/strona_'+strona; 			
			przeladujWidokZadanieAjax(widok_url, strona, 'zawartosc_strony', '', getCookie('strona_tytul'));	
			$('.przycisk_border').first().addClass('aktywny');
			
			if(getCookie('zakladka') != ''){	
				var zakladka = getCookie('zakladka');
				//alert(zakladka);
				widok_url = adres_hosta+'/app/moduly/'+modul+'/zakladki/zakladka_'+zakladka; 			
				przeladujWidokZadanieAjax(widok_url, zakladka, 'zawartosc_strona_p', '', getCookie('zakladka_tytul'));
			}
		}else{
			if(getCookie('zakladka') != ''){	
				var zakladka = getCookie('zakladka');
				//alert(zakladka);
				widok_url = adres_hosta+'/app/moduly/'+modul+'/zakladki/zakladka_'+zakladka; 			
				przeladujWidokZadanieAjax(widok_url, zakladka, 'zawartosc_strona_p', '', getCookie('zakladka_tytul'));
			}
		}				
	}
	
	zaladuj_tresc_pierwszej_zakladki(getCookie('modul'));	
}

function przeladujDatePicker() {

    var zakladka = $('.zakladka.aktywny').data('zakladka');
    if(zakladka !== undefined){
        var widok_url = adres_hosta+'/app/moduly/wokandy/zakladki/zakladka_lista_wokand';
        przeladujWidokZadanieAjax(widok_url, 'lista_wokand', 'zawartosc_strona_p', '', getCookie('strona_tytul'));
    }

    $('.datepicker').datetimepicker({
        format: "YYYY-MM-DD"
        ,locale: 'pl'

    });

}
function przeladujDatePickerFiltruj() {
  $.ajax({
    method: "POST",
    url: adres_hosta+'/app/moduly/wokandy/zakladki/zakladka_lista_wokand',
    async: false
  }).done(function( data ) {
    document.getElementById('zawartosc_strona_p').innerHTML = data;
    var pasek_g = getCookie('strona_tytul');
    $('.pasek_g_d.pasek_gorny').text(pasek_g);
  });

  przeladujWidok();
  $('.datepicker').datetimepicker({
    format: "YYYY-MM-DD"
    ,locale: 'pl'

  });

}
function przeladujFunkcjeWidoku(){
	aktualizujWartoscInputTextarea();
	
	$('[data-toggle="popover"]').popover({ html : true });
	$('[data-toggle="tooltip"]').tooltip();
	
	$('.timepicker').timepicker({
		showMeridian : false
	});

	$('.data').keydown(function(e){
		if($(this).hasClass('fdata_wokanda_od') || $(this).hasClass('fdata_wokanda_do')){
			if(e.keyCode == 8){
				$(this).val('');
				$(this).attr('value','');
				return;
			}
		}
	    return false;
	});

	$('.timepicker').keydown(function(){
	    return false;
	});
	
	//$('.data').datetimepicker().destroy();
	$('.data').datetimepicker({
        format: "YYYY-MM-DD"
        ,locale: 'pl'

    });

    $('.start').on("dp.change", function (e) {
        $(this).parent().parent().find('.stop').data("DateTimePicker").date(e.date);
    });

    $('.stop').on("dp.change", function (e) {
        $(this).parent().parent().find('.start').data("DateTimePicker").date(e.date);
    });
			
	przelacz_element_dropdown();
	zaznacz_odznacz_box();
	
	if(getCookie('modul') !== ''){
		require(adres_hosta+'/app/moduly/'+getCookie('modul')+'/js/funkcje_'+getCookie('modul')+'.js');
	}
	
	if(getCookie('strona') !== ''){		
		require(adres_hosta+'/app/moduly/'+getCookie('modul')+'/js/klasa_'+getCookie('strona')+'.js');

		if(getCookie('strona') === 'zarzadzanie_wokandami'){
            require(adres_hosta+'/app/moduly/'+getCookie('modul')+'/js/klasa_wokandy_administracja.js');
        }

	}
	
	aktywujDataTable('tabela_historia', 0,'desc');
    aktywujDataTable('tabela_lista_substytutow_pow', 4,'asc');
	
	$('.nav-tabs li a').click(function(){
		odswiez_sesje();
	});
	
	wyszukajLike();
	wyswietl_panel_body();
	
}

function aktywujDataTable(klasa, order, order_kierunek, ilewynikow){
	if(!$('.'+klasa).hasClass('dataTable')){
		if(ilewynikow == undefined || ilewynikow == ''){
			ilewynikow = 10;
		}


		
		$('.'+klasa).DataTable({
	        "language": {
	            	"emptyTable":     "Brak danych",
	                "info":           "Liczba wierszy: _TOTAL_",
	                "infoEmpty":      "Liczba wierszy: 0",
	                "lengthMenu":     "Wyświetl _MENU_",
	                "loadingRecords": "Ładowanie...",
	                "searchPlaceholder": "Wyszukaj",
	                "zeroRecords":    "Brak wyników wyszukiwania",
	                "paginate": {
	                    "first":      "Pierwszy",
	                    "last":       "Ostatni",
	                    "next":       "Następny",
	                    "previous":   "Poprzedni"
	                },
					"search":         "",
					"infoFiltered": "(wyfiltrowano z _MAX_)"
	        },
	        "lengthMenu": [[ilewynikow, 50, -1], [ilewynikow, 50, "Wszystkie"]],
	        "order": [[ order, order_kierunek ]],
	        "iDisplayLength": ilewynikow,
	        "aoColumnDefs": [
							 {
							   "bSortable": false,
							   "aTargets": [ -1 ] // <-- gets last column and turns off sorting
							  }
	                      ]
	    });
	}

}

function isset(variable) {
    return typeof variable !== typeof undefined ? true : false;
}


function require(script) {
    $.ajax({
    	method: "POST",
        url: script,
        dataType: "script",
        async: false
    });
}

function usun_polskie_znaki(wartosc){
	return wartosc.replace(/ą/g, 'a').replace(/Ą/g, 'A')
    .replace(/ć/g, 'c').replace(/Ć/g, 'C')
    .replace(/ę/g, 'e').replace(/Ę/g, 'E')
    .replace(/ł/g, 'l').replace(/Ł/g, 'L')
    .replace(/ń/g, 'n').replace(/Ń/g, 'N')
    .replace(/ó/g, 'o').replace(/Ó/g, 'O')
    .replace(/ś/g, 's').replace(/Ś/g, 'S')
    .replace(/ż/g, 'z').replace(/Ż/g, 'Z')
    .replace(/ź/g, 'z').replace(/Ź/g, 'Z');
}

function zaladuj_tresc_pierwszej_zakladki(modul_tmp){
	var zakladka = $('.zakladka.aktywny').data('zakladka');
	if(zakladka !== undefined){
		var widok_url = adres_hosta+'/app/moduly/'+modul_tmp+'/zakladki/zakladka_'+zakladka;
		przeladujWidokZadanieAjax(widok_url, zakladka, 'zawartosc_strona_p', '', getCookie('strona_tytul'));
	}	
}

function odswiez_sesje(){			
	if($('.licznik_sesji_ikona').data('licznik_sesji_liczba') != 60){
		zadanieAjax('app/ajax/akcje/ajax_odswiez_sesje', null);
		
		$('.licznik_sesji_ikona').data('licznik_sesji_liczba','60');
		$('.licznik_sesji_ikona').attr('data-licznik_sesji_liczba','60');
		$('.licznik_sesji_napis').text('60 min. do końca sesji');
	}
	
		
}

function licznik_sesji(){
	var aktualny_czas = $('.licznik_sesji_ikona').data('licznik_sesji_liczba');
	var nowy_czas = aktualny_czas - 1;
			
	if(nowy_czas <= 0 ){
		clearInterval(czas_sesji);
		wyloguj();
		return;
	}
	
	$('.licznik_sesji_ikona').data('licznik_sesji_liczba',nowy_czas);
	$('.licznik_sesji_ikona').attr('data-licznik_sesji_liczba',nowy_czas);
	$('.licznik_sesji_napis').text(nowy_czas+' min. do końca sesji');
	
}

function sprawdz_aktywna_sesje(){
	var formData = new FormData();
		formData.append('akcja', 'sprawdz_aktywna_sesje');
	
	var odpowiedz = zadanieAjax('app/cron', formData);
	
	odpowiedz = $.parseJSON(odpowiedz); 

	if(odpowiedz[0] === 0){
		wyloguj('Nastąpiło automatyczne wylogowanie!!!');
	}
	
}

function dodaj_usun_wysun(co_klik_tmp, co_wysun_tmp, kierunek_tmp){
	$('.'+co_klik_tmp).click(function(){
		$('.'+co_wysun_tmp).toggleClass('wysun_'+kierunek_tmp);
	});
}

function przeladujWidok(){

	$('[data-toggle="tooltip"]').tooltip();
	
		
	$('.przeladuj_widok').unbind('click');
	$('.przeladuj_widok').click(function(){
		
		$('.menu').removeClass('wysun_prawo');	
						
		if($(this).data('widok')){
			var widok = $(this).data('widok');
		}
		
		var widok_url = adres_hosta+'/app/widoki/widok_'+widok;
		var klikniety_id = $(this).attr('id');
		
		if($(this).hasClass('strona_glowna')){
			setCookie('modul', '');
			setCookie('strona', '');
			setCookie('strona_tytul', '');
			setCookie('zakladka', '');
			setCookie('zakladka_tytul', '');
			
			przeladujWidokZadanieAjax(widok_url, klikniety_id, 'zawartosc_strony', widok ,'strona główna');
			odswiez_sesje();
			return;
		}
		
		if($(this).hasClass('panel_logowania')){
		
			przeladujWidokZadanieAjax(widok_url, klikniety_id, 'panel_logowania_formularz', widok );
			return;
		}
		
		if($(this).hasClass('modul')){
			var modul = $(this).data('modul');
			
			setCookie('modul', modul);
			setCookie('strona', '');
			setCookie('strona_tytul', '');
			setCookie('zakladka', '');
			setCookie('zakladka_tytul', '');
			
			widok_url = adres_hosta+'/app/moduly/'+modul+'/index'; 
			przeladujWidokZadanieAjax(widok_url, klikniety_id, 'zawartosc_strony', '', modul);
			odswiez_sesje();
			return;			
		}
		
		if($(this).hasClass('strona')){
			var modul = $(this).data('modul');
			var strona = $(this).data('strona');
			var strona_tytul = $(this).attr('title');
			
			setCookie('strona', strona);
			setCookie('strona_tytul', strona_tytul); 
			
			widok_url = adres_hosta+'/app/moduly/'+modul+'/strony/strona_'+strona; 
			przeladujWidokZadanieAjax(widok_url, klikniety_id, 'zawartosc_strony', '', strona_tytul);
			odswiez_sesje();
			$('.przycisk_border').first().addClass('aktywny');
			zaladuj_tresc_pierwszej_zakladki(modul);
			return;			
		}
		
		if($(this).hasClass('zakladka')){
			var modul = $(this).data('modul');
			var zakladka = $(this).data('zakladka');
			var zakladka_tytul = $(this).attr('title');
						
			setCookie('zakladka', zakladka);
			setCookie('zakladka_tytul', zakladka_tytul);
			
			widok_url = adres_hosta+'/app/moduly/'+modul+'/zakladki/zakladka_'+zakladka; 
			przeladujWidokZadanieAjax(widok_url, klikniety_id, 'zawartosc_strona_p', '', zakladka_tytul);
			odswiez_sesje();
			return;			
		}
		
		przeladujWidokZadanieAjax(widok_url, klikniety_id, 'zawartosc_strony');
		odswiez_sesje();
					
		
		
	});	
}

function przeladujWidokZadanieAjax(url_tmp, klikniety_tmp, cel_div_id, widok_tmp, tytul_strony_tmp){
	$.ajax({
		method: "POST",
		url: url_tmp,
		async: false
	}).done(function( data ) {

		document.getElementById(cel_div_id).innerHTML = data ;
		
		if(($('#panel_logowania_formularz').size()) == 1){
			if(widok_tmp === 'zaloguj'){
				$('.tytul_widok_napis').text('WPROWADŹ NAZWE UŻYTKOWNIKA I HASŁO');
				$('.plt_zaloguj').click(function(){
					zaloguj();
				});
				
				$('#panel_logowania_formularz').off('keydown','.uzytkownik_haslo');
				$('#panel_logowania_formularz').on('keydown','.uzytkownik_haslo',function(e) {	
					if(e.keyCode == 13){		
						zaloguj();				
					}
				});				
			}
			
			if(widok_tmp === 'zapomnialem_hasla'){
				$('.tytul_widok_napis').text('WPROWADŹ NAZWE UŻYTKOWNIKA I ADRES EMAIL');
				
				$('.plt_przypomnij_haslo').click(function(){
					przypomnij_haslo();
				});
				
				$('#panel_logowania_formularz').off('keydown','.uzytkownik_email');
				$('#panel_logowania_formularz').on('keydown','.uzytkownik_email',function(e) {
					if(e.keyCode == 13){		
						przypomnij_haslo();
						
					}
				});
				
			}
			
			if(widok_tmp === 'zarejestruj_sie'){
				$('.tytul_widok_napis').text('WPROWADŹ WSZYSTKIE WYMAGANE DANE');
			}
		}else{
			if(tytul_strony_tmp){
				$('.pasek_g_d.pasek_gorny').text(tytul_strony_tmp);
			}
			przeladujWidok();
		}
				
		$('.przycisk_border').removeClass('aktywny');
		$('#'+klikniety_tmp).addClass('aktywny');
						
		przeladujFunkcjeWidoku();
		
		
	}).fail(function(ajaxContext) {
		var odpowiedz = ajaxContext.responseText;

		alert(odpowiedz);
		
	});
}

function aktualizujWartoscInputTextarea(){
	$('input').unbind();
	$('input').keyup(function(){
		var wartosc = $(this).val();
		
		$(this).attr('value', wartosc);
	});
	$('textarea').unbind();
	$('textarea').keyup(function(){
		var wartosc = $(this).val();
		
		$(this).attr('value', wartosc);
	});
}

function zadanieAjax(url_tmp, dane_tmp){
	var return_dane;
	
	$.ajax({
		method: "POST",
		url: url_tmp,
		data : dane_tmp,
		async: false,
		contentType: false,
        processData: false
	}).done(function( dane ) {
				
		return_dane = dane;
						
	}).fail(function(ajaxContext) {

		var odpowiedz = ajaxContext.responseText;
		
		alert(odpowiedz);
		
	});
	
	return return_dane;
}

function zaloguj(){
	var uzytkownik_login = $('.uzytkownik_login').val();
	var uzytkownik_haslo = $('.uzytkownik_haslo').val();
	
	if(uzytkownik_login == '' || uzytkownik_haslo == ''){
		wyswietl_powiadomienie_formularz('Uzupełnij wszystkie pola!!!', 0);
		return;
	}
	
	var formData = new FormData();
	formData.append('login', uzytkownik_login);
	formData.append('haslo', uzytkownik_haslo);
	
	var zaloguj = zadanieAjax('app/ajax/akcje/ajax_zaloguj', formData);
	zaloguj = $.parseJSON(zaloguj);
	
	if(zaloguj[0] === 0){
		wyswietl_powiadomienie_formularz(zaloguj[1], 0);
		return;
	}
	
	if(zaloguj[0] === 1){
		location.reload();
		return;
	}
	
	if(zaloguj[0] === 2){
		wyswietl_powiadomienie_formularz(zaloguj[1], 0);
		return;
	}
}

function przypomnij_haslo(){
	$('#powiadomienie_formularz').remove();
	
	var uzytkownik_login = $('.uzytkownik_login').val();
	var uzytkownik_email = $('.uzytkownik_email').val();
	
	
	
	if(uzytkownik_login == '' || uzytkownik_email == ''){
		wyswietl_powiadomienie_formularz('Uzupełnij wszystkie pola!!!', 0);
		return;
	}
	
	wyswietl_powiadomienie_formularz('Proszę czekać!', 1);
	
	var formData = new FormData();
		formData.append('login', uzytkownik_login);
		formData.append('email', uzytkownik_email);
	
	var przypomnij = zadanieAjax('app/ajax/akcje/ajax_przypomnij_haslo', formData);
	
	//alert(przypomnij);
	
	przypomnij = $.parseJSON(przypomnij);
	
	if(przypomnij[0] === 0){
		wyswietl_powiadomienie_formularz(przypomnij[1], 0);
		return;
	}
	
	if(przypomnij[0] === 1){
		wyswietl_powiadomienie_formularz(przypomnij[1], 1);
		
		$('.uzytkownik_login').val('');
		$('.uzytkownik_email').val('');
		
		setTimeout(function(){ 
			location.reload();
		}, 3000);
		return;
	}
}

function wyloguj(komunikattmp){
	var komunikat_tresc = komunikattmp;
	if(komunikat_tresc == undefined){
		komunikat_tresc = 'Trwa wylogowywanie!!!';
	}
	
	powiadomienie_systemowe('WOKANDY | KAIRP', komunikat_tresc);
	wyswietl_loader('Trwa wylogowywanie...');
	
	var formData = new FormData();
	zadanieAjax('app/ajax/akcje/ajax_wyloguj', formData);
		
	deleteCookie('modul');
	deleteCookie('strona');
	deleteCookie('strona_tytul');
	deleteCookie('zakladka');
	deleteCookie('zakladka_tytul');
		
	setTimeout(function(){
		location.reload();
	}, 2000);
		
	
		
}

function wyswietl_powiadomienie_formularz(komunikat_tmp, rodzaj_tmp){
	$('#powiadomienie_formularz').remove();
	
	var klasa = 'blad';
	
	if(rodzaj_tmp === 1){
		klasa = 'sukces';
	}
	
	$('#panel_logowania_formularz').append('<div id="powiadomienie_formularz" class="margin_t_10 text-center '+klasa+'"><dt>'+komunikat_tmp+'</dt></div>');
		
}

function setCookie(nazwa_tmp,wartosc_tmp){
	document.cookie = nazwa_tmp + "=" + wartosc_tmp + "; path=/; ";
}

function getCookie(nazwa_tmp){
	var nazwa = nazwa_tmp + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++){
		var c = ca[i].trim();
		if (c.indexOf(nazwa)==0) return c.substring(nazwa.length,c.length);
	}
	return "";
}

function deleteCookie(nazwa_tmp){
	document.cookie = nazwa_tmp + "=; path=/; ";
}

function wyswietl_loader(tresc){
	if(tresc !== ''){
		$('.loader_info').html(tresc);
	}else{
		$('.loader_info').text('Ładowanie...');
	}
	$('#preloader').delay(200).fadeIn();
}

function powiadomienie_strona(powiadomienie_strona_tresc, rodzaj){
	$('.alert_na_stronie').remove();
	var powiadomienie = '<div class="alert_na_stronie alert alert-'+rodzaj+'">'+powiadomienie_strona_tresc+'</div>';
	
	$('.nav-tabs').prepend(powiadomienie);
	
}

function wyswietl_wczytywanie_danych_animacja(klasa){
	$('.'+klasa).append('<div class="wczytywanie_danych_tlo"><div class="wczytywanie_danych"></div></div>');
	$('.wczytywanie_danych_tlo').addClass('wyswietl');

	
}

function ukryj_wczytywanie_danych_animacja(){
	$('.wczytywanie_danych_tlo').remove();

}

function powiadomienie_systemowe(tytul_tmp, komunikat_tmp) {
	  if (!('Notification' in window)) {
	    alert('Ta przeglądarka nie wspiera powiadomień systemowych!!!');
	    return;
	  }
	  
	  var opcje = {
		      		body: komunikat_tmp
	  			  }
	  
	  if (Notification.permission === "granted") {
	    var notification = new Notification(tytul_tmp, opcje);
	    return;
	  }
	  
	  if (Notification.permission !== 'denied') {
	    Notification.requestPermission(function (permission) {
	      if (permission === "granted") {
	        var notification = new Notification(tytul_tmp, opcje);
	        return;
	      }
	    });
	  }
}

function powiadomienie(rodzaj_tmp, tytul_tmp, tresc_tmp){
	
	var rodzaj = rodzaj_tmp;
	
	if(rodzaj === 'sukces'){
		var typ = 'success';
		var ikona = 'fa fa-check';
	}
	
	if(rodzaj === 'blad'){
		var typ = 'danger';
		var ikona = 'fa fa-exclamation';
	}
	
	if(rodzaj === 'info'){
		var typ = 'info';
		var ikona = 'fa fa-info';
	}
	
	if(rodzaj === 'uwaga'){
		var typ = 'warning';
		var ikona = 'fa fa-exclamation-triangle';
	}
	
	$.notify({
		icon: ikona,
		title: tytul_tmp,
		message: tresc_tmp
	},{
		element: 'body',
		type: typ,
		allow_dismiss: true,
		newest_on_top: true,
		placement: {
			from: "bottom",
			align: "right"
		},
		offset: {
		      x: 20,
		      y: 80
		    },
		spacing: 10,
		z_index: 1031,
		delay: 5000,
		icon_type: 'class',
		template: '<div data-notify="container" class="col-xs-10 pow_alert_sm alert alert-{0}" role="alert">' +
			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
			'<span data-notify="icon"></span> ' +
			'<span data-notify="title">{1}</span> ' +
			'<span data-notify="message">{2}</span>' +
			'<div class="progress" data-notify="progressbar">' +
				'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
			'</div>' +
			'<a href="{3}" target="{4}" data-notify="url"></a>' +
		'</div>' 
	});
}

function wyszukajLike(){
	
	$('.wyszukaj_like').popover({
		content : 'Brak wyników...'
		,html : true
		,placement : 'bottom'
		,trigger : 'manual'
	});

}

function sprawdz_uprawnienie(lista_uprawnien, uprawnienie){
	if(lista_uprawnien.indexOf(uprawnienie) >= 0){
		return true;
	}else{
		return false;
	}

}

function Main(){
	this.mainEdytujWidokElement = function(_id, _tab, widok){
		var formData = new FormData();
			formData.append('id', _id);
			formData.append('tab', _tab);
		
		var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/ajax/widoki/ajax_widok_'+widok, formData);		
		document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;

        if(widok === 'kalendarz'){
            aktywuj_kalendarz();
        }

		przeladujFunkcjeWidoku();
		odswiez_sesje();
	
	},
	this.mainUsunPrzywrocElement = function (_id, _co, _akcja, _przeladuj){
		var formData = new FormData();
			formData.append('akcja', _co+'_'+_akcja);
			formData.append('id', _id);
	
		main.mainWyslijZadanie('app/moduly/'+getCookie('modul')+'/ajax/akcje/ajax_'+_akcja, formData);

		if(_przeladuj === undefined){
            var odpowiedz = zadanieAjax('app/moduly/'+getCookie('modul')+'/zakladki/zakladka_'+getCookie('zakladka'), formData);
            document.getElementById('zawartosc_strona_p').innerHTML = odpowiedz ;
		}

        if($('#kalendarz').hasClass('aktywny')){
            aktywuj_kalendarz();
        }
	
		przeladujFunkcjeWidoku();
	},
	this.mainWyslijZadanie = function(_link, _formdata){
		
		var odpowiedz = zadanieAjax(_link, _formdata);
//alert(odpowiedz);
		odpowiedz = $.parseJSON(odpowiedz); 
		
		var powidomienie_rodzaj;
		
		if(odpowiedz[0] === 1){
			powidomienie_rodzaj = 'sukces';
            powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
            odswiez_sesje();
		}
		
		if(odpowiedz[0] === 0){
			powidomienie_rodzaj = 'blad';
            powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
            odswiez_sesje();
		}
		
		if(odpowiedz[0] === 2){
			powidomienie_rodzaj = 'uwaga';
            powiadomienie(powidomienie_rodzaj, odpowiedz[1], '');
            odswiez_sesje();
		}
		

		
		if(odpowiedz[2] != undefined){
			return odpowiedz[2];
		}

		return odpowiedz[0];
	},
	
	this.mainPoprawnoscHasla = function(_haslo){	
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
	    
	    if(t1 != '' || t2 != '' || t3 != '' || t4 != ''){
	    	powiadomienie('blad', 'Hasło nie spełnia minimalnych wymagań!!!', '<ul class="margin_t_10 margin_b_0">'+t1+t2+t3+t4+'</ul>');  
	    	$('.haslo').attr('required','required');
	    	
	    	return false;
	    }
	    
	    return true;
	     
	}
}

/*FIX TO POPOVER TOGGLE HIDE AND SHOW DOUBLE CLICK*/
$('body').on('hidden.bs.popover', function (e) {
    $(e.target).data("bs.popover").inState = { click: false, hover: false, focus: false }
});
