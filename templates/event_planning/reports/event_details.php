<?php 
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */
 
include_once(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

// Database config file to be passed in phpgrid constructor
$db_conf = array( 	
					"type"		=> PHPGRID_DBTYPE, 
					"server"	=> PHPGRID_DBHOST,
					"user"		=> PHPGRID_DBUSER,
					"password"	=> PHPGRID_DBPASS,
					"database"	=> PHPGRID_DBNAME
				);


$grid = new jqgrid($db_conf);

// grid options
$opt = array();
$opt["caption"] = "Event Details";
$opt["readonly"] = true;
$opt["height"] = "80vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "-";
$grid->select_command = "SELECT 
  tb_events.`title` AS Event_Title,
  tb_events.`description` AS Event_Description,
  tb_events.`start_date` AS Event_Start_Date,
  tb_events.`end_date` AS Event_End_Date,
  tb_events.`status` AS Event_Status,
  tb_events.`event_type` AS Event_Type
FROM tb_events";


// column settings


$grid_id = "list_rpt_1303";

// template variables
$var = array();				
$var["out"] = $grid->render("list_rpt_1303");
$var["grid_id"] = "list_rpt_1303";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Event Details Report";
$var["form_details"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;