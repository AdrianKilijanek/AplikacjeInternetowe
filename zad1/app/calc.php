<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST['kwota'];
$lata  = $_REQUEST['lata'];
$oprocentowanie = $_REQUEST['oproc'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if (!(isset($kwota) && isset($lata) && isset($oprocentowanie))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ($kwota == '') {
	 $messages [] = 'Nie podano kwoty'; 
}
if ($lata == '')  { 
	$messages [] = 'Nie podano liczby lat'; 
}
if ($oprocentowanie == '' && $oprocentowanie !== '0') {
	$messages [] = 'Nie wybrano oprocentowania'; 
}


//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
    if (!is_numeric($kwota) || floatval($kwota) <= 0) { 
		$messages [] = 'Kwota musi być dodatnią liczbą'; 
	}
    if (!is_numeric($lata)  || intval($lata)  <= 0)   { 
		$messages [] = 'Liczba lat musi być dodatnią liczbą całkowitą'; 
	}
    if (!is_numeric($oprocentowanie) || floatval($oprocentowanie) < 0) { 
		$messages [] = 'Oprocentowanie musi być liczbą nieujemną'; 
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
    $P = floatval($kwota);
    $years = intval($lata);
    $apr = floatval($oprocentowanie);
    $n = $years * 12;
    $r = ($apr / 100.0) / 12.0;
	
	//wykonanie operacji
    if ($n <= 0) {
        $messages [] = 'Okres spłaty musi być dodatni';
    } else {
        if ($r == 0.0) {
            $ratam = $P / $n;
        } else {
            $ratam = $P * $r / (1.0 - pow(1.0 + $r, -$n));
        }
        $result = number_format($ratam, 2, ',', ' ');
    }
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';