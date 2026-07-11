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
$opt["caption"] = "Post Event Evaluations";
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
$opt["add_options"]["addCaption"] = "Add Post Event Evaluation";
$opt["add_options"]["success_msg"] = "Post Event Evaluation added";
$opt["add_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["width"] = 800;
$opt["edit_options"]["editCaption"] = "Edit Post Event Evaluation";
$opt["edit_options"]["afterShowForm"] = 'function (form) { $("input,select,textarea",form).trigger("loadform"); }';
$opt["edit_options"]["success_msg"] = "Post Event Evaluation updated";
$opt["view_options"]["width"] = 800;
$opt["view_options"]["caption"] = "View Post Event Evaluation";
$opt["view_options"]["beforeShowForm"] = 'function (form) { unlink_dialog_lookup(form);}';
$opt["delete_options"]["success_msg"] = "Post Event Evaluation deleted";

// Make it readonly for restricted role
if (!has_access("editing")) $opt["readonly"] = true;

$grid->set_options($opt);

// grid properties
$grid->table = "tb_post_event_evaluations";
$grid->select_command = "SELECT tb_post_event_evaluations.id, tb_post_event_evaluations.`evaluation_date`, tb_post_event_evaluations.`feedback`, tb_post_event_evaluations.`event` FROM tb_post_event_evaluations LEFT JOIN tb_events ON tb_events.`id` = tb_post_event_evaluations.`event` WHERE 1=1 ";


// column settings
$cols = array();

$col = array();
$col["name"] = "id";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_post_event_evaluations.`id`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "updated_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_post_event_evaluations.`updated_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "created_at";
$col["width"] = 150;
$col["hidden"] = true;
$col["dbname"] = "tb_post_event_evaluations.`created_at`";
$col["frozen"] = true;
$cols[] = $col;

$col = array();
$col["name"] = "evaluation_date";
$col["width"] = 150;
$col["editable"] = true;
$col["formatter"] = "date";
$col["dbname"] = "tb_post_event_evaluations.`evaluation_date`";
$col["frozen"] = true;
$col["formatoptions"]["srcformat"] = 'Y-m-d';
$col["formatoptions"]["newformat"] = 'm/d/Y';
$cols[] = $col;

$col = array();
$col["name"] = "feedback";
$col["width"] = 200;
$col["editable"] = true;
$col["dbname"] = "tb_post_event_evaluations.`feedback`";
$col["edittype"] = "textarea";
$col["editoptions"]["style"] = 'height:150px';
$cols[] = $col;

$col = array();
$col["name"] = "event";
$col["width"] = 150;
$col["editable"] = true;
$col["dbname"] = "tb_post_event_evaluations.`event`";
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

$grid_id = "list_post_event_evaluations";

// template variables
$var = array();
$var["out"] = $grid->render($grid_id);
$var["grid_id"] = "list_post_event_evaluations";
$var["grid_theme"] = "base";
$var["locale"] = "en";
$var["form_title"] = "Post Event Evaluations Management";
$var["form_details"] = "";
$var["tab_class"] = "";


// if loaded in iframe, use content layout (without header)
if ($_GET["iframe"] == "1")
	$layout = "content";

return $var;
