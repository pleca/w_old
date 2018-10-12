var main_dane = null;
var formData = new FormData();
var odpowiedz = null;

function grid1(odpowiedz) {
  $("#grid").kendoGrid({
    toolbar: ["excel"],
    excelExport: function(e) {
      var sheet = e.workbook.sheets[0];
      for (var rowIndex = 0; rowIndex < sheet.rows.length; rowIndex++) {
        var row = sheet.rows[rowIndex];
        if (rowIndex == 0) {
          for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
            row.cells[0].background = "#fabf8f";
            row.cells[0].format = "yy-MM-dd";
            row.cells[1].background = "#fabf8f";
            row.cells[1].format = "hh:mm";
            row.cells[2].background = "#fabf8f";
            row.cells[3].background = "#fabf8f";
            row.cells[4].background = "#fabf8f";
            row.cells[5].background = "#fabf8f";
            row.cells[6].background = "#fabf8f";
            row.cells[7].background = "#fde9d9";
            row.cells[8].background = "#fabf8f";
            row.cells[9].background = "#fabf8f";
            row.cells[10].background = "#65ccff";
            row.cells[11].background = "#65ccff";
            row.cells[12].background = "#65ccff";
            row.cells[13].background = "#65ccff";
            row.cells[14].background = "#65ccff";
            row.cells[14].color = "#FF0000";
            row.cells[15].background = "#65ccff";
            row.cells[16].background = "#b1a0c7";
            row.cells[17].background = "#b1a0c7";
            row.cells[18].background = "#fabf8f";
            row.cells[19].background = "#fabf8f";
            row.cells[20].background = "#65ccff";
            row.cells[20].color = "#FF0000";
            row.cells[21].background = "#65ccff";
            row.cells[22].background = "#fde9d9";
            row.cells[23].background = "#fde9d9";
            row.cells[24].background = "#fabf8f";
          }
        }

      }
    },
    excel: {
      fileName: "Raport1.xlsx",
      //proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true,
      allPages: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      },
      pageSize: 20
    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data", width: 150},
      { field: "godzina", title: "Godzina", width: 120},
      { field: "nazwa_sadu", title: "Nazwa sądu", width: 120},
      { field: "miasto", title: "Miasto"},
      { field: "sala", title: "Sala"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "powod", title: "Powód"},
      { field: "wps", title: "WPS"},
      { field: "prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "etap_wokandy", title: "Etap wokandy"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "koszt_stawiennictwa_kwota", title: "Koszt stawiennictwa"},
      { field: "forma_platnosci", title: "Forma Płatności"},
      { field: "wytyczne", title: "Wytyczne"},
      { field: "umocowanie_w_sadzie_pelnomocnik_substytucyjny_z_kairp", title: "Umocowanie w sądzie / Pełnomocnik substytucyjny z KAIRP"},
      { field: "fv_byla", title: "Faktura"},
      { field: "refaktura", title: "Refaktura"},
      { field: "nr_kancelarii_nr_votum", title: "nr Kancelarii"},
      { field: "p_ko_druga_strona", title: "Druga strona"},
      { field: "uwagi", title: "Uwagi"},
      { field: "pelnomocnik_glowny", title: "Pełnomocnik Główny"},
      { field: "zwolnienie_z_kosztow_klient_zwolniony_z_oplat", title: "Zwolniony z kosztów / Klient zwolniony z opłat"},
      { field: "rodzaj_umowy_z_votum", title: "Rodzaj umowy z Votum"},
      { field: "osoba_z_wokand", title: "Osoba z Wokand"}
    ]

  });
}

function grid2(odpowiedz){
  $("#grid2").kendoGrid({
    toolbar: ["excel"],
    excelExport: function(e) {
      var sheet = e.workbook.sheets[0];
      for (var rowIndex = 0; rowIndex < sheet.rows.length; rowIndex++) {
        var row = sheet.rows[rowIndex];
        if (rowIndex == 0) {
          for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
            row.cells[0].background = "#fabf8f";
            row.cells[1].background = "#fabf8f";
            row.cells[2].background = "#fabf8f";
            row.cells[3].background = "#fabf8f";
            row.cells[4].background = "#fabf8f";
            row.cells[5].background = "#fabf8f";
            row.cells[6].background = "#fabf8f";
            row.cells[7].background = "#fde9d9";
            row.cells[8].background = "#fabf8f";
            row.cells[9].background = "#fabf8f";
            row.cells[10].background = "#65ccff";
            row.cells[11].background = "#65ccff";
            row.cells[12].background = "#65ccff";
            row.cells[13].background = "#65ccff";
            row.cells[14].background = "#65ccff";
            row.cells[14].color = "#FF0000";
            row.cells[15].background = "#65ccff";
            row.cells[16].background = "#b1a0c7";
            row.cells[17].background = "#b1a0c7";
            row.cells[18].background = "#fabf8f";
            row.cells[19].background = "#fabf8f";
            row.cells[20].background = "#65ccff";
            row.cells[20].color = "#FF0000";
            row.cells[21].background = "#65ccff";
            row.cells[22].background = "#fde9d9";
            row.cells[23].background = "#fde9d9";
            row.cells[24].background = "#fabf8f";
          }
        }

      }
    },
    excel: {
      fileName: "Raport2.xlsx",
      proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true,
      allPages: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      },
      pageSize: 20
    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data"},
      { field: "godzina", title: "Godzina"},
      { field: "nazwa_sadu", title: "Nazwa sądu"},
      { field: "miasto", title: "Miasto"},
      { field: "sala", title: "Sala"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "powod", title: "Powód"},
      { field: "wps", title: "WPS"},
      { field: "prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "etap_wokandy", title: "Etap wokandy"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "koszt_stawiennictwa_kwota", title: "Koszt stawiennictwa"},
      { field: "forma_platnosci", title: "Forma Płatności"},
      { field: "wytyczne", title: "Wytyczne"},
      { field: "umocowanie_w_sadzie_pelnomocnik_substytucyjny_z_kairp", title: "Umocowanie w sądzie / Pełnomocnik substytucyjny z KAIRP"},
      { field: "fv_byla", title: "Faktura"},
      { field: "refaktura", title: "Refaktura"},
      { field: "nr_kancelarii_nr_votum", title: "nr Kancelarii"},
      { field: "p_ko_druga_strona", title: "Druga strona"},
      { field: "uwagi", title: "Uwagi"},
      { field: "pelnomocnik_glowny", title: "Pełnomocnik Główny"},
      { field: "zwolnienie_z_kosztow_klient_zwolniony_z_oplat", title: "Zwolniony z kosztów / Klient zwolniony z opłat"},
      { field: "rodzaj_umowy_z_votum", title: "Rodzaj umowy z Votum"},
      { field: "osoba_z_wokand", title: "Osoba z Wokand"}
    ]

  });
}
function grid3(odpowiedz){
  $("#grid3").kendoGrid({
    toolbar: ["excel"],
    excelExport: function(e) {
      var sheet = e.workbook.sheets[0];
      for (var rowIndex = 0; rowIndex < sheet.rows.length; rowIndex++) {
        var row = sheet.rows[rowIndex];
        if (rowIndex == 0) {
          for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
            row.cells[0].background = "#fabf8f";
            row.cells[1].background = "#fabf8f";
            row.cells[2].background = "#fabf8f";
            row.cells[3].background = "#fabf8f";
            row.cells[4].background = "#fabf8f";
            row.cells[5].background = "#fabf8f";
            row.cells[6].background = "#fabf8f";
            row.cells[7].background = "#fde9d9";
            row.cells[8].background = "#fabf8f";
            row.cells[9].background = "#fabf8f";
            row.cells[10].background = "#65ccff";
            row.cells[11].background = "#65ccff";
            row.cells[12].background = "#65ccff";
            row.cells[13].background = "#65ccff";
            row.cells[14].background = "#65ccff";
            row.cells[14].color = "#FF0000";
            row.cells[15].background = "#65ccff";
            row.cells[16].background = "#b1a0c7";
            row.cells[17].background = "#b1a0c7";
            row.cells[18].background = "#fabf8f";
            row.cells[19].background = "#fabf8f";
            row.cells[20].background = "#65ccff";
            row.cells[20].color = "#FF0000";
            row.cells[21].background = "#65ccff";
            row.cells[22].background = "#fde9d9";
            row.cells[23].background = "#fde9d9";
            row.cells[24].background = "#fabf8f";
          }
        }

      }
    },
    excel: {
      fileName: "Raport3.xlsx",
      proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true,
      allPages: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      },
      pageSize: 20
    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data"},
      { field: "godzina", title: "Godzina"},
      { field: "nazwa_sadu", title: "Nazwa sądu"},
      { field: "miasto", title: "Miasto"},
      { field: "sala", title: "Sala"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "powod", title: "Powód"},
      { field: "wps", title: "WPS"},
      { field: "prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "etap_wokandy", title: "Etap wokandy"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "koszt_stawiennictwa_kwota", title: "Koszt stawiennictwa"},
      { field: "forma_platnosci", title: "Forma Płatności"},
      { field: "wytyczne", title: "Wytyczne"},
      { field: "umocowanie_w_sadzie_pelnomocnik_substytucyjny_z_kairp", title: "Umocowanie w sądzie / Pełnomocnik substytucyjny z KAIRP"},
      { field: "fv_byla", title: "Faktura"},
      { field: "refaktura", title: "Refaktura"},
      { field: "nr_kancelarii_nr_votum", title: "nr Kancelarii"},
      { field: "p_ko_druga_strona", title: "Druga strona"},
      { field: "uwagi", title: "Uwagi"},
      { field: "pelnomocnik_glowny", title: "Pełnomocnik Główny"},
      { field: "zwolnienie_z_kosztow_klient_zwolniony_z_oplat", title: "Zwolniony z kosztów / Klient zwolniony z opłat"},
      { field: "rodzaj_umowy_z_votum", title: "Rodzaj umowy z Votum"},
      { field: "osoba_z_wokand", title: "Osoba z Wokand"}
    ]

  });
}
function grid4() {
  $("#grid4").kendoGrid({
    toolbar: ["excel"],
    excelExport: function(e) {
      var sheet = e.workbook.sheets[0];
      for (var rowIndex = 0; rowIndex < sheet.rows.length; rowIndex++) {
        var row = sheet.rows[rowIndex];
        //if (rowIndex == 0) {
        for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
        }
      }
    },
    excel: {
      fileName: "Raport4.xlsx",
      proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true,
      allPages: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      },
      pageSize: 20
    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data"},
      { field: "godzina", title: "Godzina"},
      { field: "miasto", title: "Miasto"},
      { field: "nazwa_sadu", title: "Nazwa sądu"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "powod", title: "Powód"},
      { field: "prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "etap_wokandy", title: "Etap wokandy"},
      { field: "sala", title: "Sala"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "wps", title: "WPS"}
    ]

  });
}

