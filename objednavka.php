<?php

require('db_eshop.php');
require('sendmail.php');


if (isset($_GET['name']) && isset($_GET['adresa'])&& isset($_GET['tel'])&& isset($_GET['email'])&& isset($_GET['odber'])) {
	
	
	// zde zacinam tvorit string pro zaverecny potvrzovaci e-mail
	$potvrzeni='Vaše objednávka číslo: ';
	
// CELKOVA CENA

	$celkem=dibi::fetchSingle('SELECT  SUM(`cena`*`ks`) from [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE id_session=%s', session_id());

	if ($_SESSION['sleva']) {
		
		$sleva=round($celkem / 100 * $_SESSION['sleva']);
		
		$cena_nova=($celkem - $sleva);
		
	} else {
	
		$cena_nova=$celkem;
	
	}
	
	$sloupce= [
    'cena_obj' => $cena_nova,
	'adresa' => $_GET['adresa'],
	'jmeno' => $_GET['name'],
	'telefon' => $_GET['tel'],
	'id_user' => '0',
	'email' => $_GET['email'],
	'doprava' => $_GET['odber'],
	];
	
	dibi::query('INSERT into [objednavka]', $sloupce);
	
	// zjisteni ID
	
	$last_id=dibi::fetchSingle('SELECT MAX(`id_objednavka`) FROM [objednavka]');
	
	
	$potvrzeni.=$last_id.' byla v pořádku přijata. Shrnutí:<br>';
	
	// kopirovani polozek z kosiku
	
	$obsah_kosiku=dibi::query('SELECT kosik.`id_produkt`, `nazev`,`ks`, `cena` FROM [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE kosik.`id_session`= %s', session_id());
	
	foreach ($obsah_kosiku as $jednotliv_polozka) {
		
		$sloupce= [
			'id_produkt' => $jednotliv_polozka->id_produkt,
			'id_objednavka' => $last_id,
			'cena' => $jednotliv_polozka->cena,
			'ks' => $jednotliv_polozka->ks,
	];
		
		dibi::query('INSERT into [objednavka_polozka]', $sloupce);
		
		$potvrzeni.= $jednotliv_polozka->nazev.' '.$jednotliv_polozka->ks.' ks<br>';
	}
	
	$potvrzeni.='Celková cena objednávky: '.$cena_nova.' ,- Kč<br> Děkujeme za nákup.';
	
	// smazat kosik, aby se nezobrazovaly stare objednavky
	
	dibi::query('DELETE from [kosik] WHERE id_session = %s', session_id());
	
			$_SESSION['sleva']=null;
			$_SESSION['kupon']=null;
			
			$_SESSION['potvrzeni']=$potvrzeni;
	
		// volam odeslani emailu
			
	email($_GET['email'],$potvrzeni);
	
	header('Location: dik.php');
}

?>

<h1>OBJEDNÁVKA</h1>

<table>
	
	<tr>
		<td><b>Produkt</b></td>
		<td><b>Ks</b></td>
		<td><b>Cena</b></td>
	</tr>
	
	
<?php

$polozky=dibi::query('SELECT `kosik`.`id_produkt`, `ks`, `nazev`, `cena` from [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE id_session = %s', session_id());

	foreach ($polozky as $vypis) { ?>
	
		<tr>
			<td><?php echo $vypis->nazev; ?></td>
			<td><?php echo $vypis->ks;?></td> 
			<td><?php echo $vypis->cena;?></td> 
		</tr>
		
	<?php	
	}
	?>

	
	</table>
	
	<h3>Cena celkem: <?php   
	
		$celkem=dibi::fetchSingle('SELECT  SUM(`cena`*`ks`) from [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE id_session=%s', session_id());

	if ($_SESSION['sleva']) {
		
		$sleva=round($celkem / 100 * $_SESSION['sleva']);
		
		echo ($celkem - $sleva)." ,- Kč (po slevě)";
		
	} else {
	
	echo $celkem.",-Kč";
	
	}
	?>	
			
	</h3>
	
	
	
	
	<form action='objednavka.php'>
	
	<p>Osobní údaje k doručení zboží:</p>
	
			Jméno a příjmení:<br>
			<input type='text' name='name'><br>
			Adresa:<br>
			<input type='text' name='adresa'><br>
			Telefon:<br>
			<input type='text' name='tel'><br>
			E-mail:<br>
			<input type='text' name='email'><br>
			<br>
			<input type="radio" name="odber" value="osobni"> osobní odběr<br>
			<input type="radio" name="odber" value="posta"> poštou (dobírka)<br>
			<br>
			<input type="submit" value="Závazně odeslat">
	</form>
	
	<a href='kosik.php'>
		<button>Zpět</button> 
	</a>