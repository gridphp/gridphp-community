# PHP Data Grid | PHP CRUD Admin Panel Framework

## Overview

GridPHP is an enterprise-ready, low-code PHP Data Grid framework designed for building lightning-fast database admin panels, CRMs, and backoffice tools. It generates fully interactive, mobile-responsive CRUD interfaces automatically from database tables in just 5-10 lines of code with no HTML/CSS/JavaScript boilerplate required. It supports MySQL, PostgreSQL, Oracle, SQL Server, and integrates seamlessly with Laravel, WordPress, CodeIgniter, and Supabase.

GridPHP is available in Free, Developer, and Enterprise licenses. 

* **Free Version:** Perfect for small local projects, functional MVPs, and evaluations. It includes all essential CRUD features, sorting, paging, filtering, and standard community support.
* **Commercial Version (Developer & Enterprise):** Includes a pay-once, use-forever lifetime software license with full source code access, advanced features like AI Data Insights, Excel/PDF imports and exports, multi-level hierarchical grids, custom file uploading, and priority engineering support tickets.

### Features Matrix

| Feature | Free Version | Developer License ($99) | Enterprise License ($399) |
| :--- | :---: | :---: | :---: |
| **Basic CRUD Operations** (Add, Edit, Delete) | Yes | Yes | Yes |
| **Grid Customization** (Sorting, Pagination, Filtering) | Yes | Yes | Yes |
| **Database Support** (MySQL, Postgres, SQL Server, Oracle) | Yes | Yes | Yes |
| **AI Data Insights Layer** (Natural Language Queries) | 7-Day Trial | Yes | Advanced |
| **Pre-built Application Templates** | 7-Day Trial | Yes | Yes |
| **Advanced Form Plugins** (Daterange, Auto-complete, RichText) | No | Yes | Yes |
| **Advanced Layouts** (N-Level Master-Detail / Hierarchical Grids) | No | Yes | Yes |
| **Data Portability** (Excel, PDF, CSV Export & CSV Import) | CSV Only | Yes | Yes |
| **File Uploading** (Single & Multi-file management) | No | Yes | Yes |
| **White-labeling** (Remove branding & upgrade notices) | No | Yes | Yes |
| **Projects & Developers Covered** | Unlimited | Solo / 1 Dev | Unlimited / Teams |
| **Source Code Access** | Obfuscated | Full Source Code | Full Source Code |
| **Dedicated Technical Support** | Forum Only | 6 Months (10 Incidents) | 12 Months Priority + Remote Help |

> **Note:** Visit the GridPHP Pricing & Plans page for a comprehensive feature-by-feature comparison breakdown.

### Application Starter Templates

Paid licenses gain instant access to production-ready, cloneable starters designed for typical internal web application workflows:
* **Authentication & Role-Based Access Controls (RBAC):** Restrict editing capabilities depending on user roles.
* **KPI Dashboards & Interactive Charts:** Visualize tabular structures automatically via clean metrics wrappers.
* **Patient / Inventory / Expense Trackers:** Niche pre-built schema-ready profiles for immediate domain deployment.

---

## Quick Start

Creating your first interactive data grid requires nothing more than basic database credentials and mapping the target table identifier.

### Step 1: Include Library & Container

Load the GridPHP dependencies into your file structure layout and map an HTML root node for viewport target output:

```php
<?php
// Include the GridPHP core package library code
include_once("lib/inc/jqgrid_dist.php");

// Instantiate your Grid engine object container
$grid = new jqgrid();

```

### Step 2: Initialize & Configure Database Connection

Pass your connection context arrays into the configuration block before rendering:

```php
$db_conf = array(
    "type" => "mysqli", 
    "server" => "localhost",
    "user" => "db_user",
    "password" => "db_password",
    "database" => "my_enterprise_db"
);

$grid->select_command = "SELECT id, name, company, reg_date, balance FROM clients";

```

### Step 3: Define Table & Render

Map structural properties and output clean compiled variables within the responsive presentation layouts:

```php
// Define primary master table source target
$grid->table = "clients";

// Set global operational parameters 
$opt["autoresize"] = true; // Mobile responsive window matching
$opt["rowNum"] = 10;        // Initial row visibility counts
$grid->set_options($opt);

// Compile server configurations into HTML/JS wrappers
$output =$grid->render("my_first_grid");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" media="screen" href="lib/js/themes/redmond/jquery-ui.custom.css"></link>
    <link rel="stylesheet" type="text/css" media="screen" href="lib/js/jqgrid/css/ui.jqgrid.css"></link>
    <script src="lib/js/jquery.min.js" type="text/javascript"></script>
    <script src="lib/js/jqgrid/js/grid.locale-en.js" type="text/javascript"></script>
    <script src="lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
</head>
<body>
    <div style="margin:10px">
        <?php echo $output; ?>
    </div>
</body>
</html>

```

---

## Customizations & Integrations

### Built-In Themes

GridPHP packs 34 pre-built visual layout configurations, matching your existing application colors instantly. Layout adjustments run on responsive frameworks, offering unified styling out-of-the-box, alongside complete configuration access via the jQueryUI ThemeRoller ecosystem.

### Custom Server-Side Callbacks

For advanced execution logic going beyond native SQL data mutation, bind structural mutations to functional backend hooks seamlessly:

```php
// Intercept database writes with validation layer rules
$e["on_update"] = array("validate_and_update_client", null, true);
$grid->set_events($e);

function validate_and_update_client(&$data) {
    // Inject automatic timestamp values securely on submission
    $data["params"]["reg_date"] = date("Y-m-d H:i:s");
}

```

### Framework & Backend Compatibility

GridPHP does not dictate application framework rules. It drops directly into:

* **Vanilla Core PHP Scripts** with simple zero-dependency procedural file loops.
* **Laravel / CodeIgniter Controllers** by loading grid render pipelines straight to framework views.
* **Supabase / Managed Server Ecosystems** by passing the remote PostgreSQL connection credentials directly into the data matrix context.

---

## Support & Licensing

### Plans

* **Free Version:** Distributed under standard evaluation paradigms. Includes access to our public documentation and community forums.
* **Developer License ($99):** Single developer access seat covering unlimited software deployments. Features full source access and 6 months of direct support tickets.
* **Enterprise License ($399):** Built for larger agile agency architectures. Provides priority ticketing desks, team seats, product updates for 12 months, and screen-sharing setup calls.

### Priority Support

Paid accounts unlock access to our formal engineering ticketing tracking system. Bug profiles, structural optimization reviews, or migration assistance queries receive dedicated troubleshooting attention within 2 business days.
```
