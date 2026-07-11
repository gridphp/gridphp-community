<?php
/**
 * jqGrid Dashboard api
 * @author Abu Ghufran (www.gridphp.com)
 * @since 08-Oct-2025
 */

class jqgrid_dash {
 
    // show errors
    var $ignore_error = false;
    var $debug = PHPGRID_DEBUG || false;

	/**
	 * Contructor to set default params
	 */
	function __construct($db_conf = null)
	{
		// defined check for backward compatibility
		if ($db_conf == null)
		{
			if (defined("PHPGRID_DBTYPE"))
			{
				// make new connection from config.php constants
				$db_conf = array();
				$db_conf["type"] = PHPGRID_DBTYPE;
				$db_conf["server"] = PHPGRID_DBHOST;
				$db_conf["user"] = PHPGRID_DBUSER;
				$db_conf["password"] = PHPGRID_DBPASS;
				$db_conf["database"] = PHPGRID_DBNAME;
			}
		}

		// set default charset to utf8
		if (defined("PHPGRID_DBCHARSET"))
			$this->charset = PHPGRID_DBCHARSET;
		else
			$this->charset = "utf8";

		// use adodb layer to support non-mysql dbs
		if ($db_conf)
		{
			// make lower case for adodb file inclusion (in case of typo)
			$db_conf["type"] = strtolower($db_conf["type"]);

			// set up DB
			include_once(dirname(__FILE__)."/adodb/adodb.inc.php");
			$driver = $db_conf["type"];
			$this->con = ADONewConnection($driver); # eg. 'mysql,oci8(for oracle),mssql,postgres,sybase'
			$this->con->SetFetchMode(ADODB_FETCH_ASSOC);
			$this->con->debug = 0;
			$this->con->charSet = $this->charset;

			// set port if exist
			if (isset($db_conf["port"]))
				$this->con->port = $db_conf["port"];

			$r = $this->con->Connect($db_conf["server"], $db_conf["user"], $db_conf["password"], $db_conf["database"]);

			// missing extension check
			if ($r===0) phpgrid_error("You need to enable php extension '".$this->con->dataProvider."' first.");

			// if connection failed
			if (!$r)  phpgrid_error("Please check your database connection configuration. ".$this->con->ErrorMsg());

			// set your db encoding -- for ascent chars (if required)
			if ($db_conf["type"] == "mysql" || $db_conf["type"] == "mysqli" || ($db_conf["type"]=="pdo" && strstr($db_conf["server"],"mysql")!==false) )
				$this->con->Execute("SET NAMES '".$this->charset."'");

			$this->db_driver = $db_conf["type"];

			// set server for strstr match in case of pdo
			if ($this->db_driver == "pdo")
				$this->db_driver = $db_conf["server"];

			$this->db_conf = $db_conf;
		}
    }

	/**
	 * Common functions for db operations
	 */
	function execute_query($sql,$data = false,$return="")
	{
        $ret = false;
		if ($this->con)
		{
			$ret = $this->con->Execute($sql,$data);
            if (!$ret)
			{
				// suppress error message if desired
				if ($this->ignore_error)
					return false;

				if ($this->debug)
					phpgrid_error("Couldn't execute query. ".$this->con->ErrorMsg()." - $sql");
				else
					phpgrid_error($this->error_msg);
			}

			if ($return == "insert_id")
			{
				// for informix
				if(substr($this->db_driver, 0, strlen("informix:")) === "informix:")
					return $this->get_one("SELECT first 1 greatest(DBINFO( 'sqlca.sqlerrd1' ), DBINFO( 'bigserial' )) as id FROM systables;")["id"];
				else
					return $this->con->Insert_ID();
			}
		}

		return $ret;
	}

	function get_one($sql,$data = false)
	{
		$res = $this->execute_query($sql,$data);
		if (!$res) return false;
		
		$rs = $res->getrows();
		return $rs[0];
	}

	function get_all($sql,$data = false)
	{
		$res = $this->execute_query($sql,$data);
		if (!$res) return false;
		
		$rs = $res->getrows();
		return $rs;
	}

    function get_kpi_value($title,$sql)
    {
        $rs = $this->get_one($sql);
        return array("label"=>$title,"value"=>$rs[array_key_first($rs)]);   
    }

