<?php
//lank sa att man kan komma tillbaka om man valjer att radera alla vaor i varukorg

$cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;


?>

<div class='navcart'>
	
	<a href='Products.php'>Tillbaka till Produktsidan</a>

</div>