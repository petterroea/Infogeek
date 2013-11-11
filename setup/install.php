<?php
	error_reporting(E_ALL);
	echo '<i><font color="009900">Preparing to install...<br /></font>';
	$can_install=true;
	$db_host=$_POST["db_host"];
	$db_user=$_POST["db_user"];
	$db_pass=$_POST["db_pass"];
	$db=$_POST["db"];
	$tbl_prefix=$_POST["tbl_prefix"];
	$tbl_slides=$_POST["tbl_slides"];
	$tbl_users=$_POST["tbl_users"];
	$tbl_addons=$_POST["tbl_addons"];
	$admin_password=$_POST["admin_password"];
	$admin_name=$_POST["admin_name"];
	//Optional
	$tbl_slides_ignore_existing=$_POST["tbl_slides_ignore_existing"];
	$tbl_users_ignore_existing=$_POST["tbl_users_ignore_existing"];
	$tbl_addons_ignore_existing=$_POST["tbl_addons_ignore_existing"];
	//Check the values
	echo '<font color="009900">Got parameters from POST<br /></font>';
	if($db_host=="") { echo '<font color="990000">Missing database host!<br /></font>'; $can_install=false;}
	if($db_user=="") { echo '<font color="990000">Missing database username!<br /></font>'; $can_install=false;}
	if($db_pass=="") { echo '<font color="990000">Missing database password!<br /></font>'; $can_install=false;}
	if($db=="") { echo '<font color="990000">Missing database!<br /></font>'; $can_install=false;}
	if($tbl_prefix=="") { echo '<font color="990000">Missing table prefix!<br /></font>'; $can_install=false;}
	if($tbl_slides=="") { echo '<font color="990000">Missing slide table name!<br /></font>'; $can_install=false;}
	if($tbl_users=="") { echo '<font color="990000">Missing user table name!<br /></font>'; $can_install=false;}
	if($tbl_addons=="") { echo '<font color="990000">Missing addon table!<br /></font>'; $can_install=false;}
	if($admin_password=="") { echo '<font color="990000">Missing admin password!<br /></font>'; $can_install=false;}
	if($admin_name=="") { echo '<font color="990000">Missing admin name!<br /></font>'; $can_install=false;}
	if(!$can_install) { echo '<font color="990000"><b>Looks like you are missing some fields! Click <a href="index.php">here</a> to return.</b><br /></font>'; die();}

	echo '<font color="009900">Connecting to and selecting database...<br /></font>';
	mysql_connect("$db_host", "$db_user", "$db_pass")or die('<font color="990000">Failed to connect!<br /></font>');
	mysql_select_db("$db")or die('<font color="990000">Failed to select database!<br /></font>');
	echo '<font color="009900">Checking if tables exist...<br /></font>';
	$error = false;
	$slidesExists=false;
	$usersExists=false;
	$addonsExists=false;

	//Check existance of tables
	$query = "SHOW TABLES LIKE '".$tbl_prefix.$tbl_slides."'";
	$result = mysql_query($query);
	if(mysql_num_rows($result)==1) { $slidesExists=true; }
	$query = "SHOW TABLES LIKE '".$tbl_prefix.$tbl_users."'";
	$result = mysql_query($query);
	if(mysql_num_rows($result)==1) { $usersExists=true; }
	$query = "SHOW TABLES LIKE '".$tbl_prefix.$tbl_addons."'";
	$result = mysql_query($query);
	if(mysql_num_rows($result)==1) { $addonsExists=true; }

	echo '<font color="009900">Pre-installation checks complete!<br /></font>';
	echo '<font color="009900">Installing tables...<br /></font>';
	//Slides
	$query = "CREATE TABLE `".$tbl_prefix.$tbl_slides."` ( `id` int(10) NOT NULL AUTO_INCREMENT, `revision` int(10) NOT NULL default '0', `title` varchar(100) NOT NULL,`contents` varchar(10000) NOT NULL,`poster` varchar(100) NOT NULL, `published` varchar(3) NOT NULL,`Timeofpost` varchar(100) NOT NULL, PRIMARY KEY (`id`))";
	echo "<i>" . $query . "</i></br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding slide table!<br /></font>'; mysql_error();} else { echo '<font color="009900">Added slide table<br /></font>'; }

	//Users
	$query = "CREATE TABLE `".$tbl_prefix.$tbl_users."` ( `id` int(10) NOT NULL AUTO_INCREMENT,`name` varchar(100) NOT NULL default '',`password` varchar(32) NOT NULL default '',`username` varchar(100) NOT NULL, `rank` int(10) NOT NULL default '0', PRIMARY KEY (`id`))";
	echo "<i>" . $query . "</i></br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding user table!<br /></font>'; mysql_error();} else { echo '<font color="009900">Added user table<br /></font>'; }

	//Addons
	$query = "CREATE TABLE `".$tbl_prefix.$tbl_addons."` ( `id` int(10) NOT NULL AUTO_INCREMENT,`name` varchar(100) NOT NULL default '',`css_name` varchar(100) NOT NULL default '',`url` varchar(100) NOT NULL default '', PRIMARY KEY (`id`))";
	echo "<i>" . $query . "</i></br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding addon table!<br /></font>' . $result; mysql_error();} else { echo '<font color="009900">Added addon table<br /></font>'; }

	echo '<font color="009900">Done! Writing to config files...<br /></font>';

	$config_php="<?php //Infogeek generated config sheet\r\n" . 
	'$db_host="' . $db_host . '";' . "\r\n" . 
	'$db_user="' . $db_user . '";' . "\r\n" .
	'$db_pass="' . $db_pass . '";' . "\r\n" .
	'$db="' . $db . '";' . "\r\n" .
	'$tbl_prefix="' . $tbl_prefix . '";' . "\r\n" .
	'$tbl_slides="' . $tbl_slides . '";' . "\r\n" .
	'$tbl_users="' . $tbl_users . '";' . "\r\n" .
	'$tbl_addons="' . $tbl_addons . '";' . "\r\n" .
	'$slide_time=15;' . "\r\n" .
	'$addon_folder="addons";' . "\r\n" .
	'$party_name="Party name";' . "\r\n" .' ?>';
	$handle = fopen("../config.php", 'w');
	fwrite($handle, $config_php);
	fclose($handle);

	echo '<font color="009900">Done! Generating dummy slide...<br /></font>';

	$query = "INSERT INTO`".$tbl_prefix.$tbl_slides."` (`id`, `title`, `contents`, `poster`, `published`, `Timeofpost`) VALUES (NULL, 'Dummy slide!', 'This is a dummy slide. You can delete it from the admin panel, and add new ones instead', 'Admin', 'yes', ' on the ".date('l jS \of F Y h:i:s A')."')";
	echo $query . "<br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding db entry for dummy slide<br /></font>'; mysql_error();}

	echo '<font color="009900">Generating admin<br /></font>';

	$query = "INSERT INTO `".$tbl_prefix.$tbl_users."` (`id`, `name`, `password`, `username`, `rank`) VALUES (NULL, '" . $admin_name . "', '" . md5($admin_password) . "', 'admin', '1');";
	echo $query . "<br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding admin user<br /></font>'; mysql_error();}

	echo '<font color="009900">Generating slide plugin<br /></font>';

	$query = "INSERT INTO `".$tbl_prefix.$tbl_addons."` (`id`, `name`, `css_name`, `url`) VALUES (NULL, 'Slide provider', 'slides', 'slides.php');";
	echo $query . "<br />";
	$result = mysql_query($query);
	if($result==false) { echo '<font color="990000">Error adding admin user<br /></font>'; mysql_error();}

	echo '<font color="009900">Generating dummy CSS...<br /></font>';

	$cssfile="body {\r\n" .
	"background-color:#000000;\r\n" .
	"color:#FFFFFF;\r\n".
	"}\r\n";

	$handle = fopen("../slide.css", 'w');
	fwrite($handle, $cssfile);
	fclose($handle);

	echo '<b><font color="009900">Done! Delete the folder "setup" and go to the root of this webpage.<br /></font></b>';

	echo "</i>";
?>
