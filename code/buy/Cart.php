<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>buy</title>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="../stylesheet/stylesheet.css" media="screen">
    </head>
<body>

<div class='sectionContainer'>
	<div class='sectionHeader'>Varukorgen</div>
	<?php 
		// inkluderar php fil
		include 'navcart.php' 
	?>
	
	<div class='sectionContents'>
	<?php
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	                                                                //om nagot raderas    
	if($action=='removed'){
		echo "<div>" . $_GET['name'] . " Togs bort från kundvagn.</div>";
	}
	
	if(isset($_SESSION['cart'])){
		$ids = "";
		foreach($_SESSION['cart'] as $id){
			$ids = $ids . $id . ",";
		}
		
		                                                      // tar bort sista komma
		$ids = rtrim($ids, ',');
		
		require "db.php";

$query = "SELECT id, name, price, bild FROM products WHERE id IN ({$ids})";

$cdresult=mysql_query($query);
	


		if($cdresult>0){
			echo "<table border='0'>";                      //bygger tabell
			
				//tabell head
				echo "<tr>";
					echo "<th class='textAlignLeft'>Produkt namn</th>";
					
					echo "<th>Pris (kr)</th>";
					echo "<th>Ta bort</th>";
					echo "<th>Bild</th>";
				echo "</tr>";
				
				                                            // total pris satt till 0
				$totalPrice = 0;
				  while ( $row = mysql_fetch_array ( $cdresult )){
            extract($row);
		
					extract($row);
					
					$totalPrice += $price;                  // plussar alla priser till totalpris
					
					                                        //skapa ny tabellrad per post
					echo "<tr>";
					  echo  "<td>{$name}</td>";
						 
						echo "<td class='textAlignRight'>{$price}</td>";
							
						echo "<td class='textAlignCenter'>";
				echo "<a href='deletecart.php?id={$id}&name={$name}&bild={$bild}'>";
								echo "<img src='images/kryss.png' width='35' height='35' title='Remove from                                          cart' />";
								echo "<td> <img src=pics/{$bild}></a></td>";
							echo "</a>";
						echo "</td>";
					echo "</tr>";
				}
				
				echo "<tr>";
					echo "<th class='textAlignCenter'>Summa total:</th>";
					echo "<th class='textAlignRight'>{$totalPrice} kr</th>";
					echo "<th></th>";
				echo "</tr>";
				
			echo "</table>";
		//	echo "<img src='images/knapp1.gif' title='Buy' />";
		   echo '<a href="../index.html">
		    <img src="images/knapp1.gif" width="150" height="70" border="0" alt="Huset"></a>'; 
		}else{
			echo '<div>Det finns inga produkter i din varukorg!</div>';
		}

	}else{
		echo "<div> Det finns inga varor i din kundvagn en</div>";
	}
	?>
	</div>
</div>
</body>
</html>