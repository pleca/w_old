<?php
	require_once($_SERVER ['DOCUMENT_ROOT'].'czy_zalogowany.php');
	
	$login = htmlspecialchars($_POST['login']);
	$email = htmlspecialchars($_POST['email']);
	
	$uzytkownik_id = $db->pobierz_wartosci_where('uzytkownik', ' login = "'.$login.'" AND email = "'.$email.'"');
	
	if(is_null($uzytkownik_id)){
		$dane = array(
				0 => 0,
				1 => 'Błędny login lub email!!!'
		);
		echo json_encode($dane);
		return;
	}
	
	$uzytkownik_id = $uzytkownik_id->fetch_object();	
	$aktualna_data = date("Y-m-d H:i:s"); 	
	$link_aktywacyjny = generuj_link_aktywacyjny($uzytkownik_id->login.$uzytkownik_id->email);
	
	$wartosci = array(
			'data_link_aktywacyjny' =>$aktualna_data
			,'link_aktywacyjny' =>$link_aktywacyjny
	);
	$db->aktualizuj_wartosc('uzytkownik', $wartosci, $uzytkownik_id->id);
	
	dodaj_wpis_histori($uzytkownik_id->id, 'uzytkownik_id', 'Link reset hasła', '', $aktualna_data, 'uzytkownik_historia_zmian');
	
	$temat = '[PRZYPOMNIJ HASŁO] KAiRP Wokandy';
	$odbiorca = $uzytkownik_id->email;
	$tresc = '
			
<center>
	<table width="700px" cellpadding="10" style="border:1px solid #CCC; border-left:5px solid #CCC; font-family: Calibri; "  align="center">
		<tbody border="0" align="center" valign="midle">
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle" ></td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle">
						<img src="cid:mojelogo" alt="" />
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle" >UWAGA!!! LINK JEST WAŻNY TYLKO 30 MIN!!!</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle">
						------------------------------------------
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle">
						Aby zresetować hasło <a href="'.adres_strony().'?bilet='.$link_aktywacyjny.'&uzytkownik='.$uzytkownik_id->login.'" target="_blank">kliknij</a> w poniższy link.
					</td>
					<td width="5%">&nbsp;</td>
				</tr>		
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle">
						------------------------------------------
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td  width="90%"align="center" valign="midle" style="color:#C9252C;">
						WIADOMOŚĆ ZOSTAŁA WYGENEROWANA AUTOMATYCZNIE!!!<br/> PROSIMY NA NIĄ NIE ODPOWIADAĆ!!!
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr align="center" valign="midle">
					<td width="5%">&nbsp;</td>
					<td width="90%" align="center" valign="midle" ></td>
					<td width="5%">&nbsp;</td>
				</tr>

		</tbody>
	</table>
</center>			
			';
	
	wyslij_wiadomosc_mail($temat,$odbiorca,$tresc);
	
	$dane = array(
			0 => 1,
			1 => 'Na adres '.$email.' zostały przesłane dalsze instrukcje!!!'
	);
	
	echo json_encode($dane);
	