    function get_table($title,$sql)
    {
        $arr = $this->get_all($sql);
        return array("title"=>$title, "content"=>$this->array_to_table($arr));
    }

    function get_bar_chart($title,$sql)
    {
        $arr = $this->get_all($sql);
        return array("title"=>$title, "content"=>$this->get_chart($arr,array("type"=>"bar")));
    }

    function get_pie_chart($title,$sql)
    {
        $arr = $this->get_all($sql);
        return array("title"=>$title, "content"=>$this->get_chart($arr,array("type"=>"pie")));
    }

    // Generate chart based on api
    function get_chart($arr, $options = [], $api = 'echarts') {
        // Default options
        $defaults = [
            'type' => 'bar',           // bar, line, pie, doughnut
            'title' => '',
            'width' => '100%',
            'height' => '400px',
            // 'colors' => ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#06b6d4'], // pro
            // 'colors' => ['#2196f3', '#4caf50', '#ff9800', '#9c27b0', '#f44336', '#00bcd4'], // material
            // 'colors' => array('#8370fe','#5e47df','#67bfff','#3fc973','#e6e8eb'), // violet,blue,green,gray
            // 'colors' => array('#346ee0','#20b799','#fa5944','#efb540','#e9ecef'), // blue,green,red,yellow,gray
            'colors' => array('#346ee0','#20b799','#fa5944','#efb540','#5e47df'), // blue,green,red,yellow,gray
            'x_key' => null,           // Key for x-axis (labels)
            'y_key' => null,           // Key for y-axis (values)
        ];
        $options = array_merge($defaults, $options);
        
        // Generate unique ID for chart
        $chartId = 'chart_' . uniqid();
        
        // Prepare data - handle different array structures
        $labels = [];
        $values = [];
        $xKey = null;
        $yKey = null;
        
        // Check if array is 2D (has sub-arrays)
        $firstElement = reset($arr);
        if (is_array($firstElement)) {
            // 2D array - extract x and y values
            $xKey = isset($options['x_key']) ? $options['x_key'] : array_keys($firstElement)[0];
            $yKey = isset($options['y_key']) ? $options['y_key'] : array_keys($firstElement)[1];
            
            foreach ($arr as $row) {
                $labels[] = isset($row[$xKey]) ? $row[$xKey] : '';
                $values[] = floatval(isset($row[$yKey]) ? $row[$yKey] : 0);
            }
        } else {
            // Simple key-value array
            $labels = array_keys($arr);
            $values = array_values($arr);
            $xKey = 'Label';
            $yKey = 'Value';
        }
        
        // Capitalize axis titles
        $xAxisTitle = ucwords(str_replace('_', ' ', $xKey));
        $yAxisTitle = ucwords(str_replace('_', ' ', $yKey));
        
        // Add axis titles to options for use in chart functions
        $options['x_axis_title'] = $xAxisTitle;
        $options['y_axis_title'] = $yAxisTitle;
        
        // Route to appropriate chart library
        switch (strtolower($api)) {
            case 'google':
            case 'googlecharts':
                return $this->get_google_chart($labels, $values, $chartId, $options);
            case 'echarts':
                return $this->get_echarts_chart($labels, $values, $chartId, $options);
            case 'chartjs':
            default:
                return $this->get_chartjs_chart($labels, $values, $chartId, $options);
        }
    }

