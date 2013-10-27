<?php
include "../config.php";

session_start();

if(isset($_POST["user"])&&isset($_POST["pass"]))
{
	$connection = mysql_connect($db_host,$db_user,$db_pass) or die("COULD NOT CONNECT TO SQL");
	mysql_select_db($db, $connection) or die("COULD NOT SELLECT DATABASE");

	$username=stripslashes(mysql_real_escape_string($_POST['user']));
	$password=md5(stripslashes(mysql_real_escape_string($_POST['pass'])));
	
	$sql = "SELECT * FROM `" . $tbl_prefix . $tbl_users . "` WHERE `username` LIKE '" . $username . "' AND `password` LIKE '" . $password . "'";
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)==1)
	{
		$_SESSION["username"]=$username;
		$_SESSION["name"] = mysql_result($result, 0, "name");
		$_SESSION["rank"] = mysql_result($result, 0, "rank");
		header("location:index.php");
	}
	else
	{
		//echo $sql;
		//echo mysql_error();
		header("location:index.php?error=Incorrect+username+or+password!");
		//header("location:login.php?error=Incorrect+username+or+password!");
	}
}
else
{
	header("location:login.php?error=Enter+username+and+password!");
}
?>