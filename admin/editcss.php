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
	<h1>Slide editor</h1>
</div>
<?php
	//Update file if contents is loaded.
	if(isset($_POST["input"]))
	{
		file_put_contents("../slide.css", $_POST["input"]);
		
	}
?>
<form name="input" action="index.php?page=editcss" method="post">
<textarea rows="20" cols="50" name="input">
<?php
echo file_get_contents("../slide.css");
?>
</textarea>
	<input type="submit" value="Go!" />
</form>
