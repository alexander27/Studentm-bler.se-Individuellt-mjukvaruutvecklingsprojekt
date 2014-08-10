<?php>
$con=mysql_connect('nalaka.se.mysql', 'nalaka_se', 'blommprinsen28'); 
mysql_select_db('nalaka_se', $con);mysql_set_charset('utf8',$con);  
if (!$con) {
    die('Could not connect: ' . mysql_error());

  
}else
?>