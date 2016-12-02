<?php

require('db_eshop.php');

?>

<h1>POTVRZENÍ</h1>

<p>Děkujeme za objednávku!</p>

<p>Shrnutí objednávky dorazí i na Váš e-mail. </p>

<?php 
	
	echo $_SESSION['potvrzeni'];
	
?>