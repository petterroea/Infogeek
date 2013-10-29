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
			<h2>Licenses</h2>
			You must accept these licenses to install:
			<i>Infogeek</i>
			<textarea rows="10">
The MIT License (MIT)

Copyright (c) 2013 Liam Svanåsbakken Crouch

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
			</textarea>
			<i>elRTE</i>
			<textarea rows="10">
				Copyright (c) 2009-2011, Studio 42 Ltd.
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the Studio 42 Ltd. nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY Studio 42 Ltd. ''AS IS'' AND ANY
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL Studio 42 Ltd. BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

			</textarea>
			<input type="checkbox" name="license_accepted" value="yes"> <b>I HAVE READ AND ACCEPT THE LICENSE AGREEMENTS</b>
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
