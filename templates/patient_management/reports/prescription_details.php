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
$opt["caption"] = "Prescription Details";
$opt["readonly"] = true;
$opt["height"] = "80vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "-";
$grid->select_command = "SELECT tb_prescriptions.`prescription_date` AS 'Prescription Date', 
       tb_patients.`patient_name` AS 'Patient Name', 
       tb_doctors.`doctor_name` AS 'Doctor Name', 
       tb_prescriptions.`medication` AS 'Medication', 
       tb_prescriptions.`dosage` AS 'Dosage'
FROM tb_prescriptions
INNER JOIN tb_patients ON tb_prescriptions.`patient` = tb_patients.`id`
INNER JOIN tb_doctors ON tb_prescriptions.`doctor` = tb_doctors.`id`";


// column settings


$grid_id = "list_rpt_1319";

// template variables
$var = array();				
$var["out"] = $grid->render("list_rpt_1319");
$var["grid_id"] = "list_rpt_1319";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Prescription Details Report";
$var["form_details"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;