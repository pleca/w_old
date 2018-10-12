<?php
/**
 * Created by PhpStorm.
 * User: szczepaniak
 * Date: 18.07.2017
 * Time: 13:12
 */
class Report
{
    private $date;
    private $time;
    private $court;
    private $city;
    private $room;
    private $signature;
    private $clientData;
    private $lawyer;

    function __construct($date, $time, $court, $city, $room, $signature, $clientData, $lawyer){
        $this->date = $date;
        $this->time = $time;
        $this->court = $court;
        $this->city = $city;
        $this->room = $room;
        $this->signature = $signature;
        $this->clientData = $clientData;
        $this->lawyer = $lawyer;
    }

    function __get($name){
        return $this->$name;
    }

    function __set($name, $value){
        $this->$name = $value;
    }

}
class Substitue{
    private $id = 0;
    private $name = '';
    private $mail = '';
    private $reports = array();

    function __construct($id, $name, $mail)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
    }

    function __get($name){
        if($name != 'reports') {
            return $this->$name;
        }
    }

    function __set($name, $value){
        if($name != 'reports'){
            $this->$name = $value;
        }
    }
    function addReport($report)
    {
        array_push($this->reports, $report);
    }

    function getReports()
    {
        $style = 'style = "border: 1px solid #ccc;  padding: 10px;"';
        echo '<table cellspacing="0">';
            echo '<tr bgcolor="#cec4c4">';
                echo '<td '.$style.'>';
                    echo 'Data';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Godzina rozpoczęcia';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Sąd';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Miasto';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Sala';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Sygnatura akt';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Nazwisko i imię klienta';
                echo '</td>';
                echo '<td '.$style.'>';
                    echo 'Osoba prowadząca';
                echo '</td>';
            echo '</tr>';
        foreach ($this->reports as $report) {
            echo '<tr>';
                echo '<td '.$style.'>';
                    echo $report->__get('date');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('time');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('court');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('city');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('room');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('signature');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('clientData');
                echo '</td>';
                echo '<td '.$style.'>';
                    echo $report->__get('lawyer');
                echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    function getReportsHTML()
    {
        $style = 'style = "border: 1px solid #ccc;  padding: 10px;"';
        $result = '<table cellspacing="0"><tr bgcolor="#cec4c4">
                    <td '.$style.'>Data</td>
                    <td '.$style.'>Godzina rozpoczęcia</td>
                    <td '.$style.'>Sąd</td>
                    <td '.$style.'>Miasto</td>
                    <td '.$style.'>Sala</td>
                    <td '.$style.'>Sygnatura akt</td>
                    <td '.$style.'>Nazwisko i imię klienta</td>
                    <td '.$style.'>Osoba prowadząca</td></tr>';
        foreach ($this->reports as $report) {
            $result = $result. '<tr><td '.$style.'>';
            $result = $result.  $report->__get('date');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('time');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('court');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('city');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('room');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('signature');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('clientData');
            $result = $result. '</td><td '.$style.'>';
            $result = $result.  $report->__get('lawyer');
            $result = $result. '</td></tr>';
        }

        $result = $result. '</table>';
        return $result;
    }

    function getSubtitute()
    {
        if(!empty($this->reports)) {
            echo '<br/>';
            echo 'Nazwa substytuta: ' . $this->name . '<br/>';
            echo 'Mail substututa:' . $this->mail . '<br/>';
            $this->getReports();
        }
    }

    function getSubtituteHTML()
    {
        $result = '';
        if(!empty($this->reports)) {
            $result = $result.  'Nazwa substytuta: ' . $this->name . '<br/>';
            $result = $result.  'Mail substututa:' . $this->mail . '<br/>';
            $result = $result. $this->getReportsHTML();
        }

        return $result;
    }
}

$subtitutesIds = '-1';

if(isset($_POST["substituteIds"]))
{
    $subtitutesIds = $_POST["substituteIds"];
}

$substitutes = array();

define('DB_NAME', 'wokandy');
define('DB_USER', 'wokandy');
define('DB_PASSWORD', 'CVXUJGaJwzeVAyC9');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');

try {
    $db = new PDO('mysql:host='.DB_HOST.'; dbname = '.DB_NAME.'; charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

    $stmt = $db->prepare("call wokandy.substytut_pobierz_kontakt_na_podstawie_ids(?);");
    $stmt->bindParam(1, $subtitutesIds, PDO::PARAM_STR, 8000);
    $stmt-> execute();
    $results = $stmt->fetchAll();

    foreach ($results as $result) {
        array_push($substitutes, new Substitue($result['id'], $result['nazwa'], $result['email']));
    }

    foreach($substitutes as $substitute){
        $stmt = $db->prepare("call wokandy.substytut_pobranie_terminow(?);");
        $stmt->bindParam(1, $substitute->__get('id'), PDO::PARAM_INT);
        $stmt-> execute();

        $results = $stmt->fetchAll();

        foreach ($results as $result) {
            $report = new Report($result['DataWokandy'],$result['GodzinaWokandy'], $result['Sad'], $result['Miasto'],
                $result['Sala'], $result['SygnaturaAkt'], $result['Klient'], $result['OsobaProwadzaca']);
            $substitute->addReport($report);
        }
    }

    $db = null;
} catch (PDOException $e)
{
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

require './biblioteki/phpmailer/autoload.php';
foreach($substitutes as $substitute) {
  //  $substitute->getSubtitute();
    $mailtosend = new PHPMailer();
    $mailtosend->IsSMTP();
    $mailtosend->Host = "zimbra.votum-sa.pl";
    $mailtosend->SMTPAuth = true;
    $mailtosend->Username = "automat@votum-sa.pl";
    $mailtosend->Password = "BW8Y2VmX";
    $mailtosend->SMTPSecure = 'tls';
    $mailtosend->Port = 587;
    $mailtosend->CharSet= "utf-8";
    $mailtosend->From = "automat@votum-sa.pl";
    $mailtosend->FromName ="Wokanda";
    $mailtosend->addAddress('patryk@votum-sa.pl', 'Patryk Szczepaniak');
    $mailtosend->Subject = "Terminy zbliżających się wokand";
    $mailtosend->isHTML(true);
    $mailtosend->Body = $substitute->getSubtituteHTML();
    if(!$mailtosend->send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mailtosend->ErrorInfo;
    } else {
        echo 'Message has been sent.';
    }
}

