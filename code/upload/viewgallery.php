<?php
	
	    
	
	    
	
	include("config.inc.php");

	// initialization
	$result_array = array();
	$counter = 0;

	$cid = (int)($_GET['cid']);
	$pid = (int)($_GET['pid']);

	                             // hamtar kategori

	if( empty($cid) && empty($pid) )
	{
		$number_of_categories_in_row = 2;      // tva i rad  

		$result = mysql_query( "SELECT c.category_id,c.category_name,COUNT(photo_id)
						FROM gallery_category as c
						LEFT JOIN gallery_photos as p ON p.photo_category = c.category_id
						GROUP BY c.category_id" );
		while( $row = mysql_fetch_array( $result ) )
		{
			
			$result_array[] = "<a href='viewgallery.php?cid=".$row[0]."'>".$row[1]."</a> "."(".$row[2].")";
			
		
	
		}
		
		
	
		
		
	mysql_free_result( $result );	

		$result_final = "<tr>\n";               // raknar upp till bestammt antal i en rad (2)

		foreach($result_array as $category_link)
		{
			if($counter == $number_of_categories_in_row)
			{	
				$counter = 1;
				$result_final .= "\n</tr>\n<tr>\n";
			}
		else
			$counter++;

			$result_final .= "\t<td>".$category_link."</td>\n";
		}

		if($counter)
		{
			if($number_of_categories_in_row-$counter)
			$result_final .= "\t<td colspan='".($number_of_categories_in_row-$counter)."'>&nbsp;</td>\n";

			$result_final .= "</tr>";
		}
	}











	// Thumbnail Listing

	else if( $cid && empty( $pid ) )
	{
		$number_of_thumbs_in_row = 4;

		$result = mysql_query( "SELECT photo_id,photo_caption,photo_filename FROM gallery_photos WHERE photo_category='".addslashes($cid)."'" );
		$nr = mysql_num_rows( $result );

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td> Denna kategori är tom</br></br> <a href='viewgallery.php'>
			Gå tillbaka</a &gt; </td></tr>\n";
			
			                 
			                
		}
		else
		{
			while( $row = mysql_fetch_array( $result ) )
			{
				$result_array[] = "<a href='viewgallery.php?cid=$cid&pid=".$row[0].
				"'><img src='".$images_dir."/tb_".$row[2]."' border='0' alt='".$row[1]."' /></a>";
			}
			mysql_free_result( $result );	

			$result_final = "<tr>\n";
	
			foreach($result_array as $thumbnail_link)
			{
				if($counter == $number_of_thumbs_in_row)
				{	
					$counter = 1;
					$result_final .= "\n</tr>\n<tr>\n";
				}
				else
				$counter++;

				$result_final .= "\t<td>".$thumbnail_link."</td>\n";
			}
	
			if($counter)
			{
				if($number_of_photos_in_row-$counter)
			$result_final .= "\t<td colspan='".($number_of_photos_in_row-$counter)."'>&nbsp;</td>\n";

				$result_final .= "</tr>";
			}
		}
	}

	// Full Size View of Photo
	else if( $pid )
	{
		$result = mysql_query( "SELECT photo_caption,photo_filename FROM gallery_photos WHERE photo_id='".addslashes($pid)."'" );
		list($photo_caption, $photo_filename) = mysql_fetch_array( $result );
		$nr = mysql_num_rows( $result );
		mysql_free_result( $result );	

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td>Inget photo hittades</td></tr>\n";
		}
		else
		{
			$result = mysql_query( "SELECT category_name FROM gallery_category WHERE category_id='".addslashes($cid)."'" );
			list($category_name) = mysql_fetch_array( $result );
			mysql_free_result( $result );	

			$result_final .= "<tr>\n\t<td>
						<a href='viewgallery.php'>Till Kategori</a> &gt; 
						<a href='viewgallery.php?cid=$cid'>Till $category_name</a></td>\n</tr>\n";

			$result_final .= "<tr>\n\t<td align='center'>
					<br />
					<img src='".$images_dir."/".$photo_filename."' border='0', height='350' width='350' alt='".$photo_caption."' />
					<br />
					$photo_caption
					</td>
					</tr>";
	
		}
		
	}




// Final Output
echo "

<html>
    <head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' href='../stylesheet/stylesheet.css' media='screen'>
    	<script src='../menu.js'></script>
    	<link rel='stylesheet' type='text/css' href='../menu.css'>
    	<title>Gallery View</title>
    	
    </head>
    
        <top>
            <div id='top'></div>
        </top>
        <nav>
             <div id='meny'>
    <div id='meny2'>
        <nav>
            <ul>
                <li><a href='../index.html'>Presentation</a></li>
                <li><a href='preupload.php'>Sälj</a></li>
                <li><a href='../buy/Products.php'>Köp</a></li>
                <li><a href='viewgallery.php'>Galleri</a></li>
                <li><a href='../contact.html'>Kontakt</a></li>
            </ul>
        </nav>
    </div> 
    </div> 
        </nav>
    <body>
     <div id='textblock'>
     
            
            <form id='lankg'>
                <table width='100%' border='0' align='center' style='width: 100%;'>
                    <div class='galleri'
                       
                        $result_final  
                        
                    </div>
                </table>
            <form>
            
    </div></body>
</html>

"

?>