    // Chart.js Implementation
    function get_chartjs_chart($labels, $values, $chartId, $options) {
        static $chartjs_loaded = false;
        
        $labelsJson = json_encode($labels);
        $valuesJson = json_encode($values);
        $colorsJson = json_encode($options['colors']);
        
        $html = '';
        
        // Load library only once
        if (!$chartjs_loaded) {
            $html .= '<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>';
            $chartjs_loaded = true;
        }
        
        $html .= '<div style="width: ' . $options['width'] . '; height: ' . $options['height'] . ';">';
        $html .= '<canvas id="' . $chartId . '"></canvas>';
        $html .= '</div>';
        
        $xAxisTitle = htmlspecialchars($options['x_axis_title']);
        $yAxisTitle = htmlspecialchars($options['y_axis_title']);
        
        $html .= '<script>
        (function() {
            var ctx = document.getElementById("' . $chartId . '");
            if (!ctx) return;
            ctx = ctx.getContext("2d");
            var colors = ' . $colorsJson . ';
            
            new Chart(ctx, {
                type: "' . $options['type'] . '",
                data: {
                    labels: ' . $labelsJson . ',
                    datasets: [{
                        label: "' . htmlspecialchars($options['title']) . '",
                        data: ' . $valuesJson . ',
                        backgroundColor: "' . $options['type'] . '" === "bar" ? colors[0] : colors,
                        // borderColor: colors[0],
                        borderWidth: 0,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: ' . ($options['type'] === 'pie' || $options['type'] === 'doughnut' ? 'true' : 'false') . ',
                            position: "top",
                            labels: {
                                font: { size: 12 },
                                color: "#666",
                                padding: 15
                            }
                        },
                        title: {
                            display: ' . (empty($options['title']) ? 'false' : 'true') . ',
                            text: "' . htmlspecialchars($options['title']) . '",
                            font: { size: 16, weight: "600" },
                            color: "#333",
                            padding: 20
                        },
                        tooltip: {
                            backgroundColor: "rgba(0,0,0,0.8)",
                            padding: 12,
                            titleFont: { size: 14 },
                            bodyFont: { size: 13 },
                            cornerRadius: 4
                        }
                    },
                    scales: ' . ($options['type'] === 'pie' || $options['type'] === 'doughnut' ? '{}' : '{
                        y: {
                            beginAtZero: true,
                            grid: { color: "#f0f0f0" },
                            ticks: { 
                                color: "#666",
                                font: { size: 11 }
                            },
                            title: {
                                display: true,
                                text: "' . $yAxisTitle . '",
                                color: "#333",
                                font: { size: 12, weight: "bold" }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: "#666",
                                font: { size: 11 }
                            },
                            title: {
                                display: true,
                                text: "' . $xAxisTitle . '",
                                color: "#333",
                                font: { size: 12, weight: "bold" }
                            }
                        }
                    }') . '
                }
            });
        })();
        </script>';
        
        return $html;
    }

