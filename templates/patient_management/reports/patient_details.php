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
$opt["caption"] = "Patient Details";
$opt["readonly"] = true;
$opt["height"] = "80vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "-";
$grid->select_command = "SELECT tb_patients.`patient_name` AS 'Patient Name', 
       tb_patients.`date_of_birth` AS 'Date of Birth', 
       tb_patients.`contact_number` AS 'Contact Number', 
       tb_patients.`email` AS 'Email', 
       tb_patients.`address` AS 'Address', 
       tb_patients.`blood_group` AS 'Blood Group', 
       tb_patients.`medical_history` AS 'Medical History', 
       tb_patients.`allergies` AS 'Allergies'
FROM tb_patients";


// column settings


$grid_id = "list_rpt_1317";

// template variables
$var = array();				
$var["out"] = $grid->render("list_rpt_1317");
$var["grid_id"] = "list_rpt_1317";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Patient Details Report";
$var["form_details"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;