function grid5(odpowiedz) {
  $("#grid5").kendoGrid({
    toolbar: ["excel"],
    excel: {
      fileName: "Raport5.xlsx",
      //proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      }

    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data", witdh: 120},
      { field: "miasto", title: "Miasto"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "nazwisko_klienta", title: "Nazwisko klienta"},
      { field: "imie_klienta", title: "Imię klienta"},
      { field: "Prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "numer_sprawy", title: "Nr sprawy"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "koszt_stawiennictwa_kwota", title: "Koszt stawiennictwa"},
      { field: "forma_platnosci", title: "Forma płatności"}
    ]
  });
}

function grid6(odpowiedz){
  $("#grid6").kendoGrid({
    toolbar: ["excel"],
    excel: {
      fileName: "Raport6.xlsx",
      //proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
      filterable: true
    },
    dataSource: {
      data: {
        "items": odpowiedz
      },
      schema:{
        data: "items"
      }

    },
    scrollable: false,
    sortable: true,
    columns: [
      { field: "dat", title: "Data", width: 150},
      { field: "godzina", title: "Godzina", width: 120},
      { field: "nazwa_sadu", title: "Nazwa sądu", width: 120},
      { field: "miasto", title: "Miasto"},
      { field: "sala", title: "Sala"},
      { field: "sygnatura_akt_sadowych", title: "Sygnatura akt sądowych"},
      { field: "powod", title: "Powód"},
      { field: "wps", title: "WPS"},
      { field: "prawnik_prowadzacy", title: "Prawnik Prowadzący"},
      { field: "pelnomocnik_substytucyjny", title: "Substytut"},
      { field: "uprawnienia_zawodowe", title: "Uprawnienia zawodowe"},
      { field: "koszt_stawiennictwa_kwota", title: "Koszt stawiennictwa"},
      { field: "forma_platnosci", title: "Forma Płatności"},
      { field: "wytyczne", title: "Wytyczne"},
      { field: "umocowanie_w_sadzie_pelnomocnik_substytucyjny_z_kairp", title: "Umocowanie w sądzie / Pełnomocnik substytucyjny z KAIRP"},
      { field: "fv_byla", title: "Faktura"},
      { field: "refaktura", title: "Refaktura"},
      { field: "nr_kancelarii_nr_votum", title: "nr Kancelarii"},
      { field: "p_ko_druga_strona", title: "Druga strona"},
      { field: "uwagi", title: "Uwagi"},
      { field: "pelnomocnik_glowny", title: "Pełnomocnik Główny"},
      { field: "zwolnienie_z_kosztow_klient_zwolniony_z_oplat", title: "Zwolniony z kosztów / Klient zwolniony z opłat"},
      { field: "rodzaj_umowy_z_votum", title: "Rodzaj umowy z Votum"},
      { field: "osoba_z_wokand", title: "Osoba z Wokand"}
    ]
  });
}

if(getCookie('strona') == 'zarzadzanie_wokandami'){
  zakladka_zarzadzanie_wokandami();
}

if(getCookie('strona') == 'wokandy_administracja'){
  zakladka_wokandy_administracja();
}
$(document).ready(function(){

  $('.filtruj_tab').off('click');
  $('.filtruj_tab').on('click',  function(){
    wokanda.wokandaDatePicker();
    if($('.filtruj_tab').closest('li').hasClass('active') == false){
      $('.active').removeClass('active');
      $('.filtruj_tab').closest('li').toggleClass('active');
    }
  });
  $(this).off('click','.sad_dodaj');
  $(this).on('click','.sad_dodaj',function(){

    main_dane = {
      '_nazwa' : $('.sad_dodaj_nowy_dane .sad_nazwa').val()
      ,'_ulica' : $('.sad_dodaj_nowy_dane .sad_ulica').val()
      ,'_miasto' : $('.sad_dodaj_nowy_dane .sad_miasto').val()
      ,'_kod_pocztowy' : $('.sad_dodaj_nowy_dane .sad_kod_pocztowy').val()
      ,'_wojewodztwo_id' : $('.sad_dodaj_nowy_dane .sad_wojewodztwo').attr('value')
      ,'_typ_id' : $('.sad_dodaj_nowy_dane .sad_typ').attr('value')
      ,'_wojewodztwo_nazwa' : $('.sad_dodaj_nowy_dane .sad_wojewodztwo').text()
      ,'_typ_nazwa' : $('.sad_dodaj_nowy_dane .sad_typ').text()

    };
    var sadPopUp = false;
    var klasaRodzic = 'dane_sadu';
    if($(this).hasClass('sad_dodaj_pop_up')){
      klasaRodzic = 'sad_dodaj_nowy_dane';
      sadPopUp = true;
    }
    sad.sadDodaj(main_dane, sadPopUp, klasaRodzic);
  });

  $(this).off('click','.wokanda_nazwa_miasto_opcja');
  $(this).on('click','.wokanda_nazwa_miasto_opcja',function(){
    var x = $(this).data('wartosc');
    $('#wokanda_nazwa').attr("value", x);
  });

  $(this).off('click','.wokanda_zapisz');
  $(this).on('click','.wokanda_zapisz',function(){
    var otworz_okno_edycji = false;
    if($(this).hasClass('wokanda_dodaj_nowa')){
      otworz_okno_edycji = true;
    }
    wokanda_zapisz_funkcje(otworz_okno_edycji, $(this).data('parent_class'));
  });

  $(this).off('click','.wyszukaj_klienta');
  $(this).on('click','.wyszukaj_klienta',function(){
    wyszukaj_klienta_modal($(this));
  });
  $(this).off('click','.wokanda_edytuj');
  $(this).on('click', '.wokanda_edytuj', function(){
    var id = $(this).data('element_id');
    var tab = $('.tab-pane.active').attr('id');
    wokanda.wokandaEdytujWidok(id, tab, 'wokanda_szczegoly');
  });



  $(this).off('click','.dodaj_klienta_do_wokandy');
  $(this).on('click','.dodaj_klienta_do_wokandy',function(){
    $('#popUp2').modal('hide');

    $('.klient_imie').val($(this).data('imie_klienta'));
    $('.klient_imie').attr('value',$(this).data('imie_klienta'));

    $('.klient_nazwisko').val($(this).data('nazwisko_klienta'));
    $('.klient_nazwisko').attr('value',$(this).data('nazwisko_klienta'));

    $('.klient_nr_sprawy').val($(this).data('numer_sprawy'));
    $('.klient_nr_sprawy').attr('value',$(this).data('numer_sprawy'));

    $('.prawnik_prowadzacy_sprawe').val($(this).data('prawnik_prowadzacy'));
    $('.prawnik_prowadzacy_sprawe').attr('value',$(this).data('prawnik_prowadzacy'));

    $('.prawnik_prowadzacy_sprawe_email').val($(this).data('prawnik_prowadzacy_email'));
    $('.prawnik_prowadzacy_sprawe_email').attr('value',$(this).data('prawnik_prowadzacy_email'));

    $('.druga_strona').val($(this).data('druga_strona'));
    $('.druga_strona').attr('value',$(this).data('druga_strona'));

    $('.pełnomocnik_glowny').val($(this).data('pelnomocnik_glowny'));
    $('.pełnomocnik_glowny').attr('value',$(this).data('pelnomocnik_glowny'));

    $('.pelnomocnik_substytucyjny_kairp').val($(this).data('pelnomocnik_substytucyjny'));
    $('.pelnomocnik_substytucyjny_kairp').attr('value',$(this).data('pelnomocnik_substytucyjny'));

    $('.wps').val($(this).data('wps'));
    $('.wps').attr('value',$(this).data('wps'));

    $('.wpz').val($(this).data('wpz'));
    $('.wpz').attr('value',$(this).data('wpz'));

    $('.sprawa_pce_id').val($(this).data('id'));
    $('.sprawa_pce_id').attr('value',$(this).data('id'));

    $('.wokanda_sprawa_id_glowna').data('element_id','');
    $('.wokanda_sprawa_id_glowna').attr('data-element_id','');

    $('.typ_umowy_id').attr('value',$(this).data('typ_umowy'));
    var typ_umowy_nazwa = 'Inne';

    if($(this).data('typ_umowy') === 1){
      typ_umowy_nazwa = 'Optima';
    }

    if($(this).data('typ_umowy') === 2){
      typ_umowy_nazwa = 'Maxima';
    }

    if($(this).data('typ_umowy') === 3){
      typ_umowy_nazwa = 'Promedica';
    }

    $('.typ_umowy_id').text(typ_umowy_nazwa);

    substytut_sprawdz_ostatni($(this).data('numer_sprawy'));

    przeladujFunkcjeWidoku();

  });

  $(this).off('click','.dodaj_klienta_powiazany_do_wokandy');
  $(this).on('click','.dodaj_klienta_powiazany_do_wokandy',function(){
    $(this).addClass('klient_dodany');
    $(this).removeClass('dodaj_klienta_powiazany_do_wokandy');

    var liczba_spraw_powiazanych = parseInt($('.lista_spraw_powiazanych_dodanych').data('liczba_spraw_powiazanych'));
    $('.lista_spraw_powiazanych_dodanych').data('liczba_spraw_powiazanych',(liczba_spraw_powiazanych + 1));
    $('.lista_spraw_powiazanych_dodanych').attr('data-liczba_spraw_powiazanych',(liczba_spraw_powiazanych + 1));

    main_dane = {
      'zadanie' : 'dodaj'
      ,'numer_sprawy' : $(this).data('numer_sprawy')
      ,'imie_klienta' : $(this).data('imie_klienta')
      ,'nazwisko_klienta' : $(this).data('nazwisko_klienta')
      ,'prawnik_prowadzacy' : $(this).data('prawnik_prowadzacy')
      ,'prawnik_prowadzacy_email' : $(this).data('prawnik_prowadzacy_email')
      ,'druga_strona' : $(this).data('druga_strona')
      ,'wps' : $(this).data('wps')
      ,'pelnomocnik_glowny' : $(this).data('pelnomocnik_glowny')
      ,'pelnomocnik_substytucyjny' : $(this).data('pelnomocnik_substytucyjny')
      ,'id' : $(this).data('id')
      ,'sprawa_powiazana_id' : '0'
    };

    var sprawa_powiazana_id = wokanda.wokandaSprawaPowiazanaDodajUsun(main_dane);
    var td1 = '<td class="col-md-2">'+$(this).data('numer_sprawy')+'</td>';
    var td2 = '<td class="col-md-3">'+$(this).data('imie_klienta')+' '+$(this).data('nazwisko_klienta')+'</td>';
    var td3 = '<td class="col-md-3">'+$(this).data('prawnik_prowadzacy')+'</td>';
    //var td3 = '<td class="col-md-3">'+$(this).data('prawnik_prowadzacy_email')+'</td>';
    var td4 = '<td class="col-md-2">'+$(this).data('druga_strona')+'</td>';
    var td5 = '<td class="col-md-1">'+$(this).data('wps')+'</td>';
    var td5a = '<td class="col-md-1"><i data-sprawa_powiazana_id='+sprawa_powiazana_id+' class="usun_klienta_powiazany_do_wokandy fa fa-eraser" aria-hidden="true"></i></td>';
    var td6 = '<td class="ukryj">'+$(this).data('pelnomocnik_glowny')+'</td>';
    var td7 = '<td class="ukryj">'+$(this).data('pelnomocnik_substytucyjny')+'</td>';
    var td8 = '<td class="ukryj">'+$(this).data('id')+'</td>';

    $('.lista_spraw_powiazanych_dodanych').append('<tr data-numer_sprawy="'+$(this).data('numer_sprawy')+'">'+td1+td2+td3+td4+td5+td5a+td6+td7+td8+'</tr>');
    var cost = $('.lista_spraw_powiazanych_dodanych tr').length;
    $('.koszt_na_sprawe').attr('value',($('.koszt_substytuta').val() / (cost+1)));
  });

  $(this).off('click','.usun_klienta_powiazany_do_wokandy');
  $(this).on('click','.usun_klienta_powiazany_do_wokandy',function(){
    var sp_id = $(this).data('sprawa_powiazana_id');

    $(this).parent().parent().slideUp(function(){
      $(this).remove();
      var cost1 = $('.lista_spraw_powiazanych_dodanych tr').length;
      $('.koszt_na_sprawe').attr('value',($('.koszt_substytuta').val() / (cost1+1)));
    });

    main_dane = {
      'zadanie' : 'usun'
      ,'sprawa_powiazana_id' : sp_id
    };

    wokanda.wokandaSprawaPowiazanaDodajUsun(main_dane);
  });

  $(this).off('click','.wokanda_duplikuj');
  $(this).on('click','.wokanda_duplikuj',function(){

    $('.wokanda_duplikuj_wokande_przycisk').popover('hide');

    var wokanda_id = $('#popUpTresc1').find('.element_szczegoly').data('element_id');
    main_dane = {
      'wokanda_id' : wokanda_id
    };
    wokanda.wokandaDuplikujWokande(main_dane);
  });

  $(this).off('click','.wokanda_wyslij_do_pce');
  $(this).on('click','.wokanda_wyslij_do_pce',function(){

    $('.wokanda_kopiuj_wokande_przycisk').popover('hide');
    var czy_zapisano = wokanda_zapisz_funkcje(true, 'widok_edycja_wokandy');
    if(czy_zapisano){
      var sprawa_glowna = $('#sprawa_glowna_tab').find('.klient_nr_sprawy').val();
      var wokanda_id = $('#popUpTresc1').find('.element_szczegoly').data('element_id');

      if(sprawa_glowna == ''){
        powiadomienie('blad', 'Brak sprawy głównej!!!', '');
        $('.wokanda_wyslij_do_pce_przycisk').popover('hide');
        return;
      }
      main_dane = {
        'wokanda_id' : wokanda_id
      };
      wokanda.wokandaWyslijDaneDoPCE(main_dane);
    }
  });

  $(this).off('click','.wokanda_usun');
  $(this).on('click','.wokanda_usun',function(){
    $('#popUp1').modal('hide');
    var id = $('.element_szczegoly').data('element_id');
    main.mainUsunPrzywrocElement(id,'wokanda','usun', false);
    $('.tabela_lista_wokand_filtruj [data-element_id="'+id+'"]').remove();
    $('#aktywni [data-element_id="'+id+'"]').remove();
  });

  $(this).off('click','.wokanda_przywroc');
  $(this).on('click','.wokanda_przywroc',function(){
    $('#popUp1').modal('hide');
    var id = $('.element_szczegoly').data('element_id');
    main.mainUsunPrzywrocElement(id,'wokanda','przywroc');
  });

  $(this).off('click','.zaznaczOdznaczEtapWokandy');
  $(this).on('click','.zaznaczOdznaczEtapWokandy',function(){
    $(this).toggleClass('zaznaczonyEtapWokandy');
  });
  $(this).off('click','.zaznaczOdznaczEtap2Wokandy');
  $(this).on('click','.zaznaczOdznaczEtap2Wokandy',function(){
    $(this).toggleClass('zaznaczonyEtap2Wokandy');
  });
  $(this).off('click','.zaznaczOdznaczEtapSprawy');
  $(this).on('click','.zaznaczOdznaczEtapSprawy',function(){
    $(this).toggleClass('zaznaczonyEtapSprawy');
  });

  $(this).off('click','.zaznaczOdznaczRodzajWokandy');
  $(this).on('click','.zaznaczOdznaczRodzajWokandy',function(){
    $(this).toggleClass('zaznaczonyRodzajWokandy');
  });

  $(this).off('click','.wczytaj_dane_slownik_sad');
  $(this).on('click','.wczytaj_dane_slownik_sad',function(){
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

    $('#slownik_sad_id').attr('value',element_id);

  });
  $(this).off('click','.wczytaj_dane_slownik_miasto');
  $(this).on('click','.wczytaj_dane_slownik_miasto',function(e){

    var tabela = $(this).data('tabela');
    var element_id = $(this).data('element_id');
    var data = new FormData();
    data.append('tabela', tabela);
    data.append('element_id', element_id);
    data.append('akcja', 'wczytaj_miasto');
    var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', data);
    odpowiedz = $.parseJSON(odpowiedz);
    $('.miasto_nazwa').val(odpowiedz['miasto_nazwa']);
    $('.miasto_nazwa').attr('value', odpowiedz['miasto_nazwa']);
    $('.miasto_nazwa').attr('data-miasto-id', odpowiedz['miasto_id']);

    $('.wyszukaj_like').popover('hide');

    //$('#slownik_miasto_id').attr('value',element_id);
    e.preventDefault();
  });

  $(this).off('click','.wygenerujWiadomoscDoSubstytuta');
  $(this).on('click','.wygenerujWiadomoscDoSubstytuta',function(){
    wokanda.wygenerujWiadomoscDoSubstytuta($(this));
  });

  $(this).off('click','.wczytaj_dane_substytut');
  $(this).on('click','.wczytaj_dane_substytut',function(){
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
    $('.dane_substytuta').data('element_id',odpowiedz['substytut_id']);

    /*kamyk 2016-11-04*/
    $('.substytut_uprawnienia').val(odpowiedz['uprawnienia']);
    $('.substytut_ulica').val(odpowiedz['ulica']);
    $('.substytut_miasto').val(odpowiedz['miasto']);
    $('.substytut_wojewodztwo').val(odpowiedz['wojewodztwo']);
    /*--------------------------------------------------------*/

    $('.imie_susbstytuta').attr('value', odpowiedz['imie']);
    $('.nazwisko_susbstytuta').attr('value', odpowiedz['nazwisko']);
    $('.koszt_substytuta').attr('value', odpowiedz['koszt_stawiennictwa']);
    $('.dane_substytuta').attr('data-element_id',odpowiedz['substytut_id']);

    /*kamyk 2016-11-04*/
    $('.substytut_uprawnienia').attr('value', odpowiedz['uprawnienia']);
    $('.substytut_ulica').attr('value', odpowiedz['ulica']);
    $('.substytut_miasto').attr('value', odpowiedz['miasto']);
    $('.substytut_wojewodztwo').attr('value', odpowiedz['wojewodztwo']);
    /*--------------------------------------------------------*/

    $('.forma_platnosci_substytut_nazwa').attr('value',odpowiedz['forma_platnosci_id']);
    $('.forma_platnosci_substytut_nazwa').text(odpowiedz['forma_platnosci_nazwa']);
    $('.forma_platnosci_substytut .element_grupa_opcja').removeClass('aktywna');
    $('#substytut_forma_platnosci_'+odpowiedz['forma_platnosci_id']).addClass('aktywna');
    $('.wyszukaj_like').popover('hide');

    /*kamyk 2016-11-18*/
    if(odpowiedz['czy_votum'] == '1'){
      $('.czy_votum_s').removeClass('fa-square-o');
      $('.czy_votum_s').addClass('fa-check-square-o');
    }else{
      $('.czy_votum_s').addClass('fa-square-o');
      $('.czy_votum_s').removeClass('fa-check-square-o');
    }
    $('.emai_substytut').text((odpowiedz['email']) == 'null' ? '' : odpowiedz['email']);
    $('.emai2_substytut').text((odpowiedz['email2']) == 'null' ? '' : odpowiedz['email2']);
    $('.telefon_substytut').text((odpowiedz['telefon']) == 'null' ? '' : odpowiedz['telefon']);
    /*--------------------------------------------------------*/

  });

  $(this).off('click','.wyslijWiadomoscOTerminachDoSubstytuta');
  $(this).on('click','.wyslijWiadomoscOTerminachDoSubstytuta',function(){
    wokanda.wyslijWiadomoscOTerminachDoSubstytuta($(this));
  });

  $(this).off('click','.substytut_usun');
  $(this).on('click','.substytut_usun',function(){
    var id = $('.element_szczegoly').data('element_id');
    main.mainUsunPrzywrocElement(id,'substytut','usun');
  });

  $(this).off('click','.substytut_przywroc');
  $(this).on('click','.substytut_przywroc',function(){
    var id = $('.element_szczegoly').data('element_id');
    main.mainUsunPrzywrocElement(id,'substytut','przywroc');
  });

  $(this).off('click','.dodajSadPopUp');
  $(this).on('click','.dodajSadPopUp',function(){
    wokanda.dodajSadPopUpWidok();
  });

  $(this).off('keyup','.wokanda_filtruj_enter');
  $(this).on('keyup','.wokanda_filtruj_enter',function(e){
    if(e.keyCode === 13){
      var zmienne = {};
      var wokanda_etap = '';
      var wokanda_etap_2 = '';
      var wokanda_etap_sprawy = '';
      var wokanda_rodzaj = '';

      var liczba_prm = $('.fprm').size();

      zmienne['akcja'] = 'wokanda_filtruj';

      if($('.potwierdzony_termin_f').hasClass('zaznaczony')){
        zmienne['potwierdzony_termin'] = ($('.pto_tak').hasClass('zaznaczony')) ? '1' : '0' ;
      }else{
        zmienne['potwierdzony_termin'] = '2';
      }

      if($('.czy_votum').hasClass('zaznaczony')){
        zmienne['substytut_votum'] = ($('.czv_tak').hasClass('zaznaczony')) ? '1' : '0' ;
      }else{
        zmienne['substytut_votum'] = '2';
      }

      if($('.faktura_zrealizowana').hasClass('zaznaczony')){
        zmienne['faktura_zrealizowana'] = ($('.fzv_tak').hasClass('zaznaczony')) ? '1' : '0' ;
      }else{
        zmienne['faktura_zrealizowana'] = '2';
      }
      if($('.koszt_ponosi_votum').hasClass('zaznaczony')){
        zmienne['koszt_ponosi_votum'] = ($('.fzkpv_tak').hasClass('zaznaczony')) ? '1' : '0' ;
      }else{
        zmienne['koszt_ponosi_votum'] = '2';
      }

      for(var i=0;i<liczba_prm;i++){
        if($('.fprm')[i].getAttribute('data-kolumna') == ''){
          alert('Brak wartości "kolumna" w fprm: '+i+'\nklasa: "'+$('.fprm')[i].getAttribute('class')+'"');
          return;
        }else{
          zmienne[$('.fprm')[i].getAttribute('data-kolumna')] = $('.fprm')[i].getAttribute('value');
        }

      }
      zmienne['start'] = $('.fdata_wokanda_od').val();
      zmienne['stop'] = $('.fdata_wokanda_do').val();
      for(var e = 0; e < ($('.zaznaczonyEtapWokandy').size()); e++){
        wokanda_etap = wokanda_etap + ',' +$('.zaznaczonyEtapWokandy')[e].getAttribute('data-element_id');
      }
      for(var e2 = 0; e2 < ($('.zaznaczonyEtap2Wokandy').size()); e2++){
        wokanda_etap_2 = wokanda_etap_2 + ',' +$('.zaznaczonyEtap2Wokandy')[e2].getAttribute('data-element_id');
      }
      for(var s = 0; s < ($('.zaznaczonyEtapSprawy').size()); s++){
        wokanda_etap_sprawy = wokanda_etap_sprawy + ',' +$('.zaznaczonyEtapSprawy')[s].getAttribute('data-element_id');
      }

      zmienne['wokanda_etap'] = wokanda_etap.substr(1);
      zmienne['wokanda_etap_2'] = wokanda_etap_2.substr(1);
      zmienne['wokanda_etap_sprawy'] = wokanda_etap_sprawy.substr(1);

      for(var x = 0; x < ($('.zaznaczonyRodzajWokandy').size()); x++){
        wokanda_rodzaj = wokanda_rodzaj + ',' +$('.zaznaczonyRodzajWokandy')[x].getAttribute('data-element_id');
      }

      zmienne['wokanda_rodzaj'] = wokanda_rodzaj.substr(1);
      wokanda.wokandaFiltruj(zmienne);

      $('.tabela_lista_wokand_filtruj').off('click','.zaznacz_wszystkie_wyniki');
      $('.tabela_lista_wokand_filtruj').on('click','.zaznacz_wszystkie_wyniki',function(){
        if($(this).hasClass('zaznaczony')){
          $('.zaznacz_wynik').addClass('zaznaczony').removeClass('fa-square-o').addClass('fa-check-square-o');
        }else{
          $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
        }
      });

      $('.tabela_lista_wokand_filtruj').off('click','.masowe_dzialania_p');
      $('.tabela_lista_wokand_filtruj').on('click','.masowe_dzialania_p',function(){
        //$(this).popover('show');
      });

      $('.tabela_lista_wokand_filtruj').off('click','.zaznacz_wynik');
      $('.tabela_lista_wokand_filtruj').on('click','.zaznacz_wynik',function(){
        var liczba_zaznaczonych = parseInt($('.zaznacz_wynik.zaznaczony').size());
        var liczba_do_zaznaczenia = parseInt($('.zaznacz_wynik').size());



        if($(this).hasClass('zaznaczony')){
          if((liczba_zaznaczonych) == liczba_do_zaznaczenia){
            $('.zaznacz_wszystkie_wyniki').addClass('zaznaczony').removeClass('fa-square-o').addClass('fa-check-square-o');
          }
        }else{
          if((liczba_zaznaczonych) <= 0){
            $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
          }
          if((liczba_zaznaczonych) < liczba_do_zaznaczenia){
            $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
          }
        }
      });

      $('.masowe_dzialania').off('click','.element_grupa_opcja');
      $('.masowe_dzialania').on('click','.element_grupa_opcja',function(){
        var element_id = $(this).data('element_id');

        if(element_id == '0'){
          $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
          $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value','0');
          $('.masowe_dzialania_p').attr('disabled','disabled');
        }else{
          $('.masowe_dzialania_p').removeAttr('disabled');
        }

      });

      $('.masowe_dzialania').off('click','.masowe_dzialanie_dla_zaznaczonych');
      $('.masowe_dzialania').on('click','.masowe_dzialanie_dla_zaznaczonych',function(){
        var liczba_zaznaczonych = parseInt($('.zaznacz_wynik.zaznaczony').size());

        if(liczba_zaznaczonych == '0'){
          powiadomienie('blad', 'Zaznacz przynajmniej jeden wynik!!!','');
          $('.masowe_dzialania_p').popover('hide');
          return;
        }

        var formData = new FormData();
        if($('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value') == 'generuj_raport'){
          formData.append('akcja', 'wokanda_generuj_raport');
          formData.append('wartosc', '4');

          for (var i = 0; i < liczba_zaznaczonych; i++) {
            formData.append('element_id', $('.zaznacz_wynik.zaznaczony')[i].parentNode.parentNode.getAttribute('data-element_id'));

            var odpowiedz = main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);
            if (i == (liczba_zaznaczonych - 1)) {
              $('.masowe_dzialania_p').popover('hide');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
              $('.masowe_dzialania_p').attr('disabled', 'disabled');
              $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
            }

          }
        }else {

          formData.append('akcja', 'wokanda_aktualizuj_wartosc');
          formData.append('kolumna', $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value'));
          formData.append('wartosc', '1');

          for (var i = 0; i < liczba_zaznaczonych; i++) {
            formData.append('element_id', $('.zaznacz_wynik.zaznaczony')[i].parentNode.parentNode.getAttribute('data-element_id'));

            main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);

            if (i == (liczba_zaznaczonych - 1)) {
              $('.masowe_dzialania_p').popover('hide');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
              $('.masowe_dzialania_p').attr('disabled', 'disabled');
              $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
            }

          }
        }




      });
    }
  });



});

