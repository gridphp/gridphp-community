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
$opt["caption"] = "Logistics";
$opt["sortname"] = "id";
$opt["sortorder"] = "ASC";
$opt["readonly"] = false;
$opt["multiselect"] = true;
$opt["scroll"] = false;
$opt["scrollrows"] = false;
$opt["height"] = "70vh";
$opt["autoheight"] = true;
$opt["columnicon"] = true;
$opt["loadComplete"] = "function(o){ if (typeof gridLoad === 'function') gridLoad(o); }";
$opt["onAfterSave"] = "function(){ if (typeof afterSave === 'function') afterSave(); }";
$opt["cellEdit"] = false;
$opt["shrinkToFit"] = false;
$opt["sortable"] = false;
$opt["cmTemplate"]["visible"] = 'xs+';
$opt["cmTemplate"]["editoptions"]["dataEvents"] = array( array (
  'type' => 'loadform change click keyup',
  'fn' => 'function(e){ if (formCallback) formCallback(this,e); }',
) );

// Customize add/edit/view dialogs
$opt["add_options"]["width"] = 800;
$opt["add_options"]["addCaption"] = "Add Logistic";
$opt["add_options"]["success_msg"] = "Logistic added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Logistic";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Logistic updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Logistic";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Logistic deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_logistics";
$grid->select_command = "SELECT tb_logistics.id, tb_logistics.`catering`, tb_logistics.`audio_visual`, tb_logistics.`event` FROM tb_logistics LEFT JOIN tb_events ON tb_events.`id` = tb_logistics.`event` WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_logistics.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_logistics.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_logistics.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "catering";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "badge";
$col["dbname"] = "tb_logistics.`catering`";
$col["frozen"] = true;
$col["edittype"] = "select";
$col["editoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `catering` as k, `catering` as v from tb_logistics");;
$col["stype"] = "select";
$col["searchoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `catering` as k, `catering` as v from tb_logistics");;
$cols[] = $col;

$col = array();
$col["name"] = "audio_visual";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_logistics.`audio_visual`";
$col["formatter"] = "badge";
$col["edittype"] = "select";
$col["editoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `audio_visual` as k, `audio_visual` as v from tb_logistics");;
$col["stype"] = "select";
$col["searchoptions"]["value"] = $grid->get_dropdown_values("SELECT distinct `audio_visual` as k, `audio_visual` as v from tb_logistics");;
$cols[] = $col;

$col = array();
$col["name"] = "event";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_logistics.`event`";
$col["formatter"] = "badge";
$col["edittype"] = "lookup";
$col["isnull"] = "";
$col["editoptions"]["table"] = 'tb_events';
$col["editoptions"]["id"] = 'id';
$col["editoptions"]["label"] = 'title';
$col["editoptions"]["onload"] = array (
  'sql' => 'select distinct id as k, title as v from tb_events',
);
$col["badgeoptions"]["editurl"] = 'index.php?mod=events&grid_id=list_events&col=id';
$cols[] = $col;

$grid->set_columns($cols,true);

$grid_id = "list_logistics";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_logistics";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Logistics Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