    // Google Charts Implementation
    function get_google_chart($labels, $values, $chartId, $options) {
        static $google_loaded = false;
        
        $html = '';
        
        // Load library only once
        if (!$google_loaded) {
            $html .= '<script src="https://www.gstatic.com/charts/loader.js"></script>';
            $html .= '<script>google.charts.load("current", {packages: ["corechart"]});</script>';
            $google_loaded = true;
        }
        
        // Prepare data for Google Charts
        $dataRows = [];
        for ($i = 0; $i < count($labels); $i++) {
            $label = addslashes($labels[$i]);
            $value = floatval($values[$i]);
            $dataRows[] = "['" . $label . "', " . $value . "]";
        }
        $dataRowsStr = implode(', ', $dataRows);
        
        // Map chart types
        $chartTypeMap = [
            'bar' => 'ColumnChart',
            'line' => 'LineChart',
            'pie' => 'PieChart',
            'doughnut' => 'PieChart'
        ];
        $googleChartType = isset($chartTypeMap[$options['type']]) ? $chartTypeMap[$options['type']] : 'ColumnChart';
        
        $html .= '<div id="' . $chartId . '" style="width: ' . $options['width'] . '; height: ' . $options['height'] . ';"></div>';
        
        $pieHole = ($options['type'] === 'doughnut') ? 'pieHole: 0.4,' : '';
        
        $xAxisTitle = htmlspecialchars($options['x_axis_title']);
        $yAxisTitle = htmlspecialchars($options['y_axis_title']);
        
        $html .= '<script>
        google.charts.setOnLoadCallback(function() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "' . $xAxisTitle . '");
            data.addColumn("number", "' . $yAxisTitle . '");
            data.addRows([' . $dataRowsStr . ']);
            
            var options = {
                title: "' . htmlspecialchars($options['title']) . '",
                titleTextStyle: { 
                    color: "#333", 
                    fontSize: 16, 
                    bold: true 
                },
                colors: ' . json_encode($options['colors']) . ',
                legend: { 
                    position: ' . ($options['type'] === 'pie' || $options['type'] === 'doughnut' ? '"top"' : '"none"') . '
                },
                backgroundColor: "white",
                chartArea: { width: "85%", height: "70%" },
                ' . $pieHole . '
                hAxis: { 
                    title: "' . $xAxisTitle . '",
                    textStyle: { color: "#666", fontSize: 11 },
                    titleTextStyle: { color: "#333", fontSize: 12, bold: true }
                },
                vAxis: { 
                    title: "' . $yAxisTitle . '",
                    textStyle: { color: "#666", fontSize: 11 },
                    titleTextStyle: { color: "#333", fontSize: 12, bold: true },
                    gridlines: { color: "#f0f0f0" },
                    minValue: 0
                },
                tooltip: { 
                    textStyle: { fontSize: 12 }
                }
            };
            
            var chart = new google.visualization.' . $googleChartType . '(document.getElementById("' . $chartId . '"));
            chart.draw(data, options);
        });
        </script>';
        
        return $html;
    }

    // ECharts Implementation
    function get_echarts_chart($labels, $values, $chartId, $options) {
        static $echarts_loaded = false;
        
        $labelsJson = json_encode($labels);
        $valuesJson = json_encode($values);
        $colorsJson = json_encode($options['colors']);
        
        $html = '';
        
        // Load library only once
        if (!$echarts_loaded) {
            $html .= '<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>';
            $echarts_loaded = true;
        }
        
        $html .= '<div id="' . $chartId . '" style="width: ' . $options['width'] . '; height: ' . $options['height'] . ';"></div>';
        
        // Map chart types
        $echartsType = $options['type'];
        if ($options['type'] === 'doughnut') $echartsType = 'pie';
        
        $xAxisTitle = htmlspecialchars($options['x_axis_title']);
        $yAxisTitle = htmlspecialchars($options['y_axis_title']);
        
        // Build chart configuration
        if ($options['type'] === 'pie' || $options['type'] === 'doughnut') {
            $seriesData = [];
            for ($i = 0; $i < count($labels); $i++) {
                $seriesData[] = ['name' => $labels[$i], 'value' => $values[$i]];
            }
            $seriesDataJson = json_encode($seriesData);
            $radius = ($options['type'] === 'doughnut') ? "['40%', '70%']" : "'70%'";
            
            $chartConfig = '{
                title: {
                    text: "' . htmlspecialchars($options['title']) . '",
                    left: "center",
                    textStyle: { color: "#333", fontSize: 16, fontWeight: 600 }
                },
                color: ' . $colorsJson . ',
                tooltip: {
                    trigger: "item",
                    formatter: "{b}: {c} ({d}%)",
                    backgroundColor: "rgba(0,0,0,0.8)",
                    textStyle: { color: "#fff" }
                },
                legend: {
                    type: manyLabels ? "scroll" : "plain",
                    pageButtonItemGap: 5,
                    pageButtonGap: 20,
                    pageIconSize: 18,
                    pageTextStyle: {
                        color: "#666"
                    },
                    // orient: "vertical",
                    // right: 10,
                    // top: "center",
                    top: "top",
                    textStyle: { color: "#666", fontSize: 12 }
                    
                },
                series: [{
                    type: "pie",
                    radius: ' . $radius . ',
                    data: ' . $seriesDataJson . ',
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)"
                        }
                    },
                    label: {
                        color: "#FFF",
                        fontSize: 12,
                        position: "inside",           // Move labels inside the pie slices
                        formatter: function(params) {
                            return Math.round(params.percent) + "%";  // Round to nearest whole number
                        }
                    }
                }]
            }';
        } else {
            $chartConfig = '{
                title: {
                    text: "' . htmlspecialchars($options['title']) . '",
                    left: "center",
                    textStyle: { color: "#333", fontSize: 16, fontWeight: 600 }
                },
                color: ' . $colorsJson . ',
                tooltip: {
                    trigger: "axis",
                    backgroundColor: "rgba(0,0,0,0.8)",
                    textStyle: { color: "#fff" }
                },
                grid: {
                    left: "10%",
                    right: "5%",
                    bottom: manyLabels ? (isMobile ? "32%" : "24%") : "16%",  // More space if zoom exists
                    top: "5%"
                },
                dataZoom: manyLabels ? [
                    {
                        type: "slider",
                        show: true,
                        xAxisIndex: [0],
                        height: 25,
                        start: 0,
                        end: isMobile < 768 ? 50 : 100,  // Show 50% on mobile, 100% on desktop
                        fillerColor: "rgba(22, 110, 225, 0.1)",  // Selected area background
                    },
                    {
                        type: "inside",  // Allow mouse wheel/touch scrolling
                        xAxisIndex: [0],
                        start: 0,
                        end: isMobile < 768 ? 50 : 100
                    }
                ] : [],
                xAxis: {
                    type: "category",
                    name: "' . $xAxisTitle . '",
                    nameLocation: "middle",
                    nameGap: manyLabels ? 65 : 50,
                    nameTextStyle: { color: "#333", fontSize: 12, fontWeight: 600 },
                    data: ' . $labelsJson . ',
                    axisLabel: { 
                        color: "#666", 
                        fontSize: 11, 
                        interval:0, 
                        rotate:30,
                        formatter: function(value) {   // Truncate long labels
                            return value.length > 12 ? value.substr(0, 11) + "..." : value;
                        }
                    },
                    axisLine: { lineStyle: { color: "#ddd" } }
                },
                yAxis: {
                    type: "value",
                    name: "' . $yAxisTitle . '",
                    nameLocation: "middle",
                    nameGap: 50,
                    nameTextStyle: { color: "#333", fontSize: 12, fontWeight: 600 },
                    axisLabel: { color: "#666", fontSize: 11 },
                    axisLine: { lineStyle: { color: "#ddd" } },
                    splitLine: { lineStyle: { color: "#f0f0f0" } }
                },
                series: [{
                    data: ' . $valuesJson . ',
                    type: "' . $echartsType . '",
                    smooth: true,
                    itemStyle: { borderRadius: 4 },
                    emphasis: { focus: "series" }
                }]
            }';
        }
        
        $html .= '<script>
        (function() {
            var chartDom = document.getElementById("' . $chartId . '");
            if (!chartDom) return;
            var myChart = echarts.init(chartDom);

            // for medium screen, stop initial animation
            if (window.innerWidth >= 768 && window.innerWidth <= 1200)
                new ResizeObserver(() => myChart.resize()).observe(chartDom);
            
            var isMobile = window.innerWidth < 768;
            var manyLabels = '.count($labels).' > 7;  // Only show if more than 10 items

            myChart.setOption(' . $chartConfig . ');
            
            window.addEventListener("resize", function() {
                myChart.resize();
            });
        })();
        </script>';
        
        return $html;
    }    

    /**
     * Array to Neat Dashboard Panel Table
     */
    function array_to_table($data, $headers = null) 
    {
        if (empty($data)) {
            return '<p style="text-align: center; color: #999; padding: 20px;">No data available</p>';
        }
        
        // Auto-detect headers from first row if not provided
        if ($headers === null) {
            $firstRow = reset($data);
            if (is_array($firstRow)) {
                $headers = array_keys($firstRow);
            }
        }
        
        $html = '<table class="data-table">';
        
        // Header
        if ($headers) {
            $html .= '<thead><tr>';
            foreach ($headers as $header) {
                $label = ucwords(str_replace('_', ' ', $header));
                $html .= '<th>' . htmlspecialchars($label) . '</th>';
            }
            $html .= '</tr></thead>';
        }
        
        // Body
        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            if ($headers) {
                foreach ($headers as $key) {
                    $value = is_array($row) ? (isset($row[$key]) ? $row[$key] : '') : $row;
                    $html .= '<td>' . htmlspecialchars($value) . '</td>';
                }
            } else {
                if (is_array($row)) {
                    foreach ($row as $value) {
                        $html .= '<td>' . htmlspecialchars($value) . '</td>';
                    }
                } else {
                    $html .= '<td>' . htmlspecialchars($row) . '</td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        
        $html .= '</table>';
        
        return $html;
    }

}

/**
 * Common function to display errors
 */
if (!function_exists('phpgrid_error'))
{
	function phpgrid_error($msg)
	{
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');

		if (is_array($msg) || is_object($msg))
		{
			ob_start();
			print_r($msg);
			die(ob_get_clean());
		}

		die($msg);
	}
}

// for php < 7.3
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

// =============
// Example Usage
// =============

// include_once("../../config.php");
// include_once(PHPGRID_LIBPATH."inc/jqgrid_dash.php");
// $d = new jqgrid_dash();
// $v = $d->get_kpi_value("test","select count(*) from creator.applications");
// $a = $d->get_table("test","select id,title from creator.applications");
// echo $a["content"];
// $a = $d->get_bar_chart("test","SELECT u.name, COUNT(*) FROM  ct_ticket_management_system_1760059659.tb_tickets t JOIN  ct_ticket_management_system_1760059659.tb_users u ON t.assignee = u.name GROUP BY u.name ORDER BY COUNT(*) DESC LIMIT 5");
// echo $a["content"];

// Quick Reference - Get Chart Function
// Supported APIs:

// chartjs (default) - Chart.js
// google or googlecharts - Google Charts
// echarts - Apache ECharts

// Supported Types:

// bar - Bar chart
// line - Line chart
// pie - Pie chart
// doughnut - Doughnut chart

// Options:

// type - Chart type (default: 'bar')
// title - Chart title
// width - Chart width (default: '100%')
// height - Chart height (default: '400px')
// colors - Array of colors for chart

// Sample data
// $salesData = [
//     'January' => 4500,
//     'February' => 5200,
//     'March' => 4800,
//     'April' => 6100,
//     'May' => 5900,
//     'June' => 7200
// ];

// $productSales = [
//     'Product A' => 1200,
//     'Product B' => 800,
//     'Product C' => 1500,
//     'Product D' => 600,
//     'Product E' => 950
// ];

// // Example 1: Bar Chart with Chart.js (default)
// echo get_chart($salesData, 'chartjs', [
//     'type' => 'bar',
//     'title' => 'Monthly Sales'
// ]);

// // Example 2: Line Chart with Google Charts
// echo get_chart($salesData, 'google', [
//     'type' => 'line',
//     'title' => 'Sales Trend',
//     'height' => '350px'
// ]);

// // Example 3: Pie Chart with ECharts
// echo get_chart($productSales, 'echarts', [
//     'type' => 'pie',
//     'title' => 'Product Distribution'
// ]);

// // Example 4: Doughnut Chart
// echo get_chart($productSales, 'chartjs', [
//     'type' => 'doughnut',
//     'title' => 'Product Sales Share'
// ]);

// // Example 5: Custom colors
// echo get_chart($salesData, 'chartjs', [
//     'type' => 'bar',
//     'title' => 'Revenue',
//     'colors' => ['#333', '#666', '#999', '#bbb', '#ddd', '#eee']
// ]);

// // Example 6: In Dashboard Panel
// return [
//     'panel_rows' => [
//         [
//             'layout' => '2,1',
//             'panels' => [
//                 [
//                     'title' => 'Sales Overview',
//                     'content' => function() use ($db) {
//                         // Get data from database
//                         $result = $db->query("
//                             SELECT 
//                                 DATE_FORMAT(date, '%M') as month,
//                                 SUM(amount) as total
//                             FROM sales
//                             WHERE YEAR(date) = YEAR(CURDATE())
//                             GROUP BY MONTH(date)
//                         ")->fetchAll(PDO::FETCH_KEY_PAIR);
                        
//                         return get_chart($result, 'chartjs', [
//                             'type' => 'line',
//                             'title' => 'Monthly Revenue'
//                         ]);
//                     }
//                 ],
//                 [
//                     'title' => 'Top Products',
//                     'content' => function() use ($db) {
//                         $result = $db->query("
//                             SELECT 
//                                 product_name,
//                                 SUM(quantity) as sold
//                             FROM sales
//                             GROUP BY product_name
//                             ORDER BY sold DESC
//                             LIMIT 5
//                         ")->fetchAll(PDO::FETCH_KEY_PAIR);
                        
//                         return get_chart($result, 'echarts', [
//                             'type' => 'pie',
//                             'title' => 'Best Sellers'
//                         ]);
//                     }
//                 ],
//             ]
//         ],
//     ],
// ];

// // Example 7: Multiple charts in one panel
// $content = '';
// $content .= '<h3>Revenue Analysis</h3>';
// $content .= get_chart($salesData, 'chartjs', ['type' => 'bar', 'height' => '300px']);
// $content .= '<h3>Product Distribution</h3>';
// $content .= get_chart($productSales, 'chartjs', ['type' => 'doughnut', 'height' => '300px']);
// echo $content;

