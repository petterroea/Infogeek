<?php
	error_reporting(E_ALL);
	//Check if we need to install
	if(is_dir("setup"))
	{
		header('location:setup/index.php' ) ;
		die();
	}
	include "config.php";
	mysql_connect("$db_host", "$db_user", "$db_pass")or die('Failed to connect');
	mysql_select_db("$db")or die('Failed to connect to database');
	//Reusing code, this function filters stuff that fucks up the javascript.
	function filter($str)
	{
	    return str_replace('"', '\\"', str_replace("\n", '', str_replace("\r", '', $str)));
	}
?>
<html>

	<head>
		<link rel="stylesheet" type="text/css" href="slide.css">
		<title><?php echo $party_name; ?></title>
		<script type="text/JavaScript">
		    function timedRefresh(timeoutPeriod) {
			   setTimeout("location.reload(true);",timeoutPeriod*1000);
		    }
		    function init(){
		        timedRefresh(secPerSlide*(slides+1));
		        setInterval("switchSlide()", secPerSlide*1000);
		    }
		    
		    var slideAt=0;
		        <?php
		            
		            $query = "SELECT * FROM `" . $tbl_prefix.$tbl_slides . "` WHERE `published` LIKE 'yes';";
		            $result = mysql_query($query);
		            $count = mysql_num_rows($result);
		            echo "var slides=" . $count . ";\r\n";
		            echo "var secPerSlide=" . $slide_time . ";\r\n";
		            echo "function switchSlide() {\r\n";
		            echo "var fieldNameElement = document.getElementById('contents');\r\n";
		            for($i = 1; $i < mysql_num_rows($result); $i++)
		            {
		                echo "if(slideAt==" . $i . ') fieldNameElement.innerHTML = "<h1>' . filter(mysql_result($result, $i, "title")) . '</h1>' . filter(mysql_result($result, $i, "contents")) . '<br /><i>Posted by ' . mysql_result($result, $i, "poster") . mysql_result($result, $i, "Timeofpost") . '</i>";'."\r\n";
		            }
		        ?>
		    slideAt++;
		}

		</script>
	</head>

	<body onload="JavaScript:init();">
		<div class="title"><?php echo $party_name; ?></div>
		<?php
	        $query = "SELECT * FROM `" . $tbl_prefix.$tbl_addons . "`;";
	        $result = mysql_query($query);
	        $count = mysql_num_rows($result);
	        for($i = 0; $i < mysql_num_rows($result); $i++)
	        {
	            $pluginname = mysql_result($result, $i, "name");
	            echo '<div class="'.$pluginname.'" id="'.$pluginname.'">'."\r\n";
	            $url = mysql_result($result, $i, "url");
	            include "addons/" . $url;
	            echo "\r\n</div>\r\n";
	        }
		?>
	</body>

</html>