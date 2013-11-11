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

	if(isset($_POST["delete"]))
	{
		$id = $_GET["delete"];
		$sql = "DELETE FROM `" . $tbl_prefix . $tbl_addons . "` WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';";
		$result = mysql_query($sql);
		if($result!=false)
		{
			echo '<font color="00FF00">Sucessfully deleted addon!</font>';
		}
		else
		{
			echo '<font color="FF0000">ERROR deleting addon!</font>';
		}
}
?>
<div id="content-title">
	<h1>Plugins</h1>
</div>
<table border="1">
<tr><td><b>Name</b></td><td><b>CSS name</b></td><td><b>Location</b></td><td><b>Settings</b></td></tr>
<?php
	//Get stuf
	$sql = "SELECT * FROM `" . $tbl_prefix.$tbl_addons . "`;";
	$result = mysql_query($sql);
	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		echo "<tr>";
			echo "<td>" . mysql_result($result, $i, "name") . "</td>";
			echo "<td>" . mysql_result($result, $i, "css_name") . "</td>";
			echo "<td>" . mysql_result($result, $i, "url") . "</td>";
			echo "<td>" . '<a href="index.php?page=slides&delete=' . mysql_result($result, $i, "id") . '"><img src="cross.png" /></a>' . '<a href="index.php?page=slides&edit=' . mysql_result($result, $i, "id") . '"><img src="pencil.png" /></a>' . "</td>";
		echo "</tr>";
	}
?>
</table>