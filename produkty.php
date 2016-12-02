<?php

require('db_eshop.php');

$result = dibi::query('SELECT * FROM `produkty`');

?>
    
<h1>PRODUKTY</h1>	
	
	<table>
	
	<tr>
		<td>NÁHLED</td>
		<td>NÁZEV</td>
		<td>CENA</td>
		<td>PŘIDAT DO KOŠÍKU</td>
	</tr>

<?php

	foreach ($result as $produkt) { ?>
	
	<tr>
		<td><img src='images/<?php echo $produkt->id_produkt;?>.jpg' style="border-style: solid;"></td>
		<td><?php echo $produkt->nazev; ?></td>
		<td><?php echo $produkt->cena; ?></td>
		<td>
			<form action="kosik.php">
			
			
				<input name='produkt' type='hidden' value='<?php echo $produkt->id_produkt;?>'>
				
				<input type="hidden" name="koupit" value="1">
				
				<input type="submit" value=" + ">
			</form>
		</td>
	</tr>
	
	<?php
	} ?>
		
	</table>
	


