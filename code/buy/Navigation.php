<?php
// kollar session "varukorg" var satt, räkna dem, annars sätta den till 0
$cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;


?>

<div class='navigation'>
	
	<a href='Products.php'</a>
	<a href='Cart.php'>Gå till Varukorgen <?php echo "({$cartItemCount})"; ?></a>
</div>
