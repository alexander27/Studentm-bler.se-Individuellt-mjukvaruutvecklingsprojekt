<?php
session_start();

// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

/* 
 * 
 */
if(!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}

// kollar om produkt ar i varukorg annars lagg till 
if(in_array($id, $_SESSION['cart'])){
	
	header ('Location: Products.php?action=exists&id' . $id . '&name=' . $name);
}

// annas lagger till produkt
else{
	array_push($_SESSION['cart'], $id);
	
	
	header('Location: Products.php?action=add&id' . $id . '&name=' . $name);
}

?>