function zakladka_wokandy_administracja(){
  if($('#lista_sadow').hasClass('aktywny')){
    aktywujDataTable('tabela_lista_sadow',1,'asc');

    $('.tabela_lista_sadow').off('click','.sad_edytuj');
    $('.tabela_lista_sadow').on('click','.sad_edytuj',function(){
      var id = $(this).data('element_id');
      var tab = 'aktywni';
      if($('#usunieci').hasClass('active')){
        tab = 'usunieci';
      }
      main.mainEdytujWidokElement(id, tab, 'sad_edytuj');
    });

    $('.element_szczegoly').off('click','.sad_usun');
    $('.element_szczegoly').on('click','.sad_usun',function(){
      var id = $('.element_szczegoly').data('element_id');
      main.mainUsunPrzywrocElement(id,'sad','usun');
    });

    $('.element_szczegoly').off('click','.sad_przywroc');
    $('.element_szczegoly').on('click','.sad_przywroc',function(){
      var id = $('.element_szczegoly').data('element_id');
      main.mainUsunPrzywrocElement(id,'sad','przywroc');
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

  if($('#lista_substytutow').hasClass('aktywny')){
    aktywujDataTable('tabela_lista_substytutow',1,'asc');


    $('.tabela_lista_substytutow').off('click','.substytut_edytuj');
    $('.tabela_lista_substytutow').on('click','.substytut_edytuj',function(){
      var id = $(this).data('element_id');
      var tab = 'aktywni';
      if($('#usunieci').hasClass('active')){
        tab = 'usunieci';
      }
      main.mainEdytujWidokElement(id, tab, 'substytut_edytuj');
    });

    $('.substytut_aktualizuj').click(function(){
      main_dane = {
        '_id' : $('.element_szczegoly').data('element_id')
        ,'_nazwisko' : $('.substytut_nazwisko').val()
        ,'_imie' : $('.substytut_imie').val()
        ,'_uprawnienia' : $('.substytut_uprawnienia_nazwa').attr('value')
        ,'_ulica' : $('.substytut_ulica').val()
        ,'_miasto' : $('.substytut_miasto').val()
        ,'_wojewodztwo_id' : $('.nazwa_woj').attr('value')
        ,'_kod_pocztowy' : $('.substytut_kod_pocztowy').val()
        ,'_koszt_stawiennictwa_domyslny' : $('.substytut_koszt_stawiennictwa_domyslny').val()
        ,'_forma_platnosci_id_domyslna' : $('.forma_platnosci_nazwa').attr('value')
        ,'_email' : $('.email_substytut').val()
        ,'_telefon' : $('.telefon_substytut').val()
        ,'_opis' : $('.opis_substytuta').val()
        ,'_czy_votum' : ($('.votum_substytut').hasClass('zaznaczony')) ? '1' : '0'

      };

      substytut.substytutAktualizuj(main_dane);
    });

    $('.substytut_dodaj').click(function(){
      main_dane = {
        '_nazwisko' : $('.substytut_nazwisko').val()
        ,'_imie' : $('.substytut_imie').val()
        ,'_uprawnienia' : $('.substytut_uprawnienia_nazwa').attr('value')
        ,'_ulica' : $('.substytut_ulica').val()
        ,'_miasto' : $('.substytut_miasto').val()
        ,'_wojewodztwo_id' : $('.nazwa_woj').attr('value')
        ,'_kod_pocztowy' : $('.substytut_kod_pocztowy').val()
        ,'_koszt_stawiennictwa_domyslny' : $('.substytut_koszt_stawiennictwa_domyslny').val()
        ,'_forma_platnosci_id_domyslna' : $('.forma_platnosci_nazwa').attr('value')
        ,'_email' : $('.email_substytut').val()
        ,'_telefon' : $('.telefon_substytut').val()
        ,'_opis' : $('.opis_substytuta').val()
        ,'_czy_votum' : ($('.votum_substytut').hasClass('zaznaczony')) ? '1' : '0'

      };

      substytut.substytutDodaj(main_dane);
    });
  }
}

function zakladka_zarzadzanie_wokandami(){

  $("#data_start").change(function(){
    $('#data_stop').val($(this).val());
  });

  $("#data_stop").change(function(){
    $('#data_start').val($(this).val());
  });

  /*$("#data_start_godzina").change(function(){
    var godzina_tmp = $(this).val();
    godzina_tmp = godzina_tmp.split(':');
    $('#data_stop_godzina').val((parseInt(godzina_tmp[0])+1)+':'+godzina_tmp[1]);
  });*/

  if($('#kalendarz').hasClass('aktywny')){

    if($('.element_szczegoly').size() == 0){
      if($('#kalendarz_tresc').size() != 0){
        aktywuj_kalendarz();
      }
    }
  }

  if($('#dodaj_wokande').hasClass('aktywny') || $('#lista_wokand').hasClass('aktywny') || $('#kalendarz').hasClass('aktywny')){
    wstaw_dane_sadu();
    wczytaj_dane_substytut();
    wokanda_wyslij_dane_do_pce();
    $('#data_start_godzina').on('change', function(){
      var stop = new Date("1/1/1900 " + $('#data_start_godzina').attr('value'));
      $('#data_stop_godzina').val(stop.getHours()+1 + ':' + stop.getMinutes());
    });


  }

  if($('#lista_wokand').hasClass('aktywny')) {

    aktywujDataTable('tabela_lista_wokand', 3, 'asc');
    aktywujDataTable('tabela_lista_wokand_filtruj', 3, 'asc', 10);
    $('#data_start_godzina').on('change', function(){
      var stop = new Date("1/1/1900 " + $('#data_start_godzina').attr('value'));
      $('#data_stop_godzina').val(stop.getHours()+1 + ':' + stop.getMinutes());
    });
    $('.potwierdzony_termin_f').click(function () {
      if ($(this).hasClass('zaznaczony')) {
        $('.potwierdzony_termin_opcje').show();
      } else {
        $('.potwierdzony_termin_opcje').hide();
        $('.potwierdzony_termin_o').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
        $('.pto_nie').addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');
      }
    });

    $('.czy_votum').click(function () {
      if ($(this).hasClass('zaznaczony')) {
        $('.czy_votum_opcje').show();
      } else {
        $('.czy_votum_opcje').hide();
        $('.czy_votum_o').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
        $('.czv_nie').addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');
      }
    });

    $('.faktura_zrealizowana').click(function () {
      if ($(this).hasClass('zaznaczony')) {
        $('.faktura_zrealizowana_opcje').show();
      } else {
        $('.faktura_zrealizowana_opcje').hide();
        $('.faktura_zrealizowana_o').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
        $('.fzv_nie').addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');
      }
    });

    $('.koszt_ponosi_votum').click(function () {
      if ($(this).hasClass('zaznaczony')) {
        $('.koszt_ponosi_votum_opcje').show();
      } else {
        $('.koszt_ponosi_votum_opcje').hide();
        $('.koszt_ponosi_votum_o').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
        $('.fzkpv_nie').addClass('zaznaczony').addClass('fa-check-square-o').removeClass('fa-square-o');
      }
    });

    $('.pto_tak').click(function () {
      $('.pto_nie').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.pto_nie').click(function () {
      $('.pto_tak').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.czv_tak').click(function () {
      $('.czv_nie').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.czv_nie').click(function () {
      $('.czv_tak').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.fzv_tak').click(function () {
      $('.fzv_nie').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.fzv_nie').click(function () {
      $('.fzv_tak').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.fzkpv_tak').click(function () {
      $('.fzkpv_nie').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.fzkpv_nie').click(function () {
      $('.fzkpv_tak').removeClass('zaznaczony').removeClass('fa-check-square-o').addClass('fa-square-o');
    });

    $('.filtruj_wokandy').click(function () {
      var zmienne = {};
      var wokanda_etap = '';
      var wokanda_etap_2 = '';
      var wokanda_etap_sprawy = '';
      var wokanda_rodzaj = '';

      var liczba_prm = $('.fprm').size();

      zmienne['akcja'] = $(this).data('akcja');

      if ($('.potwierdzony_termin_f').hasClass('zaznaczony')) {
        zmienne['potwierdzony_termin'] = ($('.pto_tak').hasClass('zaznaczony')) ? '1' : '0';
      } else {
        zmienne['potwierdzony_termin'] = '2';
      }

      if ($('.czy_votum').hasClass('zaznaczony')) {
        zmienne['substytut_votum'] = ($('.czv_tak').hasClass('zaznaczony')) ? '1' : '0';
      } else {
        zmienne['substytut_votum'] = '2';
      }

      if ($('.faktura_zrealizowana').hasClass('zaznaczony')) {
        zmienne['faktura_zrealizowana'] = ($('.fzv_tak').hasClass('zaznaczony')) ? '1' : '0';
      } else {
        zmienne['faktura_zrealizowana'] = '2';
      }
      if ($('.koszt_ponosi_votum').hasClass('zaznaczony')) {
        zmienne['koszt_ponosi_votum'] = ($('.fzkpv_tak').hasClass('zaznaczony')) ? '1' : '0';
      } else {
        zmienne['koszt_ponosi_votum'] = '2';
      }

      for (var i = 0; i < liczba_prm; i++) {
        if ($('.fprm')[i].getAttribute('data-kolumna') == '') {
          alert('Brak wartości "kolumna" w fprm: ' + i + '\nklasa: "' + $('.fprm')[i].getAttribute('class') + '"');
          return;
        } else {
          zmienne[$('.fprm')[i].getAttribute('data-kolumna')] = $('.fprm')[i].getAttribute('value');
        }
      }

      for (var e = 0; e < ($('.zaznaczonyEtapWokandy').size()); e++) {
        wokanda_etap = wokanda_etap + ',' + $('.zaznaczonyEtapWokandy')[e].getAttribute('data-element_id');
      }
      for (var e2 = 0; e2 < ($('.zaznaczonyEtap2Wokandy').size()); e2++) {
        wokanda_etap_2 = wokanda_etap_2 + ',' + $('.zaznaczonyEtap2Wokandy')[e2].getAttribute('data-element_id');
      }
      for (var s = 0; s < ($('.zaznaczonyEtapSprawy').size()); s++) {
        wokanda_etap_sprawy = wokanda_etap_sprawy + ',' + $('.zaznaczonyEtapSprawy')[s].getAttribute('data-element_id');
      }
      zmienne['start'] = $('.fdata_wokanda_od').val();
      zmienne['stop'] = $('.fdata_wokanda_do').val();

      zmienne['wokanda_etap'] = wokanda_etap.substr(1);
      zmienne['wokanda_etap_2'] = wokanda_etap_2.substr(1);
      zmienne['wokanda_etap_sprawy'] = wokanda_etap_sprawy.substr(1);

      for (var x = 0; x < ($('.zaznaczonyRodzajWokandy').size()); x++) {
        wokanda_rodzaj = wokanda_rodzaj + ',' + $('.zaznaczonyRodzajWokandy')[x].getAttribute('data-element_id');
      }

      zmienne['wokanda_rodzaj'] = wokanda_rodzaj.substr(1);

      wokanda.wokandaFiltruj(zmienne);

      $('.tabela_lista_wokand_filtruj').off('click', '.zaznacz_wszystkie_wyniki');
      $('.tabela_lista_wokand_filtruj').on('click', '.zaznacz_wszystkie_wyniki', function () {
        if ($(this).hasClass('zaznaczony')) {
          $('.zaznacz_wynik').addClass('zaznaczony').removeClass('fa-square-o').addClass('fa-check-square-o');
        } else {
          $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
        }
      });

      $('.tabela_lista_wokand_filtruj').off('click', '.masowe_dzialania_p');
      $('.tabela_lista_wokand_filtruj').on('click', '.masowe_dzialania_p', function () {
        //$(this).popover('show');
      });

      $('.tabela_lista_wokand_filtruj').off('click', '.zaznacz_wynik');
      $('.tabela_lista_wokand_filtruj').on('click', '.zaznacz_wynik', function () {
        $(this).addClass('zaznaczony').removeClass('fa-square-o').addClass('fa-check-square-o');
        var liczba_zaznaczonych = parseInt($('.zaznacz_wynik.zaznaczony').size());
        var liczba_do_zaznaczenia = parseInt($('.zaznacz_wynik').size());

        if ($(this).hasClass('zaznaczony')) {
          if ((liczba_zaznaczonych) == liczba_do_zaznaczenia) {
            $('.zaznacz_wszystkie_wyniki').addClass('zaznaczony').removeClass('fa-square-o').addClass('fa-check-square-o');
          }
        } else {
          if ((liczba_zaznaczonych) <= 0) {
            $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
          }
          if ((liczba_zaznaczonych) < liczba_do_zaznaczenia) {
            $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
          }
        }
      });

      $('.masowe_dzialania').off('click', '.element_grupa_opcja');
      $('.masowe_dzialania').on('click', '.element_grupa_opcja', function () {
        var element_id = $(this).data('element_id');

        if (element_id == '0') {
          $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
          $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
          $('.masowe_dzialania_p').attr('disabled', 'disabled');
        } else {
          $('.masowe_dzialania_p').removeAttr('disabled');
        }
      });

      $('.masowe_dzialania').off('click', '.masowe_dzialanie_dla_zaznaczonych');
      $('.masowe_dzialania').on('click', '.masowe_dzialanie_dla_zaznaczonych', function () {
        var liczba_zaznaczonych = parseInt($('.zaznacz_wynik.zaznaczony').size());

        if (liczba_zaznaczonych == '0') {
          powiadomienie('blad', 'Zaznacz przynajmniej jeden wynik!!!', '');
          $('.masowe_dzialania_p').popover('hide');
          return;
        }
        var formData = new FormData();

        if ($('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value') == 'generuj_raport_dla_finansow') {
          formData.append('akcja', 'wokanda_generuj_raport');
          var elements = '';
          for (var i = 0; i < liczba_zaznaczonych; i++) {
            elements += $('.zaznacz_wynik.zaznaczony')[i].parentNode.parentNode.getAttribute('data-element_id') + ','

            if (i == (liczba_zaznaczonych - 1)) {
              $('.masowe_dzialania_p').popover('hide');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
              $('.masowe_dzialania_p').attr('disabled', 'disabled');
              $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              elements = elements.substring(0, elements.length - 1);
              formData.append('elements', elements);
              formData.append('raport', '5');
              var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport',formData);
              wokanda.generujRaportWidok(formData, 'Generuj raport dla finansów');
              odpowiedz = JSON.parse(odpowiedz);
              var date;
              var d = new Date();
              for (var i = 0; i <= odpowiedz.length; i++) {
                date = odpowiedz[i].dat.split("-");
                d = new Date(date[0], date[1] - 1, date[2]);
                odpowiedz[i].dat = d;
                if (i == odpowiedz.length - 1) {
                  grid5(odpowiedz);
                }
              }
            }
          }
        } else if ($('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value') == 'generuj_raport') {
          formData.append('akcja', 'wokanda_generuj_raport');
          var elements = '';
          for (var i = 0; i < liczba_zaznaczonych; i++) {
            elements += $('.zaznacz_wynik.zaznaczony')[i].parentNode.parentNode.getAttribute('data-element_id') + ','

            if (i == (liczba_zaznaczonych - 1)) {
              $('.masowe_dzialania_p').popover('hide');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
              $('.masowe_dzialania_p').attr('disabled', 'disabled');
              $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              elements = elements.substring(0, elements.length - 1);
              formData.append('elements', elements);
              formData.append('raport', '6');
              odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport',formData);
              wokanda.generujRaportWidok(formData,'Generuj raport');
              odpowiedz = JSON.parse(odpowiedz);
              var date;
              var time;
              var d = new Date();
              for (var i = 0; i <= odpowiedz.length; i++) {
                date = odpowiedz[i].dat.split("-");
                time = odpowiedz[i].godzina.split(":");
                d = new Date(date[0], date[1] - 1, date[2]);
                d.setHours(time[0]);
                d.setMinutes(time[1]);
                odpowiedz[i].dat = d;
                odpowiedz[i].godzina = d;
                if (i == odpowiedz.length - 1) {
                  grid6(odpowiedz);
                }
              }
            }
          }
        }
        {

          formData.append('akcja', 'wokanda_aktualizuj_wartosc');
          formData.append('kolumna', $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value'));
          formData.append('wartosc', '1');

          for (var i = 0; i < liczba_zaznaczonych; i++) {
            formData.append('element_id', $('.zaznacz_wynik.zaznaczony')[i].parentNode.parentNode.getAttribute('data-element_id'));

            main.mainWyslijZadanie('app/moduly/wokandy/ajax/akcje/ajax_aktualizuj', formData);

            if (i == (liczba_zaznaczonych - 1)) {
              $('.masowe_dzialania_p').popover('hide');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').text('Masowe działania');
              $('.masowe_dzialania .element_grupa_opcja_naglowek').attr('value', '0');
              $('.masowe_dzialania_p').attr('disabled', 'disabled');
              $('.zaznacz_wszystkie_wyniki').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
              $('.zaznacz_wynik').removeClass('zaznaczony').addClass('fa-square-o').removeClass('fa-check-square-o');
            }
          }
        }
      });
    });
    /*-----------------------------------------------------------------------------------*/
  }

  if($('#raporty').hasClass('aktywny')) {
    $('.raport1_btn').on('click', function(){
      $('.grid2, .grid3, .grid4').css('display', 'none');
      $('.grid1').css('display', 'block');
      $('.grid1 > .error').empty();
      var formData = new FormData();
      formData.append('raport', '1');
      var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport',formData);
      odpowiedz = JSON.parse(odpowiedz);
      if(odpowiedz.length == 0){
        $('.grid1 > .error').append('<p class="text-center">Brak wyników</p>');
      }else {
        var date;
        var time;
        var d = new Date();
        for (var i = 0; i <= odpowiedz.length; i++) {
          date = odpowiedz[i].dat.split("-");
          time = odpowiedz[i].godzina.split(":");
          d = new Date(date[0], date[1] - 1, date[2]);
          d.setHours(time[0]);
          d.setMinutes(time[1]);
          odpowiedz[i].dat = d;
          odpowiedz[i].godzina = d;
          if (i == odpowiedz.length - 1) {
            grid1(odpowiedz);
          }
        }
      }
    })
    $('.raport2_btn').on('click', function() {
      $('.grid1, .grid3, .grid4').css('display', 'none');
      $('.grid2').css('display', 'block');
      $('.grid2 > .error').empty();
      $('.generuj_raport2_data').on('click', function(){
        var data_raport2 = $('#data_raport2').val();
        formData.delete('raport');
        formData.append('raport', '2');
        formData.append('data', data_raport2);
        odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport', formData);
        odpowiedz = JSON.parse(odpowiedz);
        if(odpowiedz.length == 0){
          $('.grid2 .error').append('<p class="text-center">Brak wyników</p>');
        }else {
          var date;
          var time;
          var d = new Date();
          for (var i = 0; i <= odpowiedz.length; i++) {

            date = odpowiedz[i].dat.split("-");
            time = odpowiedz[i].godzina.split(":");
            d = new Date(date[0], date[1] - 1, date[2]);
            d.setHours(time[0]);
            d.setMinutes(time[1]);
            odpowiedz[i].dat = d;
            odpowiedz[i].godzina = d;

            if (i == odpowiedz.length - 1) {
              grid2(odpowiedz);
            }
          }
        }
      });
    });
    $('.raport3_btn').on('click', function() {
      $('.grid1, .grid2, .grid4').css('display', 'none');
      $('.grid3').css('display', 'block');
      $('.grid3 > .error').empty();
      formData.delete('raport');
      formData.append('raport', '3');
      odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport', formData);

      odpowiedz = JSON.parse(odpowiedz);
      if(odpowiedz.length == 0){
        $('.grid3 > .error').append('<p class="text-center">Brak wyników</p>');
      }else {
        var date;
        var time;
        var d = new Date();
        for (var i = 0; i <= odpowiedz.length; i++) {
          date = odpowiedz[i].dat.split("-");
          time = odpowiedz[i].godzina.split(":");
          d = new Date(date[0], date[1] - 1, date[2]);
          d.setHours(time[0]);
          d.setMinutes(time[1]);
          odpowiedz[i].dat = d;
          odpowiedz[i].godzina = d;
          if (i == odpowiedz.length - 1) {
            grid3(odpowiedz);
          }
        }
      }
    });
    $('.raport4_btn').on('click', function() {
      $('.grid1, .grid2, .grid3').css('display', 'none');
      $('.grid4').css('display', 'block');
      $('.grid4 > .error').empty();
      formData.delete('raport');
      formData.append('raport', '4');
      odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_generuj_raport', formData);
      odpowiedz = JSON.parse(odpowiedz);
      if(odpowiedz.length == 0){
        $('.grid4 > .error').append('<p class="text-center">Brak wyników</p>');
      }else {
        var date;
        var time;
        var d = new Date();
        for (var i = 0; i <= odpowiedz.length; i++) {
          date = odpowiedz[i].dat.split("-");
          time = odpowiedz[i].godzina.split(":");
          d = new Date(date[0], date[1] - 1, date[2]);
          d.setHours(time[0]);
          d.setMinutes(time[1]);
          odpowiedz[i].dat = d;
          odpowiedz[i].godzina = d;
          if (i == odpowiedz.length - 1) {
            grid4(odpowiedz);
          }
        }
      }
    });
  }
}

function aktywuj_kalendarz(){
  require(adres_hosta+'/biblioteki/fullcalendar/fullcalendar.js');
  require(adres_hosta+'/biblioteki/fullcalendar/locale/pl.js');

  formData = new FormData();
  var odpowiedz = zadanieAjax('app/ajax/akcje/ajax_lista_uprawnien', formData);

  var uprawnienia = $.parseJSON(odpowiedz);

  var lista_wokand = wokanda.wokandyLista('kalendarz');

  setTimeout(function(){

    $('#kalendarz_tresc').fullCalendar({
      events: lista_wokand,
      eventLimit: 6,
      lang: 'pl',
      timezone: 'local',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,agendaDay'
      },
      defaultView: 'basicWeek',
      //editable: sprawdz_uprawnienie(uprawnienia[3], 21),
      height: 'auto',
      // droppable: sprawdz_uprawnienie(uprawnienia[3], 21),
      slotDuration: '00:20:00',
      minTime: '08:00:00',
      maxTime: '20:00:00'
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
          wokanda.wokandaEdytujWidok(calEvent.id, 'aktywni', 'wokanda_szczegoly');

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

      },eventRender: function (event, element) {
        element.find('.fc-title').html(event.title);
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

}

function wyszukaj_klienta_modal(_button){

  var akcja_sprawa = _button.data('akcja');
  formData = null;
  odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/widoki/ajax_widok_wyszukaj_dane_pce', formData);
  wyswietlPopUp('Wyszukaj Dane w systemie PCE', odpowiedz, 'modal-lg', 2);
  aktywujDataTable('tabela_lista_klientow', 1,'asc');
  aktualizujWartoscInputTextarea();

  $('.wyszukaj_dane_pce_pola').on('click','.szukaj_danych_w_bazie',function(){
    var formData = new FormData();
    formData.append('akcja', 'klient_pce');
    formData.append('imie', $('.klient_imie_pop').val());
    formData.append('nazwisko', $('.klient_nazwisko_pop').val());
    formData.append('nr_sprawy', $('.klient_nr_sprawy_pop').val());
    formData.append('akcja_sprawa', akcja_sprawa);

    if($('.klient_imie_pop').val() == '' &&
      $('.klient_nazwisko_pop').val() == '' &&
      $('.klient_nr_sprawy_pop').val() == '' ){

      powiadomienie('blad', 'Uzupełnij przynajmniej jedno pole!!!', '');
      return;
    }
    wyswietl_wczytywanie_danych_animacja('wyniki_wyszukiwania');

    var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);

    if(odpowiedz == 'brak_danych'){
      powiadomienie('blad', 'Uzupełnij przynajmniej jedno pole!!!', '');
      ukryj_wczytywanie_danych_animacja();
      return;
    }
    ukryj_wczytywanie_danych_animacja();

    document.getElementById('wyniki_wyszukiwania').innerHTML = odpowiedz ;

    aktywujDataTable('tabela_lista_klientow', 1,'asc');

  });
}

$('.odswiez_sprawe_z_pce').on('click',function(){
  var formData = new FormData();
  formData.append('akcja', 'klient_pce_odswiez');
  formData.append('nr_sprawy', $('.klient_nr_sprawy').val());
  formData.append('akcja_sprawa', 'sprawa_glowna');
  wyswietl_wczytywanie_danych_animacja('wyniki_wyszukiwania');

  var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);
  odpowiedz = jQuery.parseJSON(odpowiedz);
  if(odpowiedz == 'brak_danych'){
    powiadomienie('blad', 'Nie można odświeżyć sprawy', '');
    ukryj_wczytywanie_danych_animacja();
    return;
  }

  ukryj_wczytywanie_danych_animacja();

  $('.klient_imie').val(odpowiedz['imie_klienta']);
  $('.klient_nazwisko').val(odpowiedz['nazwisko_klienta']);
  $('.klient_nr_sprawy').val(odpowiedz['numer_sprawy']);
  $('.prawnik_prowadzacy_sprawe').val(odpowiedz['prawnik_prowadzacy']);
  $('.pełnomocnik_glowny').val(odpowiedz['pelnomocnik_glowny ']);
  $('.pelnomocnik_substytucyjny_kairp').val(odpowiedz['pelnomocnik_substytucyjny']);
  $('.wps').val(odpowiedz['wps']);
  $('.wpz').val(odpowiedz['wpz']);
  $('.typ_umowy_id').attr('value', odpowiedz['typ_umowy']);
  //document.getElementById('wyniki_wyszukiwania').innerHTML = odpowiedz ;

  //aktywujDataTable('tabela_lista_klientow', 1,'asc');

});

function substytut_sprawdz_ostatni(numer_sprawy_tmp){
  var formData = new FormData();
  formData.append('numer_sprawy_pce', numer_sprawy_tmp);
  formData.append('akcja', 'substytut_sprawdz_ostatni');

  var odpowiedz = zadanieAjax('app/moduly/wokandy/ajax/akcje/ajax_wyszukaj', formData);

  odpowiedz = $.parseJSON(odpowiedz);
  if(odpowiedz['substytut_id'] != '0'){
    $('.ds_tresc_ogolna').prepend('<div class="well well-sm margin_b_10 s_ostatni_na_sprawie"><p>Ostatnio na sprawie był: <b>'+odpowiedz['nazwisko']+' '+odpowiedz['imie']+', '+odpowiedz['miasto']+', '+odpowiedz['ulica']+'</b></p><button type="button" data-tabela="substytut" data-element_id="'+odpowiedz['substytut_id']+'" class="btn float_r btn-default btn_wds wczytaj_dane_substytut przycisk_zapisz_zmiany btn-block text-uppercase  ">Wczytaj dane</button><div class="clear_b"></div></div>');

    wczytaj_dane_substytut();

  }
}
function wczytaj_dane_substytut(){

}

function wokanda_zapisz_funkcje(otworz_okno_edycji, _parentClass){
  sprawdz_wymagane_pola(_parentClass);
  if($('.'+_parentClass+' .brak_wartosci').size() != '0'){
    powiadomienie('blad', 'Uzupełnij wymagane pola!!!', '');
    return;
  }
  var zmienne = {};

  var data_start = $('.'+_parentClass+' #data_start').val()+' '+$('.'+_parentClass+' #data_start_godzina').val();
  var data_stop = $('.'+_parentClass+' #data_stop').val()+' '+$('.'+_parentClass+' #data_stop_godzina').val();

  var wokanda_id = $('.'+_parentClass+' .element_szczegoly').data('element_id');
  zmienne['id'] = (wokanda_id == '') ? '0' : wokanda_id ;
  zmienne['start'] = data_start;
  zmienne['stop'] = data_stop;
  zmienne['potwierdzony_termin'] = ($('.'+_parentClass+' .potwierdzony_termin').hasClass('zaznaczony')) ? '1' : '0' ;


  /*SPRAWA*/
  zmienne['sprawa_zgoda_na_substytuta'] = ($('.'+_parentClass+' .sprawa_zgoda_na_substytuta').hasClass('zaznaczony')) ? '1' : '0' ;
  var wokanda_sprawa_id_glowna = $('.'+_parentClass+' .wokanda_sprawa_id_glowna').data('element_id');
  zmienne['wokanda_sprawa_id_glowna'] = (wokanda_sprawa_id_glowna == '') ? '0' : wokanda_sprawa_id_glowna ;

  /*SUBSTYTUT*/
  zmienne['wyslano_dokumenty'] = ($('.'+_parentClass+' .wyslano_dokumenty').hasClass('zaznaczony')) ? '1' : '0' ;
  zmienne['otrzymano_notatke'] = ($('.'+_parentClass+' .otrzymano_notatke').hasClass('zaznaczony')) ? '1' : '0' ;
  zmienne['substytut_id'] = ($('.'+_parentClass+' .dane_substytuta').data('element_id') == '') ? 'null' : $('.'+_parentClass+' .dane_substytuta').data('element_id');
  zmienne['potwierdzony_substytut'] = ($('.'+_parentClass+' .potwierdzony_substytut').hasClass('zaznaczony')) ? '1' : '0' ;
  zmienne['usluga_wykonana'] = ($('.'+_parentClass+' .usluga_wykonana').hasClass('zaznaczony')) ? '1' : '0' ;

  /*kamyk 2016-11-18*/
  zmienne['faktura_wplynela'] = ($('.'+_parentClass+' .faktura_wplynela').hasClass('zaznaczony')) ? '1' : '0' ;
  zmienne['faktura_oplacona'] = ($('.'+_parentClass+' .faktura_oplacona').hasClass('zaznaczony')) ? '1' : '0' ;
  /*----------------------------------------------------------------------------------------------------*/
  /*kamyk 2016-12-01*/
  zmienne['koszt_ponosi_votum'] = ($('.'+_parentClass+' .koszt_ponosi_votum').hasClass('zaznaczony')) ? '1' : '0' ;
  /*----------------------------------------------------------------------------------------------------*/
  /*kamyk 2017-01-02*/
  zmienne['sprawa_karna'] = ($('.'+_parentClass+' .wokanda_sprawa_karna').hasClass('zaznaczony')) ? '1' : '0' ;
  /*----------------------------------------------------------------------------------------------------*/


  var liczba_prm = $('.'+_parentClass+' .prm').size();

  for(var i=0;i<liczba_prm;i++){
    if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == ''){
      alert('Brak wartości "kolumna" w prm: '+i+'\nklasa: "'+$('.'+_parentClass+' .prm')[i].getAttribute('class')+'"');
      return false;
    }else{
      if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'substytut_komentarz')
      {
        zmienne['substytut_komentarz'] = $('.' + _parentClass + ' .prm')[i].getAttribute('value');
        zmienne['substytut_komentarz'] = zmienne['substytut_komentarz'].replace(/"/g, String.fromCharCode(92)+'"');
        zmienne['substytut_komentarz'] = zmienne['substytut_komentarz'].replace(/'/g, String.fromCharCode(92)+"'");
      }else if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'sprawa_pelnomocnik_glowny')
      {
        zmienne['sprawa_pelnomocnik_glowny'] = $('.' + _parentClass + ' .prm')[i].value;
      }else if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'sprawa_wps')
      {
        zmienne['sprawa_wps'] = $('.' + _parentClass + ' .prm')[i].getAttribute('value');
        if(zmienne['sprawa_wps'] == ''){
          zmienne['sprawa_wps'] = '0.00'
        }else {
          zmienne['sprawa_wps'] = zmienne['sprawa_wps'].replace(/,/g, '.');
        }
      }else if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'sprawa_wpz')
      {
        zmienne['sprawa_wpz'] = $('.' + _parentClass + ' .prm')[i].getAttribute('value');
        if(zmienne['sprawa_wpz'] == ''){
          zmienne['sprawa_wpz'] = '0.00'
        }else {
          zmienne['sprawa_wpz'] = zmienne['sprawa_wpz'].replace(/,/g, '.');
        }
      }else if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'substytut_kwota')
      {
        zmienne['substytut_kwota'] = $('.' + _parentClass + ' .prm')[i].getAttribute('value');
        if(zmienne['substytut_kwota'] == ''){
          zmienne['substytut_kwota'] = '0.00'
        }else {
          zmienne['substytut_kwota'] = zmienne['substytut_kwota'].replace(/,/g, '.');
        }
      }else if($('.'+_parentClass+' .prm')[i].getAttribute('data-kolumna') == 'slownik_miasto_id')
      {
        zmienne['slownik_miasto_id'] = $('.' + _parentClass + ' .prm')[i].getAttribute('data-miasto-id');
      }
      else{
        zmienne[$('.' + _parentClass + ' .prm')[i].getAttribute('data-kolumna')] = $('.' + _parentClass + ' .prm')[i].getAttribute('value');

      }
    }
  }
  /*krzysiek 2017-11-24*/
  zmienne['sprawa_trudna'] = ($('.'+_parentClass+' .wokanda_sprawa_trudna').hasClass('zaznaczony')) ? '1' : '0' ;
  /*----------------------------------------------------------------------------------------------------*/


  if(zmienne['slownik_miasto_id'] == ''){
    powiadomienie('blad', 'Wybierz miasto!!!', '');
    $('.'+_parentClass+' #wokanda_miasto button').addClass('brak_wartosci');
    return false;
  }

  if(zmienne['slownik_wokanda_etap_id'] == ''){
    powiadomienie('blad', 'Uzupełnij etap wokandy!!!', '');
    $('.'+_parentClass+' #wokanda_etap button').addClass('brak_wartosci');
    return false;
  }
  if(zmienne['slownik_wokanda_rodzaj_id'] == ''){
    powiadomienie('blad', 'Uzupełnij rodzaj wokandy!!!', '');
    $('.'+_parentClass+' #wokanda_rodzaj button').addClass('brak_wartosci');
    return false;
  }

  if(zmienne['slownik_sad_id'] == ''){
    powiadomienie('blad', 'Wybierz sąd!!!', '');
    $('.'+_parentClass+' .dane_sadu button').addClass('brak_wartosci');
    $('.'+_parentClass+' .dane_sadu input').addClass('brak_wartosci');
    return false;
  }


  if(zmienne['sprawa_pce_numer'] != ''){
    if(zmienne['slownik_wokanda_typ_umowy_id'] == ''){
      powiadomienie('blad', 'Wybierz typ umowy!!!', '');
      $('.'+_parentClass+' .lista_typow_umow_klienta button').addClass('brak_wartosci');
      return false;
    }
  }

  if(zmienne['imie_susbstytuta'] != ''){
    if(zmienne['slownik_substytut_forma_platnosci_id'] == undefined){
      powiadomienie('blad', 'Wybierz forme płatności substytuta!!!', '');
      $('.'+_parentClass+' .forma_platnosci_substytut button').addClass('brak_wartosci');
      return false;
    }
  }

  if(zmienne['faktura_wplynela'] == '1'){
    if(zmienne['faktura_numer'] == ''){
      powiadomienie('blad', 'Uzupełnij numer faktury!!!', '');
      $('.'+_parentClass+' .faktura_numer_substytuta').addClass('brak_wartosci');
      return false;
    }
  }

  if(zmienne['faktura_numer'] != ''){
    zmienne['faktura_wplynela'] = '1';
  }

  wokanda.wokandaZapisz(zmienne, true, otworz_okno_edycji);

  return true;
}

function wokanda_wyslij_dane_do_pce(){

}

function sprawdz_wymagane_pola(_parentClass){
  var liczba_pol = $('.'+_parentClass+' .wymagane').size();
  $('.'+_parentClass+' .brak_wartosci').removeClass('brak_wartosci');
  for(var i=0;i<liczba_pol;i++){
    if($('.'+_parentClass+' .wymagane')[i].getAttribute('value') == ''){
      $('.'+_parentClass+' .wymagane')[i].setAttribute('class',$('.'+_parentClass+' .wymagane')[i].getAttribute('class')+' brak_wartosci ');
    }
  }
}


























