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

	if(isset($_POST["id"]))
	{
		$id = $_POST["id"];
		if($_POST["id"]=="new")
		{
			mysql_query("INSERT INTO `".$tbl_prefix.$tbl_addons."` (`id`, `name`, `css_name`, `url`) VALUES (NULL, '" . mysql_real_escape_string(stripslashes($_POST["pluginname"])) . "', '" . mysql_real_escape_string(stripslashes($_POST["cssname"])) . "', '" . mysql_real_escape_string(stripslashes($_POST["url"])) . "')");
			echo '<font color="00FF00">Sucessfully added plugin!</font>';
		}
		else //Edit
		{
			mysql_query("UPDATE `".$tbl_prefix.$tbl_addons."` SET `name`='" . mysql_real_escape_string(stripslashes($_POST["pluginname"])) . "' WHERE `id`='" . $id . "';");
			mysql_query("UPDATE `".$tbl_prefix.$tbl_addons."` SET `css_name`='" . mysql_real_escape_string(stripslashes($_POST["cssname"])) . "' WHERE `id`='" . $id . "';");
			mysql_query("UPDATE `".$tbl_prefix.$tbl_addons."` SET `url`='" . mysql_real_escape_string(stripslashes($_POST["url"])) . "' WHERE `id`='" . $id . "';");
			echo '<font color="00FF00">Sucessfully edited plugin!</font>';
		}
	}
	else if(isset($_GET["delete"]))
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
	else if(isset($_GET["edit"]))
	{
		$id = $_GET["edit"];
		$sql = "SELECT * FROM `" . $tbl_prefix.$tbl_addons . "` WHERE `id`='" . mysql_real_escape_string(stripslashes($id)) . "';";
		$result = mysql_query($sql);

		echo "<h1>Edit plugin id " . $id . "</h1>";
		echo '<form name="input" action="index.php?page=plugins" method="post">';
			echo 'Plugin name:<input type="text" name="pluginname" value="' . mysql_result($result, 0, "name") . '"><br />';
			echo 'Css name(Used for styling):<input type="text" name="cssname" value="' . mysql_result($result, 0, "css_name") . '"><br />';
			echo 'Filename of plugin:<input type="text" name="url" value="' . mysql_result($result, 0, "url") . '"><br />';
			echo '<input type="hidden" name="id" value="' . $id . '">';
			echo '<input type="submit" value="Go!" />';
		echo "</form>";
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
			echo "<td>" . '<a href="index.php?page=plugins&delete=' . mysql_result($result, $i, "id") . '"><img src="cross.png" /></a>' . '<a href="index.php?page=plugins&edit=' . mysql_result($result, $i, "id") . '"><img src="pencil.png" /></a>' . "</td>";
		echo "</tr>";
	}
?>
</table>

<h1>New slide</h1>
<form name="input" action="index.php?page=plugins" method="post">
	Plugin name:<input type="text" name="pluginname" value=""><br />
	Css name(Used for styling):<input type="text" name="cssname" value=""><br />
	Filename of plugin:<input type="text" name="url" value=""><br />
	<input type="hidden" name="id" value="new">
	<input type="submit" value="Go!" />
</form>