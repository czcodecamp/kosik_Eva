<?php

require('db_eshop.php');

// DEF FUNKCE PRIDAT

function pridatProdukt($id_produkt, $koupit) {

	$sloupce= [
    'id_produkt' => $id_produkt,
    'ks'  => $koupit,
	'id_user' => '0',
    'id_session'  => session_id(),
	];
	
	$zk=dibi::fetch('SELECT `id_produkt` from [kosik] WHERE id_produkt=%i', $id_produkt, 'AND id_session=%s', session_id());
	
	if ($zk==false) {
	
	dibi::query('INSERT  into [kosik]', $sloupce);
	
	} else {
		
		upravPolozku($id_produkt, $koupit);
	}


}

// VOLANI PRIDANI

if (isset($_GET['produkt']) && isset($_GET['koupit'])) {
	
	pridatProdukt($_GET['produkt'], $_GET['koupit']);
	
	header('Location: kosik.php');
}


// DEF FUNKCE SMAZAT

function smazatPolozku($radek) {
		
		dibi::query('DELETE from [kosik] WHERE `id_produkt`=%i', $radek, 'AND id_session=%s', session_id());
		echo "smazano";
	}

	
// VOLANI SMAZANI

if(isset($_POST['smazat_polozku'])) {
	
	smazatPolozku($_POST['id_produkt']);
	
	header('Location: kosik.php?smazano');
}

// DEF FUNKCE UPRAVY

function upravPolozku($radek, $kusy) {
		
		if($kusy==0) {
			
			smazatPolozku($radek);
			
		} else {
		
		dibi::query('UPDATE [kosik] SET `ks`= %i', $kusy, 'WHERE `id_produkt`=%i', $radek, 'AND id_session=%s', session_id());
		}
	}


// VOLANI UPRAV

if(isset($_POST['ulozit'])) {
	
	upravPolozku($_POST['id_produkt'], $_POST['overeni_ks']);
	
	header('Location: kosik.php?upraveno');
	
	
}


// UPLATNENI KUPONU

if (isset($_GET['kod'])) {
	
		//validace s dtb kuponem
		
		$kupon=dibi::fetchSingle('SELECT `sleva`FROM [slevy] WHERE `typ_slevy`= %s', $_GET['kod']);
		
		if ($kupon) {
			
		//ulozit slevu do session zakaznika
		
			$_SESSION['sleva']=$kupon;
			$_SESSION['kupon']=$_GET['kod'];
			
			header('Location: kosik.php?nacteno');
			
		} else {
			
			$_SESSION['sleva']=null;
			$_SESSION['kupon']=null;
			
			header('Location: kosik.php?neplatne');
		}
}



?>

<!-- HTML START -->


<h1>KOŠÍK</h1>

<form action='kosik.php' method='post'>


<?php if (isset($_GET['upraveno'])) {
				echo 'upraveno';
} elseif (isset($_GET['upraveno'])) {
				echo 'smazano';
}
?>


<table>
	
	<tr>
		<td><b>Nahled</b></td>
		<td><b>Produkt</b></td>
		<td><b>Ks</b></td>
		<td><b>Cena za kus</b></td>
		<td><b>Cena</b></td>
	</tr>

<?php

$polozky=dibi::query('SELECT `kosik`.`id_produkt`, `ks`, `nazev`, `cena` from [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE id_session=%s', session_id());

	foreach ($polozky as $vypis) { ?>
	
		<tr>
			<td><img src='images/<?php echo $vypis->id_produkt;?>.jpg' style="border-style: solid;"></td>
			
			<td><?php echo $vypis->nazev; ?></td>
			
			<td><input type='number' name='overeni_ks' min="0" max="5" value='<?php echo $vypis->ks; ?>' required> 
			<input type="submit" name="ulozit" value="Uložit">
			<input type="submit" name="smazat_polozku" value="Smazat">
			<input type="hidden" name="id_produkt" value="<?php echo $vypis->id_produkt; ?>"></td>
			
			<td><?php echo $vypis->cena; ?> ,- Kč</td>
			<td><?php echo $vypis->cena*$vypis->ks; ?> ,- Kč</td>
		</tr>
		
	<?php	
	}
	?>
	
	</table>
	</form>
	
	
	<br>
	<hr>
	
	<p>Uplatnit slevový kód:</p>
	
		<form>
		
			<input type='text' name='kod' placeholder='Sem napište kód z kuponu' value=''>
			<input type='submit' name='potvrdit_kod' value='Potvrdit'>
		
		</form>
		
		<?php if (isset($_GET['neplatne'])) {
			echo "Neplatný kupon!";
		} elseif (isset($_GET['nacteno'])) {
			echo "Kupon načten!";
		}?>
		
	<br>
	
	<h2>Cena celkem: <?php  
	
	$celkem=dibi::fetchSingle('SELECT  SUM(`cena`*`ks`) from [kosik] JOIN [produkty] ON kosik.id_produkt = produkty.id_produkt WHERE id_session=%s', session_id());

	if ($_SESSION['sleva']) {
		
		$sleva=round($celkem / 100 * $_SESSION['sleva']);
		
		echo ($celkem - $sleva)." ,- Kč (po slevě)";
		
	} else {
	
	echo $celkem.",-Kč";
	
	}
	?>
	
	</h2>
	


	<a href='produkty.php'>
		<button>Zpět</button> 
	</a>

	<a href='objednavka.php' onclick="return confirm('Po potvrzeni objednávky již nebude možné produkty upravovat. Soulasíte s potvrzením objednávky?')">
		<button>Objednat</button> 
	</a>

	
	
	