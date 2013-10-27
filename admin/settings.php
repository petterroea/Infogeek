<?php
	include "../config.php";
	if(!isset($_SESSION["username"]))
	{
		header("location:index.php");
		die();
	}
	else
	{
		
	}
?>
<div id="content-title">
<h1>Infogeek settings</h1>
</div>
