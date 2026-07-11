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
$opt["caption"] = "Task Assignments";
$opt["readonly"] = true;
$opt["height"] = "80vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "-";
$grid->select_command = "SELECT 
  tb_event_tasks.`task_name` AS Task_Name,
  tb_event_tasks.`due_date` AS Task_Due_Date,
  tb_event_tasks.`status` AS Task_Status,
  tb_events.`title` AS Event_Title,
  tb_event_tasks.`assigned_to` AS Task_Assigned_To
FROM tb_event_tasks
INNER JOIN tb_events ON tb_event_tasks.`event` = tb_events.`id`";


// column settings


$grid_id = "list_rpt_1305";

// template variables
$var = array();				
$var["out"] = $grid->render("list_rpt_1305");
$var["grid_id"] = "list_rpt_1305";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Task Assignments Report";
$var["form_details"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;