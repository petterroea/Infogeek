<?php
	if(!isset($_SESSION["username"]))
	{
		header("location:index.php");
		die();
	}
	include "../config.php";
	//Connect to db
	$connection = mysql_connect($db_host,$db_user,$db_pass) or die("COULD NOT CONNECT TO SQL");
	mysql_select_db($db, $connection) or die("COULD NOT SELLECT DATABASE");
?>
<div id="content-title">
	<h1>Plugins</h1>
</div>
<?php
	
?>