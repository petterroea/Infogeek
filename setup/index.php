<html>

<head>

<title></title>

</head>

<body>
<div style="width:100%; height:100px; background-color:green; margin: 0px; font-family:sans-serif; font-size:40px; color:#00CC00;"><h1>Infogeek setup</h1></div>

<div style="width:100%;font-family:sans-serif;">
Welcome to this setup that will guide you through the installation of Infogeek.<br />
<i>Please ignore coder-colors</i><br /><br /><br />
<?php
$can_install=true;
?>
<h2>Prerequisites</h3>
MySql<img src="<?php if(extension_loaded("mysql")) { echo "../res/tick-24.png"; } else { echo "../res/cross-24.png"; $can_install=false; }?>" /><br />
config.php is writable <img src="<?php if(is_writable("../config.php")) { echo "../res/tick-24.png"; } else if(!file_exists("../config.php")) { echo "../res/exclamation-24.png"; } else { echo "../res/cross-24.png"; $can_install=false; }?>" /><br />
<?php
if(!file_exists("../config.php")) { echo '<i style="font-size:12px;">config.php does not exist. I will attempt to create the file as part of installation.</i><br />'; }
?>

slide.css is writable <img src="<?php if(is_writable("../slide.css")) { echo "../res/tick-24.png"; } else if(!file_exists("../slide.css")) { echo "../res/exclamation-24.png"; } else { echo "../res/cross-24.png"; $can_install=false; }?>" /><br />
<?php
if(!file_exists("../slide.css")) { echo '<i style="font-size:12px;">slide.css does not exist. I will attempt to create the file as part of installation.</i><br />'; }
if(!$can_install) {echo "<b>There are some errors which must be fixed before installation. Please fix them, and then reload the page.</b>"; exit();}
?>
<form name="input" action="install.php" method="post">
<h2>MySql information</h2>
This information is used to determine where to store information and slides.<br />
Host: <input type="text" name="db_host"><br />
Username: <input type="text" name="db_user"><br />
Password: <input type="password" name="db_pass"><br />
Database: <input type="text" name="db"><br />
Table prefix: <input type="text" name="tbl_prefix" value="infogeek_"><i>This will be the start of the name of all the databases. Blank for none</i><br />
Slide table name: <input type="text" name="tbl_slides" value="slides">Ignore if it allready exists?<input type="checkbox" name="tbl_slides_ignore_existing" value="yes" checked><br />
User table name: <input type="text" name="tbl_users" value="users">Ignore if it allready exists?<input type="checkbox" name="tbl_users_ignore_existing" value="yes" checked><br />
Addon table name: <input type="text" name="tbl_addons" value="addons">Ignore if it allready exists?<input type="checkbox" name="tbl_addons_ignore_existing" value="yes" checked><br />
</div>
<h2>Misc information</h2>
Admin password: <input type="password" name="admin_password" value=""><br /><br />
Full name of admin: <input type="text" name="admin_name" value=""><br /><br />
<input type="submit" value="Install">
</form>
</body>

</html>
