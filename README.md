# PHP Data Grid | PHP CRUD Admin Panel Framework

## Overview

GridPHP is an enterprise-ready, low-code PHP Data Grid framework designed for building lightning-fast database admin panels, CRMs, and backoffice tools. It generates fully interactive, mobile-responsive CRUDs automatically from database tables with no HTML/CSS/JavaScript boilerplate required. It supports MySQL, PostgreSQL / Supabase, Oracle, SQL Server and integrates seamlessly with Laravel, WordPress and CodeIgniter.


---

### 📺 Feature Video Tour

Discover how to build functional CRUD grids with advanced multi-level master-detail interactions, real-time filters, and clean schema deployments in under a minute:

<a href="https://www.gridphp.com/wp-content/uploads/prod-demo-v3.1.mp4?_=1" target="_blank">
  <img src="https://i.vgy.me/fH4oH8.png" alt="Watch the GridPHP Feature Tour" width="100%" />
</a>

---

## 🖥️ Running the Demo Browser

You can spin up and explore an interactive local suite containing dozens of functional implementation templates instantly. The package bundles a pre-configured SQLite database that requires zero backend environment configuration or schema installation.

To run the demo browser locally:

1. Clone the repository structure into your local server environment root:
```bash
git clone https://github.com/gridphp/gridphp-community

```

2. Start your local built-in PHP development server target from inside the project directory:
```bash
cd gridphp-community
php -S localhost:8080

```

3. Open your browser and navigate directly to `http://localhost:8080` to interact with the dashboards.

**Note:** In case of permission error on installation step, make sure the folder have write permission for the web user. e.g. run: `chown apache.apache gridphp-community -R`

## Licensing

GridPHP is available in Free Community version, Developer, and Enterprise licenses. 

* **Free Version:** **Free for commercial use.** It includes all essential CRUD features, sorting, paging, filtering, and standard community support. Perfect for small local projects, functional MVPs, and evaluations. It comes with a **14-day trial of advanced features**. After this duration, continued use of advanced features will generate a notice and watermark on the grid layout.
  
* **Commercial Version (Developer & Enterprise):** Includes a pay-once, use-forever lifetime software license with full source code access, advanced features like AI Data Insights, Excel/PDF imports and exports, multi-level hierarchical grids, custom file uploading, and priority engineering support tickets.

### Features Matrix

| Feature | Free Version | Developer License ($99) | Enterprise License ($399) |
| --- | --- | --- | --- |
| **Basic CRUD Operations** (Add, Edit, Delete) | ✅ | ✅ | ✅ |
| **Grid Customization** (Sorting, Pagination, Filtering) | ✅ | ✅ | ✅ |
| **Database Support** (MySQL, Postgres, SQL Server, Oracle) | ✅ | ✅ | ✅ |
| **AI Data Insights Layer** (Natural Language Queries) | 14-Day Trial | ✅ | ✅ (Advanced) |
| **Pre-built Application Templates** | 14-Day Trial | ✅ | ✅ |
| **Advanced Form Plugins** (Daterange, Auto-complete, RichText) | Notice/Watermark | ✅ | ✅ |
| **Advanced Layouts** (N-Level Master-Detail / Hierarchical Grids) | Notice/Watermark | ✅ | ✅ |
| **Data Portability** (Excel, PDF, CSV Export & CSV Import) | CSV Only | ✅ | ✅ |
| **File Uploading** (Single & Multi-file management) | Notice/Watermark | ✅ | ✅ |
| **White-labeling** (Remove branding & upgrade notices) | ❌ | ✅ | ✅ |
| **Projects & Developers Covered** | Unlimited | Solo / 1 Dev | Unlimited / Teams |
| **Source Code Access** | Obfuscated | Full Source Code | Full Source Code |
| **Dedicated Technical Support** | Forum Only | 6 Months (10 Incidents) | 12 Months Priority + Remote Help |

> **Note:** Visit the GridPHP Pricing & Plans page for a comprehensive feature-by-feature comparison breakdown.

### Application Starter Templates

Paid licenses gain instant access to production-ready, cloneable starters designed for typical internal web application workflows:
* **Authentication & Role-Based Access Controls (RBAC):** Restrict editing capabilities depending on user roles.
* **KPI Dashboards & Interactive Charts:** Visualize tabular structures automatically via clean metrics wrappers.
* **Patient / Inventory / Expense Trackers:** Niche pre-built schema-ready profiles for immediate domain deployment.

## ⚡️ Quick Start

Creating your first interactive data grid requires nothing more than basic database credentials and mapping the target table identifier.

### Step 1: Initialize & Configure Database Connection

Pass your connection context arrays into the configuration block before rendering:

```php
define("PHPGRID_DBTYPE","mysqi"); 
define("PHPGRID_DBHOST","localhost");
define("PHPGRID_DBUSER","db_user");
define("PHPGRID_DBPASS","db_pass");
define("PHPGRID_DBNAME","your_db_name");
```

### Step 2: Include Library & Container

Load the GridPHP dependencies into your file structure layout and map an HTML root node for viewport target output:

```php
<?php
// Include the db config
include_once("config.php");

// Include the GridPHP core package library code
include_once("lib/inc/jqgrid_dist.php");

// Instantiate your Grid engine object container
$grid = new jqgrid();

```

### Step 3: Define Table & Render

Map structural properties and output clean compiled variables within the responsive presentation layouts:

```php
// Define primary master table source target
$grid->table = "clients";
$grid->select_command = "SELECT id, name, company, reg_date, balance FROM clients";

// Set global operational parameters 
$opt["rowNum"] = 20;        // Initial row visibility counts
$grid->set_options($opt);

// Compile server configurations into HTML/JS wrappers
$output = $grid->render("my_first_grid");

```
### Step 4: Embed Dependencies & Output Presentation Layer

Link your required frontend styles and runtime engine scripts, then output the compiled PHP data grid block cleanly where you want it to render inside your application viewport.

```html
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
## 🛠️ Customizations & Integrations

### Framework & Backend Compatibility

GridPHP does not dictate application framework rules. It drops directly into:

* **Vanilla Core PHP Scripts** with simple zero-dependency procedural file loops.
* **Laravel / CodeIgniter Controllers** by loading grid render pipelines straight to framework views.
* **Supabase / Managed Server Ecosystems** by passing the remote PostgreSQL connection credentials directly into the data matrix context.


### Built-In Themes

GridPHP packs 34 pre-built visual layout configurations, matching your existing application colors instantly. Layout adjustments run on responsive frameworks, offering unified styling out-of-the-box, alongside complete configuration access via the jQueryUI ThemeRoller ecosystem.

---

## 🤝 Support & Licensing

### Plans

* **Free Version:** Distributed under standard evaluation paradigms. Includes access to our public documentation and community forums.
* **Developer License ($99):** Single developer access seat covering unlimited software deployments. Features full source access and 6 months of direct support tickets.
* **Enterprise License ($399):** Built for larger agile agency architectures. Provides priority ticketing desks, team seats, product updates for 12 months, and screen-sharing setup calls.

### Priority Support

Paid accounts unlock access to our formal engineering ticketing tracking system. Bug profiles, structural optimization reviews, or migration assistance queries receive dedicated troubleshooting attention within 2 business days.
