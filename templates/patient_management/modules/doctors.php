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
$opt["caption"] = "Doctors";
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
$opt["add_options"]["addCaption"] = "Add Doctor";
$opt["add_options"]["success_msg"] = "Doctor added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Doctor";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Doctor updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Doctor";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Doctor deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_doctors";
$grid->select_command = "SELECT tb_doctors.id, tb_doctors.`doctor_name`, tb_doctors.`specialization`, tb_doctors.`contact_number`, tb_doctors.`email` FROM tb_doctors  WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_doctors.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_doctors.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_doctors.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "doctor_name";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "rowbar";
$col["dbname"] = "tb_doctors.`doctor_name`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "specialization";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_doctors.`specialization`";
$col["formatter"] = "badge";
$col["edittype"] = "select";
$col["editoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `specialization` as k, `specialization` as v from tb_doctors");;
$col["stype"] = "select";
$col["searchoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `specialization` as k, `specialization` as v from tb_doctors");;
$cols[] = $col;

$col = array();
$col["name"] = "contact_number";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_doctors.`contact_number`";
$col["formatter"] = "phone";
$cols[] = $col;

$col = array();
$col["name"] = "email";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_doctors.`email`";
$col["formatter"] = "email";
$cols[] = $col;

$grid->set_columns($cols,true);

$grid_id = "list_doctors";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_doctors";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Doctors Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
