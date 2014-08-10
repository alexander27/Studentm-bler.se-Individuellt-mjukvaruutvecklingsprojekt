<?php
	include("config.inc.php");

	// initialization
	$result_final = "";
	$counter = 0;
    $limit_size= 9999999;
    $url='preupload.php';


 
  if ($_FILES['photo_filename']['size'][$counter] > $limit_size) {
echo <<<__HTML_END

<html>
<head>
	<title>Photos uploaded</title>
	<link rel="stylesheet" href="../stylesheet/stylesheet.css" media="screen">
	<meta charset="utf-8">
</head>
<body>
	    '<meta http-equiv="refresh" content="4; URL=http://www.nalaka.se/uploaded_file/preupload.php"> ';          
	    '<div id ="errorstor">Filen du försöker ladda upp överstiger den tilllåtna maxstorleken </div>'; 
	 

</body>
</html>

__HTML_END;
  
   

   

    }else{
        
   

       
   
    
	// lista pa godkannda filendelser
	$known_photo = array( 
						
					    
						'image/pjpeg' => 'jpg',
						'image/jpeg' => 'jpg',
						'image/gif' => 'gif',
						'image/bmp' => 'bmp',
						'image/x-png' => 'png'
						
                    
					);
	
	// GD Function List
	$gd_function_suffix = array( 
					
					
						'image/pjpeg' => 'JPEG',
						'image/jpeg' => 'JPEG',
						'image/gif' => 'GIF',
						'image/bmp' => 'WBMP',
						'image/x-png' => 'PNG'
						);

	// hamtar array med photo fran preup
	$photos_uploaded = $_FILES['photo_filename'];
    
	// hamtar array med text fran preup
	$photo_caption = $_POST['photo_caption'];
    	 

      

   
    while( $counter <= count($photos_uploaded) ) // om fler bilder laddas upp samtidigt
	{
		if($photos_uploaded['size'][$counter] > 0) //kollar vardet storre an noll
		{
			if(!array_key_exists($photos_uploaded['type'][$counter], $known_photo)) //om fil ar ! fran                                                                                          $known_photo visa fel                                                                                        annars att in i databasen
			{
				$result_final .= "File ".($counter+1)." Är inget photo<br />";
			}
		
			else
			{
				mysql_query( "INSERT INTO gallery_photos(`photo_filename`, `photo_caption`, `photo_category`)                 VALUES('0', '".addslashes($photo_caption[$counter])."', '".addslashes($_POST['category'])."'                 )" );
				
				$new_id = mysql_insert_id();                     // nytt id skapas
				$filetype = $photos_uploaded['type'][$counter];  // ta reda pa filtyp
				$extention = $known_photo[$filetype];
				$filename = $new_id.".".$extention;             //Generera ett nytt namn 

				//uppdate filnamn
				
				mysql_query( "UPDATE gallery_photos SET photo_filename='".addslashes($filename)."' WHERE                     photo_id='".addslashes($new_id)."'" );




                                	
           


				// kopierar bild fran temp 
			          
                			
                copy($photos_uploaded['tmp_name'][$counter],    
                $images_dir . '/' . $filename);   
		
				
		








				// hamtar storlek pa bild.
				$size = getimagesize( $images_dir."/".$filename );
				if($size[0] > $size[1])                                 //om bild bred > stor
				{
					$thumbnail_width = 100;
					$thumbnail_height = (int)(100 * $size[1] / $size[0]);
				}
				else                                                    //om bild bred<stor
				{
					$thumbnail_width = (int)(100 * $size[0] / $size[1]);
					$thumbnail_height = 100;
				}
			
				// Build Thumbnail with GD 1.x.x, you can use the other described methods too
				$function_suffix = $gd_function_suffix[$filetype];       // fa namn suffix
				$function_to_read = "ImageCreateFrom".$function_suffix; //skapa funktionsnamn för 
				                                                        //ImageCreateFromSUFFIX
				$function_to_write = "Image".$function_suffix;          //skapar funktionsnamn för ImageSUFFI

				// laser kallfilen
				$source_handle = $function_to_read ( $images_dir."/".$filename ); 
				
				if($source_handle)
				{
					                                                    /* skapar en tom min-bild
					                                                       anvander  ImageCreateTrueColor for                                                                            att fa sa bra farger pa 
					                                                       min-bilden som mojligt */
				    
				     	$destination_handle = ImageCreateTrueColor( $thumbnail_width, $thumbnail_height );
				
					                                                    // andrar storlek
			      	
			      	    ImageCopyResized( $destination_handle, $source_handle, 0, 0, 0, 0, $thumbnail_width,                         $thumbnail_height, $size[0], $size[1] );
				}

			                                                        // sparar bilden namn tb_sedan filnamn
				$function_to_write( $destination_handle, $images_dir."/tb_".$filename );
				ImageDestroy($destination_handle );
				//

				$result_final .= "<img src='".$images_dir. "/tb_".$filename."' /> Bild ".($counter+1)." 
				lades till <br />";
                
                echo    '<a class="btn" href="viewgallery.php">
                        <div id="container" name="A" href="'.$url.'" class="fancybox">
                        Till Galleri-sidan</div></a></li
                        <input id="my_button" type="button" value="HIDE"';


                
                
                
                
                
                
                
			}
	}
          	$counter++; 
	}
   

 
}
	// Print Result
echo <<<__HTML_END

<html>
<head>
	<title>Photos uploaded</title>
	<link rel="stylesheet" href="../stylesheet/stylesheet.css" media="screen">
	<meta charset="utf-8">
</head>
<body>
	$result_final
	 

</body>
</html>

__HTML_END;
 
?>

