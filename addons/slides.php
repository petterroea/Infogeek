<?php
    $query = "SELECT * FROM `" . $tbl_prefix.$tbl_slides . "` WHERE `published` LIKE 'yes';";
    $result = mysql_query($query);
    if(mysql_num_rows($result)==0||$result==false) { echo "Load error :("; } else 
    {
    	echo '<h1>' . mysql_result($result, 0, "title") . '</h1>' . mysql_result($result, 0, "contents") . '<br /><br /><i>Posted by ' . mysql_result($result, 0, "poster") . mysql_result($result, 0, "Timeofpost") . '</i>';
	}
?>