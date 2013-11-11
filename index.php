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
	</head>

	<body>
		<div class="title"><?php echo $party_name; ?></div>
		<?php
	        $query = "SELECT * FROM `" . $tbl_prefix.$tbl_addons . "`;";
	        $result = mysql_query($query);
	        $count = mysql_num_rows($result);
	        for($i = 0; $i < mysql_num_rows($result); $i++)
	        {
	            $pluginname = mysql_result($result, $i, "name");
	            $cssname = mysql_result($result, $i, "css_name");
	            echo '<div class="'.$cssname.'" id="'.$cssname.'">'."\r\n";
	            $url = mysql_result($result, $i, "url");
	            include "addons/" . $url;
	            echo "\r\n</div>\r\n";
	        }
		?>
	</body>
</html>