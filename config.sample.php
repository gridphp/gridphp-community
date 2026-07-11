<?php
// PHP Grid database connection settings, Only need to update these in new project

// replace {{dbtype}} with one of these: mysqli,oci8 (for oracle),mssqlnative,postgres,sybase. Don't include {{ }}
define("PHPGRID_DBTYPE","{{dbtype}}"); 
define("PHPGRID_DBHOST","{{dbhost}}");
define("PHPGRID_DBUSER","{{dbuser}}");
define("PHPGRID_DBPASS","{{dbpass}}");
define("PHPGRID_DBNAME","{{dbname}}");

// database charset
define("PHPGRID_DBCHARSET","utf8");

// Show debugging message in case of an issue, should be turned off for production
define("PHPGRID_DEBUG","1");

// AI Api Key, Free API Key available at https://console.groq.com/keys  
define("PHPGRID_AI_KEY","{{apikey}}");

// Basepath for lib
define("PHPGRID_LIBPATH",dirname(__FILE__).DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR);