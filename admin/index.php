<?php
	function doHeader()
	{
		echo '<div id="title">';
			
		echo '</div>';
		echo '<div id="menu">';
			echo '<a href="index.php">Home</a>';
			echo '<a href="index.php?page=slides">Edit slides</a> ';
			echo '<a href="index.php?page=users">Users</a> ';
			echo '<a href="index.php?page=plugins">Customisations and plugins</a> ';
			echo '<a href="index.php?page=settings">Settings</a>';
			echo '<a href="index.php?page=editcss">Edit CSS</a>';
		echo '</div>';
	}
	function includePage()
	{
		echo '<div id="content-back">';
		echo '<div id="content">';
		if(isset($_GET["page"]))
		{
			$url = $_GET["page"] . ".php";
			if(file_exists($url))
			{
				include $url;
			}
		}
		else
		{
			include "intro.php";
		}
		echo '</div>';
		echo '</div>';
	}
?>
<html>
	<head>
		<title>Infogeek - Admin</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<?php
			if(isset($_GET["error"]))
			{
				echo '<div id="error">';
				echo $_GET["error"];
				echo '</div>';
			}
			
		?>
		<?php
			session_start();
			if(!isset($_SESSION["username"]))
			{
				echo '<h1>Infogeek</h1>' .
						'<form name="form1" method="post" action="process_login.php">' . 
						'<table border="0">' . 
							"<tr>" .
								"<td>Username</td>" .
								'<td><input type="text" name="user" class="input" maxlength="16"/></td>' .
							"</tr>" .
							"<tr>" .
								"<td>Password</td>" .
								'<td><input type="password" name="pass" class="input" maxlength="16"/></td>' .
							"</tr>" .
						"</table>" .
						'<input type="submit" value="Go!" />' .
					"</form>";
			}
			else
			{
				doHeader();
				includePage();
				echo '<div id="bottom"><center><i>Infogeek 1.1 - released under the MIT licence. Please see LICENCE.txt for more details, and third party lisences.<br />Uses elRTE for WYSIWYG text editing.</i><br /><i>Thanks and greetings to its contributors.</i><br />';
				//echo '<i>Running commit </i>'; //We cant know what commit we are doing.
				echo '</center></div>';
			}
		?>
	</body>
</html>
