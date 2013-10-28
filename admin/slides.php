<link rel="stylesheet" href="../res/elrte/css/smoothness/jquery-ui-1.8.7.custom.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="../res/elrte/css/elrte.min.css"                         type="text/css" media="screen" charset="utf-8">

<script src="../res/elrte/js/jquery-1.6.1.min.js"           type="text/javascript" charset="utf-8"></script>
<script src="../res/elrte/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../res/elrte/js/elrte.min.js"                  type="text/javascript" charset="utf-8"></script>
<script src="../res/elrte/js/i18n/elrte.en.js"              type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var opts = {
            lang         : 'en',   // set your language
            styleWithCSS : false,
            height       : 400,
            toolbar      : 'maxi'
        };
        // create editor
        $('#editor').elrte(opts);

        // or this way
        // var editor = new elRTE(document.getElementById('our-element'), opts);
    });
</script>
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
	if(!isset($_SESSION["username"]))
	{

	}
	else
	{	
		if(isset($_POST["id"])&&$_POST["id"]!="new")
		{
			//Edit slide
			if($_SESSION["rank"]=="1"||$_SESSION["rank"]=="2")
			{
				$id = $_POST["id"];
				echo "UPDATE " . $tbl_prefix . $tbl_slides . " SET `title`='" . mysql_real_escape_string(stripslashes($_POST["title"])) . "' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';";
				mysql_query("UPDATE " . $tbl_prefix . $tbl_slides . " SET `title`='" . mysql_real_escape_string(stripslashes($_POST["title"])) . "' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';");
				mysql_query("UPDATE " . $tbl_prefix . $tbl_slides . " SET `contents`='" . mysql_real_escape_string(stripslashes($_POST["contents"])) . "' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';");
				mysql_query("UPDATE " . $tbl_prefix . $tbl_slides . " SET `Timeofpost`='. Edited on the " . date('l jS \of F Y h:i:s A') . "' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';");
				echo '<font color="00FF00">Post updated!</font>';
			}
			else
			{
				echo '<font color="FF0000">The edit was not submitted because you are not admin. Please check your privilege and try again.<br />' . 
				'If the problem perisists, contact admin.</font>';
			}
		}
		else if($_POST["id"]=="new")
		{
			if($_SESSION["rank"]=="1"||$_SESSION["rank"]=="2")
			{
				$publish = "yes";
			}
			else
			{
				$publish = "no";
			}
			if(isset($_POST["title"])&&isset($_POST["contents"]))
			{
				mysql_query("INSERT INTO`".$tbl_prefix.$tbl_slides."` (`id`, `title`, `contents`, `poster`, `published`, `Timeofpost`) VALUES (NULL, '" . mysql_real_escape_string(stripslashes($_POST["title"])) . "', '" . mysql_real_escape_string(stripslashes($_POST["contents"])) . "', '" . $_SESSION["name"] . "', '" . $publish . "', ' on the ".date('l jS \of F Y h:i:s A')."')");
				echo '<font color="00FF00">Post added!</font>';
			}
		}
		else if(isset($_GET["disable"]))
		{
			$id = $_GET["disable"];
			$sql = "UPDATE `" . $tbl_prefix . $tbl_slides . "` SET `published`='no' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "'";
			$result = mysql_query($sql);
			if($result!=false)
			{
				echo '<font color="FF0000">Sucessfully disabled slide!</font>';
			}
		}
		else if(isset($_GET["enable"]))
		{
			$id = $_GET["enable"];
			$sql = "UPDATE `" . $tbl_prefix . $tbl_slides . "` SET `published`='yes' WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "'";
			$result = mysql_query($sql);
			if($result!=false)
			{
				echo '<font color="FF0000">Sucessfully enabled slide!</font>';
			}
		}
		else if(isset($_GET["delete"]))
		{
			$id = $_GET["delete"];
			$sql = "DELETE FROM `" . $tbl_prefix . $tbl_slides . "` WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';";
			$result = mysql_query($sql);
			if($result!=false)
			{
				echo '<font color="FF0000">Sucessfully deleted slide!</font>';
			}
		}
		if(isset($_GET["edit"]))
		{
			$id = $_GET["edit"];
			$sql = 'SELECT * FROM `' . $tbl_prefix . $tbl_slides . "` WHERE `id` LIKE '" . mysql_real_escape_string(stripslashes($id)) . "';";
			$result = mysql_query($sql);
			echo "<h1>Edit slide " . $id . "</h1>";
			echo '<form name="input" action="index.php?page=slides" method="post">';
			echo 'Title: <input type="text" name="title" size="100" value="' . mysql_result($result, 0, "title") . '"><br />';
			echo '<input type="hidden" name="id" value="' . $id . '">';
			echo 'Contents:<br /><textarea rows="10" cols="100" name="contents" id="editor">';
			echo mysql_result($result, 0, "contents");
			echo '</textarea>';
			echo '<input type="submit" value="Go!" />';
			echo '</form>';
		}		
	}
?>
<?php	
	$sql = 'SELECT * FROM `' . $tbl_prefix . $tbl_slides . '`;';
	$result = mysql_query($sql);
	
	echo '<table border="1">';
	echo '<tr><td>Title</td><td>Contents</td><td>Poster</td><td>Published?</td><td>Time of post</td><td>Actions</td></tr>';
	//List shit
	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		echo '<tr>';
			echo '<td>' . mysql_result($result, $i, "title") . '</td>';
			$str = mysql_result($result, $i, "contents");
			if(strlen($str)<40)
			{
				echo '<td>' . $str . '</td>';
			}
			else
			{
				echo '<td>' . substr($str, 0, 40) . '...</td>';
			}
			echo '<td>' . mysql_result($result, $i, "poster") . '</td>';
			echo '<td>' . mysql_result($result, $i, "published") . '</td>';
			echo '<td>' . mysql_result($result, $i, "Timeofpost") . '</td>';
			echo '<td>';
				echo '<span title="Edit slide"><a href="index.php?page=slides&edit=' . mysql_result($result, $i, "id") . '"><img src="pencil.png" /></a></span>';
				if($_SESSION["rank"]=="1"||$_SESSION["rank"]=="2")
				{
					//These require admin-access.
					if(mysql_result($result, $i, "published") == "yes")
					{
						echo '<span title="Disable slide"><a href="index.php?page=slides&disable=' . mysql_result($result, $i, "id") . '"><img src="dialog-disable.png" /></a></span>';
					}
					else
					{
						echo '<span title="Approve/Enable slide"><a href="index.php?page=slides&enable=' . mysql_result($result, $i, "id") . '"><img src="approve.png" /></a></span>';
					}
					echo '<span title="Delete slide"><a href="index.php?page=slides&delete=' . mysql_result($result, $i, "id") . '"><img src="cross.png" /></a></span>';
				}
			echo '</tr>';
		echo '</tr>';
	}
	echo '</table>';
	if(!isset($_GET["edit"]))
	{
		echo "<h1>Create new slide:</h1>";
		echo '<form name="input" action="index.php?page=slides" method="post">';
		echo 'Title: <input type="text" name="title" size="100"><br />';
		echo '<input type="hidden" name="id" value="new">';
		echo 'Contents:<br /><textarea rows="10" cols="100" name="contents" id="editor">';
		echo '</textarea>';
		echo '</form>';
	}
?>
