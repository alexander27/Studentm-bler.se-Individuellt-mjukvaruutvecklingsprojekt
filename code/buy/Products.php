<?php
session_start();

?>


<!DOCTYPE HTML>
<html>
    <head>
    
       <meta charset="UTF-8">
        <title>Köpa möbler</title>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="../stylesheet/stylesheet.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../menu.css">
        <script src="../menu.js"></script>
    </head>
<body>
    <div id="top">
    </div> 
   
    <div id="meny">
    <div id="meny2">
        <nav>
            <ul>
                <li><a href="../index.html">Presentation</a></li>
                <li><a href="../uploaded_file/preupload.php">Sälj</a></li>
                <li><a href="Products.php">Köp</a></li>
                <li><a href="../uploaded_file/viewgallery.php">Galleri</a></li>
                <li><a href="../contact.html" class="active">Kontakt</a></li>
            </ul>
        </nav>
    </div> 
    </div> 


<div class='sectionContainer'>
	<div class='sectionHeader'>Köpa möbler</div>
	<?php 
		// ink produkt o varukorg
		include 'Navigation.php' 
	?>
	
	<div class='sectionContents'>
	
<?php
// förhindra undefined index meddelande

$action = isset($_GET['action']) ? $_GET['action'] : "";

$name = isset($_GET['name']) ? $_GET['name'] : "";
                        //visar vad som lades till + om vara redan finns
if ($action=='add'){



	echo "<div>"  . $name .  " lades till din varukorg.</div>";
  

}
if($action=='exists'){
	echo "<div>" . $name . " finns redan i din varukorg.</div>";
}

require "db.php";


$query = 'SELECT id, name, price, bild FROM products';
$cdresult=mysql_query($query) or die ("Kunde inte hamta data fran tabellen: ".mysql_error());






 
if($cdresult>0){

	echo "<table border='0'>";//start table
   
        // our table heading
        echo "<tr>";
         
            echo "<th class='textAlignLeft'>Produkt namn</th>";
            echo "<th>Pris (kr)</th>";
			echo "<th> Köp</th>";
            echo "<th>Bild</th>";
        echo "</tr>";
 
        while ( $row = mysql_fetch_array ( $cdresult )){
            extract ($row);
        
           
            
            //ny tabellrad per post
            echo "<tr>";
                
                echo "<td>{$name}</td>";
                echo "<td class='textAlignRight'>{$price}</td>";
				echo "<td class='textAlignCenter'>";
				echo "<a href='addcart.php?id={$id}&name={$name}&bild={$bild}'class='customButton'>";
	          
				echo "<td> <img src=pics/{$bild}></a></td>";
					
					echo "</a>";
				echo "</td>";
            echo "</tr>";
            
               
                 
            
            
       
        }
		
    echo "</table>";
}
?>





</body>
</html>