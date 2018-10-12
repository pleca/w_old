<?php

class baza_danych{
	
	private $_db;
	 
	function __construct(){
		$this->polaczenie(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	}
	
	function polaczenie($host,$user,$pass,$database){
		$this->_db = new mysqli($host, $user, $pass, $database);
		$this->_db->set_charset("utf8");
		
		if($this->_db->connect_errno > 0){
			die('Błąd połączenia z bazą danych [' . $this->_db->connect_error . ']');
		}
	}

    function polaczeniePDO(){
        return new PDO('mysql:host='.DB_HOST.'; dbname = '.DB_NAME.'; charset='.DB_CHARSET, DB_USER, DB_PASSWORD);
    }
	
	function odswierz_polaczenie(){
		$this->_db->close();
		$this->polaczenie(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	}
	
	function pobierz_wiersz($tabela, $kolumna, $wartosc){
		$this->odswierz_polaczenie();
		//var_dump(' SELECT * FROM '.$tabela.' WHERE '.$kolumna.' = "'.$wartosc.'" ');
		$rezultat = $this->_db->query(' SELECT * FROM '.$tabela.' WHERE '.$kolumna.' = "'.$wartosc.'" ');
		if($rezultat->num_rows !== 0){
			return $rezultat->fetch_object();
		}		
	}
	
	function pobierz_wiersze($tabela, $kolumna, $wartosc){
		$this->odswierz_polaczenie();
		
		$rezultat = $this->_db->query(' SELECT * FROM '.$tabela.' WHERE '.$kolumna.' = "'.$wartosc.'" ');
		if($rezultat->num_rows !== 0){
			return $rezultat;
		}
		return null;
	}
	
	function pobierz_wartosc($wartosc, $tabela, $kolumna, $wartosc_where){
		$this->odswierz_polaczenie();
		
		$rezultat = $this->_db->query(' SELECT '.$wartosc.' FROM '.$tabela.' WHERE '.$kolumna.' = "'.$wartosc_where.'" ');
		if($rezultat->num_rows !== 0){
			return $rezultat->fetch_object();
		}
		return null;
	}
	
	function pobierz_wartosci_where($tabela, $wartosc_where, $order_by = NULL ){	
		$this->odswierz_polaczenie();
		
		$rezultat = $this->_db->query(' SELECT * FROM '.$tabela.' WHERE '.$wartosc_where.' '.$order_by.' ');
		if($rezultat->num_rows !== 0){
			return $rezultat;
		}
		return null;
	}

	function pobierz_ogolne_zapytanie($tabela, $wartosci, $wartosc_where){
		$this->odswierz_polaczenie();
		
		$rezultat = $this->_db->query(' SELECT '.$wartosci.' FROM '.$tabela.' WHERE '.$wartosc_where.' ');
		if($rezultat->num_rows !== 0){
			return $rezultat->fetch_object();
		}
		return null;
	}
	
	function pobierz_konkretne_wartosci_where($wartosc, $tabela, $kolumna_where, $wartosc_where, $order_by = NULL){
		$this->odswierz_polaczenie();
		
		$rezultat = $this->_db->query(' SELECT '.$wartosc.' FROM '.$tabela.' WHERE '.$kolumna_where.' = "'.$wartosc_where.'" '.$order_by.' ');
		if($rezultat->num_rows !== 0){
			return $rezultat;
		}
		return null;
	}
	
	function wstaw_wartosc($tabela, $wartosci){
		$klucze = '';
		$klucze_wartosci = '';
		
		foreach($wartosci as $klucz => $wartosc){
			$klucze .= ','.$klucz;			
			if($wartosc === 'NOW()'){
				$klucze_wartosci .= ','.$wartosc;
			}else{
				$klucze_wartosci .= ',"'.$wartosc.'"';
			}
		}
		
		$klucze = substr($klucze, 1);
		$klucze_wartosci = substr($klucze_wartosci, 1);
		
		$this->_db->query(' INSERT INTO '.$tabela.' ('.$klucze.') VALUES ('.$klucze_wartosci.') ');
		
		return $this->_db->insert_id;
	}
	
	function aktualizuj_wartosc($tabela, $wartosci, $id_tmp){
		$klucze_wartosci = '';
		
		foreach($wartosci as $klucz => $wartosc){
			if($wartosc !== ''){				
				if($wartosc === 'NOW()'){
					$klucze_wartosci .= ','.$klucz.' = '.$wartosc;
				}else if($wartosc === 'null'){
					$klucze_wartosci .= ','.$klucz.' = '.$wartosc;
				}else{
					$klucze_wartosci .= ','.$klucz.' = "'.$wartosc.'"';
				}
				
			}
			
		}

		$klucze_wartosci = substr($klucze_wartosci, 1);
		
		$this->_db->query(' UPDATE '.$tabela.' SET '.$klucze_wartosci.' WHERE id = '.$id_tmp.' ');
	}
	
	function usun_wartosc($tabela, $id_tmp){
		$this->_db->query(' UPDATE '.$tabela.' SET czy_usuniety = 1 WHERE id = '.$id_tmp.' ');
	}
	
	function delete_wartosc($tabela, $wartosc_where){
		$this->_db->query(' DELETE FROM '.$tabela.' WHERE '.$wartosc_where.' ');
	}
	
	function przywroc_wartosc($tabela, $id_tmp){
		$this->_db->query(' UPDATE '.$tabela.' SET czy_usuniety = 0 WHERE id = '.$id_tmp.' ');
	}
	
	function wywolaj_procedure($nazwa_procedury, $wartosci, $parametr_out = NULL){
		$this->odswierz_polaczenie();
		
		$lista_wartosci = '';
		if($wartosci != null) {
            foreach ($wartosci as $wartosc) {
                if ($wartosc === 'null') {
                    $lista_wartosci .= ',' . $wartosc;
                } else {
                    $lista_wartosci .= ',"' . $wartosc . '"';
                }
            }
            if (!is_null($parametr_out)) {
                $parametr_out = ',@parametr_out';
            }

            $lista_wartosci = substr($lista_wartosci, 1);

            if (!is_null($parametr_out)) {
                $this->_db->multi_query(' CALL ' . $nazwa_procedury . '(' . $lista_wartosci . $parametr_out . ')' . ((!is_null($parametr_out)) ? ';SELECT @parametr_out as paramert_out' : '') . ' ');
                $this->_db->next_result();
                $rezultat = $this->_db->store_result();
                if ($rezultat->num_rows !== 0) {
                    $paramert_out = $rezultat->fetch_object();
                    return $paramert_out->paramert_out;
                }
            } else {
                $rezultat = $this->_db->query(' CALL `' . $nazwa_procedury . '`(' . $lista_wartosci . ') ');

                return $rezultat;
            }
        }else{
            $rezultat = $this->_db->query(' CALL `' . $nazwa_procedury . '`() ');
            return $rezultat;
        }

	}
	
	function __sleep(){
		return array('_db');		
	}
	 
	function __wakeup(){
		$this->polaczenie(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	}
		
}