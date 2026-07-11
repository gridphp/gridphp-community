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
$opt["caption"] = "Patients";
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
$opt["add_options"]["addCaption"] = "Add Patient";
$opt["add_options"]["success_msg"] = "Patient added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Patient";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Patient updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Patient";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Patient deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_patients";
$grid->select_command = "SELECT tb_patients.id, tb_patients.`patient_name`, tb_patients.`date_of_birth`, tb_patients.`contact_number`, tb_patients.`email`, tb_patients.`address`, tb_patients.`blood_group`, tb_patients.`medical_history`, tb_patients.`allergies` FROM tb_patients  WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_patients.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_patients.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_patients.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "patient_name";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "rowbar";
$col["dbname"] = "tb_patients.`patient_name`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "date_of_birth";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`date_of_birth`";
$col["formatter"] = "date";
$col["formatoptions"]["srcformat"] = 'Y-m-d';
$col["formatoptions"]["newformat"] = 'm/d/Y';
$cols[] = $col;

$col = array();
$col["name"] = "contact_number";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`contact_number`";
$col["formatter"] = "phone";
$cols[] = $col;

$col = array();
$col["name"] = "email";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`email`";
$col["formatter"] = "email";
$cols[] = $col;

$col = array();
$col["name"] = "address";
$col["width"] = 200;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`address`";
$col["edittype"] = "textarea";
$col["editoptions"]["style"] = 'height:150px';
$cols[] = $col;

$col = array();
$col["name"] = "blood_group";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`blood_group`";
$col["formatter"] = "badge";
$col["edittype"] = "select";
$col["editoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `blood_group` as k, `blood_group` as v from tb_patients");;
$col["stype"] = "select";
$col["searchoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `blood_group` as k, `blood_group` as v from tb_patients");;
$cols[] = $col;

$col = array();
$col["name"] = "medical_history";
$col["width"] = 200;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`medical_history`";
$col["edittype"] = "textarea";
$col["editoptions"]["style"] = 'height:150px';
$cols[] = $col;

$col = array();
$col["name"] = "allergies";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_patients.`allergies`";
$cols[] = $col;

$grid->set_columns($cols,true);

$grid_id = "list_patients";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_patients";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Patients Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
