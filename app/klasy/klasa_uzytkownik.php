<?php

class uzytkownik{
	private $_id;
	private $_imie;
	private $_nazwisko;
	private $_login;
	private $_zalogowany;
	private $_uzytkownik_grupy_id;
	private $_db;
	private $_lista_przyznanych_modulow;
	private $_lista_przyznanych_stron;
	private $_lista_przyznanych_zakladek;
	private $_lista_przyznanych_uprawnien;
	
	function __construct($db, $login){
		$this->_db = $db;
		$this->_login = $login;		
		
		$this->ustawZmienne();
	}
	
	private function pobierzDaneZBazy(){
		$uzytkownik_z_bazy_tmp = $this->_db->pobierz_wiersz('uzytkownik', 'login', $this->_login);
		
		return $uzytkownik_z_bazy_tmp;
				
	}
	
	private function ustawZmienne(){
		$uzytkownikdane_tmp = $this->pobierzDaneZBazy();
							
		$this->_id = $uzytkownikdane_tmp->id;
		$this->_imie = $uzytkownikdane_tmp->imie;
		$this->_nazwisko = $uzytkownikdane_tmp->nazwisko;
		$this->_login = $uzytkownikdane_tmp->login;
		$this->_uzytkownik_grupy_id = $uzytkownikdane_tmp->uzytkownik_grupy_id;
		$this->_zalogowany = true;
		
		$this->_lista_przyznanych_modulow = $this->pobierz_liste_uprawnien('uzytkownik_uprawnienia_moduly_id', 'uzytkownik_id_uzytkownik_uprawnienia_moduly_id', $this->_id);
		$this->_lista_przyznanych_stron = $this->pobierz_liste_uprawnien('uzytkownik_uprawnienia_strony_id', 'uzytkownik_id_uzytkownik_uprawnienia_strony_id', $this->_id);
		$this->_lista_przyznanych_zakladek = $this->pobierz_liste_uprawnien('uzytkownik_uprawnienia_zakladki_id', 'uzytkownik_id_uzytkownik_uprawnienia_zakladki_id', $this->_id);
		$this->_lista_przyznanych_uprawnien = $this->pobierz_liste_uprawnien('uzytkownik_uprawnienia_id', 'uzytkownik_id_uzytkownik_uprawnienia_id', $this->_id);
		
		
	}
	
	private function pobierz_liste_uprawnien($wartosc_ktmp, $tabela_ktmp, $id_ktmp){
	
	$lista = array();
	$lista_tmp = $this->_db->pobierz_konkretne_wartosci_where($wartosc_ktmp, $tabela_ktmp, 'uzytkownik_id', $id_ktmp);
		
	if(!is_null($lista_tmp)){
		$i=0;
		while($poj_lista_tmp = $lista_tmp->fetch_object()){
			$lista[$i] = $poj_lista_tmp->$wartosc_ktmp;
			$i++;
		}
	}
	
	return $lista;
}
			
	public function __sleep(){
		return array(
					'_id'
					,'_imie'
					,'_nazwisko'
					,'_login'
					,'_zalogowany'
					,'_uzytkownik_grupy_id'
					,'_lista_przyznanych_modulow'
					,'_lista_przyznanych_stron'
					,'_lista_przyznanych_zakladek'
					,'_lista_przyznanych_uprawnien'
					,'_db'					
				);
	}
	
	public function __wakeup(){
		
	}
	
	public function __get($nazwa) {
        return $this->$nazwa;
    }

    public function __set($nazwa, $wartosc) {
        $this->$nazwa = $wartosc;
    }
		
}