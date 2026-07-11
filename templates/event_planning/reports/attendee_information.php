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
$opt["caption"] = "Attendee Information";
$opt["readonly"] = true;
$opt["height"] = "80vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "-";
$grid->select_command = "SELECT 
  tb_attendees.`name` AS Attendee_Name,
  tb_attendees.`email` AS Attendee_Email,
  tb_attendees.`phone_number` AS Attendee_Phone_Number,
  tb_events.`title` AS Event_Title
FROM tb_attendees
INNER JOIN tb_events ON tb_attendees.`event` = tb_events.`id`";


// column settings


$grid_id = "list_rpt_1304";

// template variables
$var = array();				
$var["out"] = $grid->render("list_rpt_1304");
$var["grid_id"] = "list_rpt_1304";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Attendee Information Report";
$var["form_details"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;