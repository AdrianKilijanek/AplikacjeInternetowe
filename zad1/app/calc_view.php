<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator rat kredytu</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
    <label for="id_kwota">Kwota: </label>
    <input id="id_kwota" type="text" name="kwota" value="<?php echo htmlspecialchars($kwota ?? '', ENT_QUOTES, 'UTF-8'); ?>" /><br />

    <label for="id_lata">Ile lat: </label>
    <input id="id_lata" type="text" name="lata" value="<?php echo htmlspecialchars($lata ?? '', ENT_QUOTES, 'UTF-8'); ?>" /><br />

    <label for="id_oproc">Oprocentowanie (roczne): </label>
    <select id="id_oproc" name="oproc">
        <?php
        $opcje = ['4.23','4.50','6.20','7.37','7.57'];
        foreach ($opcje as $opt) {
            $sel = (isset($oprocentowanie) && $oprocentowanie === $opt) ? ' selected' : '';
            echo '<option value="'.$opt.'"'.$sel.'>'.$opt."%".'</option>';
        }
        ?>
    </select><br />

    <input type="submit" value="Oblicz" />
</form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Rata miesięczna: '.$result.' zł'; ?>
</div>
<?php } ?>

</body>
</html>