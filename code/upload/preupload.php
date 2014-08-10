<?php
	include("config.inc.php");

	
	$photo_upload_fields = "";
	$counter = 1;
	

 
	// antal falt
	$number_of_fields = 1; 



	if( $_GET['number_of_fields'] )
	$number_of_fields = (int)($_GET['number_of_fields']);

	// hamtar kategori  kategori fran tabell

	$result = mysql_query( "SELECT category_id,category_name FROM gallery_category" );

	while( $row = mysql_fetch_array( $result ) )        //press olika kategoriena
	{
         $category_list .=<<<__HTML_END
	<option value="$row[0]">$row[1]</option>\n
__HTML_END;
    }

	mysql_free_result( $result );	





	while( $counter <= $number_of_fields )  //raknare om fler bilder laddas upp
	{
	   

                                            //bygger uppladningfalt
$photo_upload_fields .=<<<__HTML_END
            <!DOCTYPE html>
            <html>
                    <tr>
                    	<td>
                    	     Ladda upp din bild:
                    	    <input required name=' photo_filename[]' type='file' />
                    	   
                    	</td>
                    </tr>
                    <tr>
                    	<td>
                    		
                            </br>	
                    	     Ange beskrivning och pris:</br>
                    	    <textarea required  name='photo_caption[]' cols='30' rows='1'  ></textarea></br                              ></br>
                    	   
                    	</td>
                    </tr>
            </html>
__HTML_END;
	$counter++;
	}

// Resultat output
echo <<<__HTML_END

<html>
<head>
    <meta charset="utf-8"/>
	<title> upload Photos</title>
	<link rel="stylesheet" href="../stylesheet/stylesheet.css" media="screen">
	<script src="../menu.js"></script>
	 <link rel="stylesheet" type="text/css" href="../menu.css">
</head>
<body>

    <div id="top">
    </div>
    
    <div id="meny">
        <div id="meny2">
        <nav>
            <ul>
                <li><a href="../index.html">Presentation</a></li>
                <li><a href="preupload.php">Sälj</a></li>
                <li><a href="../buy/Products.php">Köp</a></li>
                <li><a href="viewgallery.php">Galleri</a></li>
                <li><a href="../contact.html">Kontakt</a></li>
            </ul>
        </nav>
    </div> 
    </div>
 <div class="form">                                                                             
    <form enctype='multipart/form-data' action='upload.php' method='post' name='upload_form'>
    <table width='90%' border='0' align='center' style='width: 90%;'>
        <tr>
        	<td><p>Välj Kategori:</p>
        		
        		<select name='category'>
        		    
        			$category_list
        		
        		</select>
        	</td>
        </tr>
        <tr>
        	<td>
              
        		
        		<p>&nbsp;</p>
        	</td>
        </tr>

        
        $photo_upload_fields
       
        <tr>
        	<td>
        	        <input  type='submit' name='submit' value='Ladda upp' />
        	</td>
        </tr>
    </table>
</form>
</div>
</body>

</html>
__HTML_END;


  ?>

 