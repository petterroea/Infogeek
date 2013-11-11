<script type="text/JavaScript">
	    function timedRefresh(timeoutPeriod) {
		   setTimeout("location.reload(true);",timeoutPeriod*1000);
	    }
	    function init(){
	        timedRefresh(secPerSlide*(slides+1));
	        setInterval("switchSlide()", secPerSlide*1000);
	        console.log("test");
	    }
	    var slideAt=0;
        <?php
            $query = "SELECT * FROM `" . $tbl_prefix.$tbl_slides . "` WHERE `published` LIKE 'yes';";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            echo "var slides=" . $count . ";\r\n";
            echo "var secPerSlide=" . $slide_time . ";\r\n";
            echo "function switchSlide() {\r\n";
            echo "var fieldNameElement = document.getElementById('slides');\r\n";
            for($i = 1; $i < mysql_num_rows($result); $i++)
            {
                echo "if(slideAt==" . $i . ') fieldNameElement.innerHTML = "<h1>' . filter(mysql_result($result, $i, "title")) . '</h1>' . filter(mysql_result($result, $i, "contents")) . '<br /><i>Posted by ' . mysql_result($result, $i, "poster") . mysql_result($result, $i, "Timeofpost") . '</i>";'."\r\n";
            }
        ?>
	    slideAt++;
	}
	init();
</script>
<?php
    $query = "SELECT * FROM `" . $tbl_prefix.$tbl_slides . "` WHERE `published` LIKE 'yes';";
    $result = mysql_query($query);
    if(mysql_num_rows($result)==0||$result==false) { echo "Load error :("; } else 
    {
    	echo '<h1>' . mysql_result($result, 0, "title") . '</h1>' . mysql_result($result, 0, "contents") . '<br /><br /><i>Posted by ' . mysql_result($result, 0, "poster") . mysql_result($result, 0, "Timeofpost") . '</i>';
	}
?>