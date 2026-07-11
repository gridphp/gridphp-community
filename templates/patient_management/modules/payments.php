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
$opt["caption"] = "Payments";
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
$opt["add_options"]["addCaption"] = "Add Payment";
$opt["add_options"]["success_msg"] = "Payment added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Payment";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Payment updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Payment";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Payment deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_payments";
$grid->select_command = "SELECT tb_payments.id, tb_payments.`patient`, tb_payments.`payment_date`, tb_payments.`payment_amount`, tb_payments.`payment_method` FROM tb_payments LEFT JOIN tb_patients ON tb_patients.`id` = tb_payments.`patient` WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_payments.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_payments.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_payments.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "patient";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "badge";
$col["dbname"] = "tb_payments.`patient`";
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
$col["name"] = "payment_date";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_payments.`payment_date`";
$col["formatter"] = "date";
$col["formatoptions"]["srcformat"] = 'Y-m-d';
$col["formatoptions"]["newformat"] = 'm/d/Y';
$cols[] = $col;

$col = array();
$col["name"] = "payment_amount";
$col["width"] = 100;
$col["editable"] = true;
$col["dbname"] = "tb_payments.`payment_amount`";
$col["editoptions"]["type"] = 'number';
$col["formatter"] = "currency";
$cols[] = $col;

$col = array();
$col["name"] = "payment_method";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_payments.`payment_method`";
$col["formatter"] = "badge";
$col["edittype"] = "select";
$col["editoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `payment_method` as k, `payment_method` as v from tb_payments");;
$col["stype"] = "select";
$col["searchoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `payment_method` as k, `payment_method` as v from tb_payments");;
$cols[] = $col;

$grid->set_columns($cols,true);

$grid_id = "list_payments";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_payments";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Payments Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
