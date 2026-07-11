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

// default actions, moved up so set_options overrides it if required
$actions = array (
  'add' => true,
  'edit' => true,
  'bulkedit' => true,
  'delete' => true,
  'rowactions' => true,
  'export_csv' => true,
  'aiassistant' => true,
  'autofilter' => true,
  'search' => 'advanced',
);
$grid->set_actions($actions);

// grid options
$opt = array();
$opt["caption"] = "Appointments";
$opt["sortname"] = "id";
$opt["sortorder"] = "ASC";
$opt["readonly"] = false;
$opt["multiselect"] = true;
$opt["scroll"] = false;
$opt["height"] = "70vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;
$opt["loadComplete"] = "function(o){ if (typeof gridLoad === 'function') gridLoad(o); }";
$opt["onAfterSave"] = "function(){ if (typeof afterSave === 'function') afterSave(); }";
$opt["shrinkToFit"] = false;
$opt["sortable"] = false;
$opt["cmTemplate"]["visible"] = 'xs+';
$opt["cmTemplate"]["editoptions"]["dataEvents"] = array( array (
  'type' => 'loadform change click keyup',
  'fn' => 'function(e){ if (formCallback) formCallback(this,e); }',
) );

// Customize add/edit/view dialogs
$opt["add_options"]["width"] = 800;
$opt["add_options"]["addCaption"] = "Add Appointment";
$opt["add_options"]["success_msg"] = "Appointment added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Appointment";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Appointment updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Appointment";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Appointment deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_appointments";
$grid->select_command = "SELECT tb_appointments.id, tb_appointments.`patient`, tb_appointments.`appointment_date`, tb_appointments.`appointment_time`, tb_appointments.`doctor`, tb_appointments.`appointment_reason` FROM tb_appointments LEFT JOIN tb_patients ON tb_patients.`id` = tb_appointments.`patient` LEFT JOIN tb_doctors ON tb_doctors.`id` = tb_appointments.`doctor` WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_appointments.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_appointments.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_appointments.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "patient";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "badge";
$col["dbname"] = "tb_appointments.`patient`";
$col["frozen"] = true;
$col["edittype"] = "lookup";
$col["isnull"] = "";
$col["editoptions"]["table"] = 'tb_patients';
$col["editoptions"]["id"] = 'id';
$col["editoptions"]["label"] = 'patient_name';
$col["editoptions"]["onload"] = array (
  'sql' => 'select distinct id as k, patient_name as v from tb_patients',
);
$col["badgeoptions"]["editurl"] = 'index.php?mod=patients&grid_id=list_patients&col=id';
$cols[] = $col;

$col = array();
$col["name"] = "appointment_date";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_appointments.`appointment_date`";
$col["formatter"] = "date";
$col["formatoptions"]["srcformat"] = 'Y-m-d';
$col["formatoptions"]["newformat"] = 'm/d/Y';
$cols[] = $col;

$col = array();
$col["name"] = "appointment_time";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_appointments.`appointment_time`";
$col["formatter"] = "datetime";
$col["formatoptions"]["srcformat"] = 'Y-m-d H:i:s';
$col["formatoptions"]["newformat"] = 'm/d/Y h:i a';
$cols[] = $col;

$col = array();
$col["name"] = "doctor";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_appointments.`doctor`";
$col["formatter"] = "badge";
$col["edittype"] = "lookup";
$col["isnull"] = "";
$col["editoptions"]["table"] = 'tb_doctors';
$col["editoptions"]["id"] = 'id';
$col["editoptions"]["label"] = 'doctor_name';
$col["editoptions"]["onload"] = array (
  'sql' => 'select distinct id as k, doctor_name as v from tb_doctors',
);
$col["badgeoptions"]["editurl"] = 'index.php?mod=doctors&grid_id=list_doctors&col=id';
$cols[] = $col;

$col = array();
$col["name"] = "appointment_reason";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_appointments.`appointment_reason`";
$cols[] = $col;

$grid->set_columns($cols,true);

$grid_id = "list_appointments";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_appointments";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Appointments Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
