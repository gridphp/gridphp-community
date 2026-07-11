<?php
/**
 * Grid PHP Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - https://www.gridphp.com
 * @version 3.0
 * @license: see license.txt included in package
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set("display_errors","off");

set_time_limit(0);

global $valid;

$valid['config'] = true;
$valid['connection'] = true;
$valid['dbready'] = true;
$valid['confwritable'] = false;

if(is_writeable('.'))
{
    $valid['confwritable'] = true;
}

$sqlite_installed = class_exists('SQLite3') || extension_loaded('sqlite3') || extension_loaded('pdo_sqlite');

if ($sqlite_installed && empty($_POST))
{
	$_POST = [
		'dbtype' => 'sqlite3',
		'dbhost' => "demos/sample-db/database.db",
		'dbuser' => '',
		'dbpass' => '',
		'dbname' => '',
		'apikey' => ''
	];
}

if (!empty($_POST))
{
	do_install();
	
	$ready = true;
	foreach($valid as $key=>$value) 
	{
		if($value === false)
		{
			$ready = false;
		}
	}
	if ($ready)
	{
		// delete from non-dev server
		if ($_SERVER["SERVER_ADDR"] != "127.0.0.1" && $_SERVER["SERVER_NAME"] != "localhost")
		{
			@unlink("install.php");
			@unlink("config.sample.php");
		}
		
		header("location: ./index.php?track=installed");
		die;
	}
}	

function do_install()
{
	global $valid;
	
	extract($_POST);

	include_once(dirname(__FILE__)."/lib/inc/adodb/adodb.inc.php");
	$driver = $dbtype;
	$con = ADONewConnection($driver); # eg. 'mysql,oci8(for oracle),mssql,postgres,sybase'
	$con->SetFetchMode(ADODB_FETCH_ASSOC);
	$con->debug = 0;
	$con->charSet = "utf8";


	if ($dbtype == "sqlite3") {
		try {
			$link = $con->Connect($dbname, "", "", "");
		} catch (\Throwable $e) {
			$link = false;
			$valid['connection_msg'] = 'Database connection error: ' . $e->getMessage();
		}
	} else if (isset($_POST["createdb"]) && $_POST["createdb"] == 1) {
		$link = $con->Connect($dbhost, $dbuser, $dbpass);
	} else {
		$link = $con->Connect($dbhost, $dbuser, $dbpass, $dbname);
	}
		
	if (!$link) {
		$valid['connection'] = false;
		if (empty($valid['connection_msg'])) {
			$valid['connection_msg'] = 'Database not connected, Kindly check database configuration.';
		}
	}

	if (!$valid['connection'])
		return;
	
	if ($valid['connection'] == true)
	{
		$templine = '';
		$lines = array();
		
		// Read in entire file
		switch($dbtype)
		{
			case "mysqli":
				$lines = file("./demos/sample-db/database-mysql.sql");
				break;

			case "mssqlnative":
				$lines = file("./demos/sample-db/database-mssql.sql");
				break;
		}

		if (!empty($lines))
		{
			if ($dbtype == "mysqli")
			{
				// append create db calls
				if ($_POST["createdb"] == 1)
				{
					// Loop through each line
					foreach ($lines as &$line)
					{
						// ignore internal create db if used from installer
						if ((strstr($line,"CREATE DATABASE") !== false || strstr($line,"USE") !== false))
							$line = "";
					}
					
					array_unshift($lines, "CREATE DATABASE `$dbname`;", "USE `$dbname`;");
				}
				// append on USE db call
				else
				{
					// Loop through each line
					foreach ($lines as &$line)
					{
						// ignore internal create db if used from installer
						if ((strstr($line,"CREATE DATABASE") !== false || strstr($line,"USE") !== false))
							$line = "";
					}
					
					array_unshift($lines, "USE `$dbname`;");		
				}
		
				// was reference to last index of $lines
				unset($line);
			}

			// Loop through each line
			foreach ($lines as $line)
			{
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';')
				{
					// Perform the query
					if (!$con->execute($templine))
					{
						$valid['dbready'] = false;
						$valid['dbready_msg'] .= 'Error performing query \'<strong>' . $templine . '\': ' . $con->ErrorMsg() .'</strong>' ;
						$valid['dbready_err'] .= $con->ErrorMsg();
						break;
					}
					
					// Reset temp variable to empty
					$templine = '';
				}
			}
		}
	}
	
	if (strstr($valid["dbready_err"],"Access denied for user") !== false)
		$valid["dbready_msg"] = "<b>Provided user is able to connect but it does not have permission to create database.</b>";

	if (!$valid['dbready'])
		return;	
	
	// create or override config file
	$scriptName = $_SERVER['SCRIPT_NAME'];
	$webRoot = substr($scriptName, 0, strlen($scriptName) - strlen('/install.php'));

	$configContents = file_get_contents("config.sample.php");
	$configContents = str_replace("{{dbtype}}", $dbtype, $configContents);
	$configContents = str_replace("{{dbuser}}", $dbuser, $configContents);
	$configContents = str_replace("{{dbpass}}", $dbpass, $configContents);
	
	if ($dbtype == "sqlite3") {
		$configContents = str_replace('"{{dbhost}}"', 'dirname(__FILE__) . "/' . $dbhost . '"', $configContents);
		$configContents = str_replace("{{dbname}}", "", $configContents);
	} else {
		$configContents = str_replace("{{dbhost}}", $dbhost, $configContents);
		$configContents = str_replace("{{dbname}}", $dbname, $configContents);
	}

	$configContents = str_replace("{{apikey}}", $apikey, $configContents);

	$handle = fopen("config.php", "w+");
	
	if (!$handle)
		$valid['config'] = false;
	
	fwrite($handle, $configContents);
	fclose($handle);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Grid PHP Framework Demos | www.gridphp.com</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="https://ajax.aspnetcdn.com/ajax/bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
	body {
		padding-top: 60px;
		padding-bottom: 0;
	}

	.sidebar-nav {
		padding: 9px 0;
	}

	.help {
		color: gray;
		padding: 10px;
	}
	</style>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">Grid PHP Framework Demos</a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						(Build Version 3.1) —
						<a href="https://www.gridphp.com/" class="navbar-link">www.gridphp.com</a>
					</p>
					<ul class="nav">
						<li><a target="_blank" href="https://www.gridphp.com/">Home</a></li>
						<li class="active"><a href="#">Demos</a></li>
						<li><a target="_blank" href="https://www.gridphp.com/docs/">Docs & FAQs</a></li>
						<li><a target="_blank" href="https://www.gridphp.com/support/">Support Forum</a></li>
						<li><a target="_blank" href="https://www.gridphp.com/contact/">Contact Us</a></li>

					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<!-- Form Name -->
				<legend>Installing Demos</legend>

				<div class="alert alert-info">
					Please enter your Database connection details to setup demos.
				</div>

				<?php if (!$sqlite_installed): ?>
				<div class="alert alert-error">
					<strong>Warning:</strong> The SQLite extension is not installed/enabled in PHP. Please enable it in your php.ini or select an alternate database (like MySQL) below.
				</div>
				<?php endif; ?>

				<?php if (!empty($_POST)): ?>
				<?php if ($valid['connection']): ?>
				<div class="alert alert-success">
					<strong>Checking if connection is valid:</strong> Database connected.
				</div>
				<?php else: ?>
				<div class="alert alert-error">
					<strong>Checking if connection is valid:</strong> <?php echo $valid['connection_msg']; ?>
				</div>
				<?php endif; ?>

				<?php if (!$valid['config']): ?>
				<div class="alert alert-error">
					<strong>Writing to config file:</strong>
					<p>The configuration file is not writable.
					<p>Please rename config.sample.php to config.php and update the database configuration OR Try <a
							target="_blank" href="https://www.gridphp.com/docs/setup/#installing-demos-manually">Manual
							Setup</a></p>
				</div>
				<?php endif; ?>
				<?php endif; ?>

				<?php if ($valid['confwritable']): ?>
				<div class="alert alert-success">
					<strong>Checking if config writable:</strong> Your config file is writable.
				</div>
				<?php else: ?>
				<div class="alert alert-error">
					<strong>Checking if config writable:</strong>
					<p>The configuration file is not writable.
					<p>Please copy config.sample.php to config.php and update the database configuration OR Try <a
							target="_blank" href="https://www.gridphp.com/docs/setup/#installing-demos-manually">Manual
							Setup</a></p>
				</div>
				<?php endif; ?>

				<?php if ($valid['dbready'] === false): ?>
				<div class="alert alert-error">
					<strong>Error:</strong> <?php echo $valid['dbready_msg']; ?>
				</div>
				<?php endif; ?>

				<form class="form-horizontal" method="post">
					<fieldset>

						<!-- Select Basic -->
						<div class="control-group">
							<label class="control-label" for="selectbasic">Database Type</label>
							<div class="controls">
								<select id="dbtype" name="dbtype" class="input-xlarge">
									<option value="sqlite3"
										<?php echo (!isset($_POST['dbtype']) || $_POST['dbtype']=='sqlite3') ? "selected" : "" ?>>
										SQLite</option>
									<option value="mysqli"
										<?php echo (isset($_POST['dbtype']) && $_POST['dbtype']=='mysqli') ? "selected" : "" ?>>
										MySQL</option>
									<option value="mssqlnative"
										<?php echo (isset($_POST['dbtype']) && $_POST['dbtype']=='mssqlnative') ? "selected" : "" ?>>
										SQLServer</option>
								</select>
								<span class="help">You can also install demos for PostgreSQL manually.</span>
							</div>
						</div>

						<!-- Text input-->
						<div class="control-group">
							<label class="control-label" for="db">Database Host</label>
							<div class="controls">
								<input id="dbhost" name="dbhost" type="text" placeholder="localhost"
									class="input-xlarge" required=""
									value="<?php echo isset($_POST['dbhost']) ? $_POST['dbhost'] : "localhost" ?>">
								<span class="help">You should be able to get this info from your webhost, if localhost
									doesn't work.</span>
							</div>
						</div>

						<!-- Text input-->
						<div class="control-group">
							<label class="control-label" for="dbuser">Database Username</label>
							<div class="controls">
								<input id="dbuser" name="dbuser" type="text" placeholder="" class="input-xlarge"
									required="" value="<?php echo isset($_POST['dbuser']) ? $_POST['dbuser'] : "" ?>">
								<span class="help">Your database username</span>
							</div>
						</div>

						<!-- Password input-->
						<div class="control-group">
							<label class="control-label" for="dbpass">Database Password</label>
							<div class="controls">
								<input id="dbpass" name="dbpass" type="password" placeholder="" class="input-xlarge"
									value="<?php echo isset($_POST['dbpass']) ? $_POST['dbpass'] : "" ?>">
								<span class="help">Your database password.</span>
							</div>
						</div>

						<!-- Dbname input-->
						<div class="control-group">
							<label class="control-label" for="dbname">Database Name</label>
							<div class="controls">
								<input id="dbname" name="dbname" type="text" placeholder="" class="input-xlarge"
									required="" value="<?php echo isset($_POST['dbname']) ? $_POST['dbname'] : "" ?>">
								<span class="help"><b>Note:</b> If checked, database User must have CREATE DATABASE
									privilege. Otherwise You should create database manually before install.</span>
								<div>
									<label class="checkbox inline" for="createdb">
										<input name="createdb" id="createdb" value="1" type="checkbox"
											onclick="if (this.checked) jQuery('#create_tip').show();">
										Create Database
									</label>
								</div>
							</div>
						</div>

						<!-- Apikey input-->
						<div class="control-group">
							<label class="control-label" for="apikey">AI API Key</label>
							<div class="controls">
								<input id="apikey" name="apikey" type="text" placeholder="" class="input-xlarge"
									value="<?php echo isset($_POST['apikey']) ? $_POST['apikey'] : "" ?>">
								<span class="help">You can obtain a Free AI API key from <a href='https://console.groq.com/' target='_blank'>Groq Cloud Platform</a>. — (Optional)</span>
							</div>
						</div>

						<!-- Button -->
						<div class="control-group">
							<label class="control-label" for=""></label>
							<div class="controls">
								<button id="" name="" class="btn btn-primary">Install</button>
								or
								<a target="_blank"
									href="https://www.gridphp.com/docs/setup/#installing-demos-manually">Manual
									Setup</a>
							</div>
						</div>

					</fieldset>
				</form>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<div class="row-fluid">
						<div class="alert alert-info">
							<a name="contact"></a>
							<h2>Technical Support</h2>
							<p class="text-info">For technical support query, ask at our <a
									href="https://www.gridphp.com/support/">Support Center</a> </p>
							<p>&copy; <a href="//www.gridphp.com/">www.gridphp.com</a> 2010-<?php echo date("Y");?></p>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<!--/span-->
			</div>
			<!--/row-->

		</div>
		<!--/row-->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
		<script>
		window.jQuery || document.write('<script src="bootstrap/js/jquery.js"><\/script>')
		</script>

		<script src="https://ajax.aspnetcdn.com/ajax/bootstrap/2.3.1/bootstrap.min.js"></script>
		<script>
		jQuery.fn.modal || document.write('<script src="bootstrap/js/bootstrap.min.js"><\/script>')
		</script>

		<script>
		function updateFields() {
			var dbtype = jQuery('#dbtype').val();
			if (dbtype === 'sqlite3') {
				jQuery('#dbhost').closest('.control-group').hide().find('input').removeAttr('required');
				jQuery('#dbuser').closest('.control-group').hide().find('input').removeAttr('required');
				jQuery('#dbpass').closest('.control-group').hide();
				jQuery('#createdb').closest('div').hide();
				jQuery('label[for="dbname"]').text('Database File Path');
				jQuery('#dbname').attr('placeholder', 'demos/sample-db/database.db');
				if (jQuery('#dbhost').val() === '') {
					jQuery('#dbhost').val('demos/sample-db/database.db');
					jQuery('#dbname').val('');
				}
			} else {
				jQuery('#dbhost').closest('.control-group').show().find('input').attr('required', 'required');
				jQuery('#dbuser').closest('.control-group').show().find('input').attr('required', 'required');
				jQuery('#dbpass').closest('.control-group').show();
				jQuery('#createdb').closest('div').show();
				jQuery('label[for="dbname"]').text('Database Name');
				jQuery('#dbname').attr('placeholder', '');
				if (jQuery('#dbhost').val() === 'demos/sample-db/database.db') {
					jQuery('#dbhost').val('localhost');
				}
			}
		}

		jQuery(document).ready(function() {
			jQuery('#dbtype').change(updateFields);
			updateFields();
		});
		</script>

	</div>
	<!--/.fluid-container-->

	<?php if ($_SERVER["SERVER_NAME"] !== "jqgrid" || $_SERVER["SERVER_NAME"] !== "localhost") { ?>

	<!-- OpenReplay Tracking Code for Gridphp Demos -->
	<script>
	var initOpts = {
		projectKey: "0vFV1DENJckcITrAKfpI",
		defaultInputMode: 1,
		obscureTextNumbers: false,
		obscureTextEmails: true,
		__DISABLE_SECURE_MODE: true
	};
	var startOpts = { userID: "" };
	(function(A,s,a,y,e,r){
		r=window.OpenReplay=[e,r,y,[s-1, e]];
		s=document.createElement('script');s.src=A;s.async=!a;
		document.getElementsByTagName('head')[0].appendChild(s);
		r.start=function(v){r.push([0])};
		r.stop=function(v){r.push([1])};
		r.setUserID=function(id){r.push([2,id])};
		r.setUserAnonymousID=function(id){r.push([3,id])};
		r.setMetadata=function(k,v){r.push([4,k,v])};
		r.event=function(k,p,i){r.push([5,k,p,i])};
		r.issue=function(k,p){r.push([6,k,p])};
		r.isActive=function(){return false};
		r.getSessionToken=function(){};
	})("//static.openreplay.com/latest/openreplay-assist.js",1,0,initOpts,startOpts);
	</script>

	<!-- Matomo -->
	<script>
	var _paq = window._paq = window._paq || [];
	/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	_paq.push(["setExcludedReferrers", ["eu.mouseflow.com"]]);
	_paq.push(['trackPageView']);
	_paq.push(['enableLinkTracking']);
	(function() {
		var u="//track.gridphp.com/admin/";
		_paq.push(['setTrackerUrl', u+'matomo.php']);
		_paq.push(['setSiteId', '3']);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	})();
	</script>
	<!-- End Matomo Code -->

	<!-- crisp-chat -->
	<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="a1ebca0b-fb54-4ac4-b945-f86fa9b9b080";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
	<!-- /crisp-chat -->

	<script type='text/javascript'>
	window.smartlook || (function(d) {
		var o = smartlook = function() {
				o.api.push(arguments)
			},
			h = d.getElementsByTagName('head')[0];
		var c = d.createElement('script');
		o.api = new Array();
		c.async = true;
		c.type = 'text/javascript';
		c.charset = 'utf-8';
		c.src = 'https://web-sdk.smartlook.com/recorder.js';
		h.appendChild(c);
	})(document);
	smartlook('init', '48d2662ab0dc9862570160eb655eca65d7ba8459', {
		region: 'eu'
	});
	</script>
	
	<?php } ?>

</body>

</html>
