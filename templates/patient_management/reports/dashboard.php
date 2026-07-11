<?php 
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

include_once(PHPGRID_LIBPATH."inc/jqgrid_dash.php");
$d = new jqgrid_dash();
 
// Preparing dashboard data
$kpi = array();
$box = array();
$kpi[] = $d->get_kpi_value("Total Patients","SELECT ROUND(COUNT(tb_patients.`id`)) AS 'Total Patients'
FROM tb_patients");
$kpi[] = $d->get_kpi_value("Total Appointments","SELECT ROUND(COUNT(tb_appointments.`id`)) AS 'Total Appointments'
FROM tb_appointments");
$kpi[] = $d->get_kpi_value("Total Doctors","SELECT ROUND(COUNT(tb_doctors.`id`)) AS 'Total Doctors'
FROM tb_doctors");
$kpi[] = $d->get_kpi_value("Total Payments","SELECT ROUND(COUNT(tb_payments.`id`)) AS 'Total Payments'
FROM tb_payments");
$box[] = $d->get_pie_chart("Patients by Blood Group","SELECT tb_patients.`blood_group` AS 'Blood Group', 
       COUNT(tb_patients.`id`) AS 'Number of Patients'
FROM tb_patients
GROUP BY tb_patients.`blood_group`");
$box[] = $d->get_bar_chart("Appointments by Month","SELECT DATE_FORMAT(tb_appointments.`appointment_date`, '%Y-%m') AS 'Month', 
       COUNT(tb_appointments.`id`) AS 'Number of Appointments'
FROM tb_appointments
GROUP BY DATE_FORMAT(tb_appointments.`appointment_date`, '%Y-%m')");
$box[] = $d->get_pie_chart("Payments by Method","SELECT tb_payments.`payment_method` AS 'Payment Method', 
       COUNT(tb_payments.`id`) AS 'Number of Payments'
FROM tb_payments
GROUP BY tb_payments.`payment_method`");
$box[] = $d->get_bar_chart("Doctors by Specialization","SELECT tb_doctors.`specialization` AS 'Specialization', 
       COUNT(tb_doctors.`id`) AS 'Number of Doctors'
FROM tb_doctors
GROUP BY tb_doctors.`specialization`");
$box[] = $d->get_table("Recent Patients","SELECT tb_patients.`patient_name` AS 'Patient Name', 
       tb_patients.`date_of_birth` AS 'Date of Birth', 
       tb_patients.`contact_number` AS 'Contact Number'
FROM tb_patients
ORDER BY tb_patients.`id` DESC
LIMIT 10");
$box[] = $d->get_table("Recent Appointments","SELECT tb_appointments.`appointment_date` AS 'Appointment Date', 
       tb_appointments.`appointment_time` AS 'Appointment Time', 
       tb_patients.`patient_name` AS 'Patient Name'
FROM tb_appointments
INNER JOIN tb_patients ON tb_appointments.`patient` = tb_patients.`id`
ORDER BY tb_appointments.`id` DESC
LIMIT 10");
$box[] = $d->get_table("Recent Prescriptions","SELECT tb_prescriptions.`prescription_date` AS 'Prescription Date', 
       tb_patients.`patient_name` AS 'Patient Name', 
       tb_prescriptions.`medication` AS 'Medication'
FROM tb_prescriptions
INNER JOIN tb_patients ON tb_prescriptions.`patient` = tb_patients.`id`
ORDER BY tb_prescriptions.`id` DESC
LIMIT 10");
$box_row = array_chunk($box,3);

// dashboard-data.php
$data = [
    'kpi_rows' => [
		[
            'layout' => count($kpi),
            'items' => $kpi
        ],	
    ],
    'panel_rows' => [
        [
            'layout' => '1,1,1',  // Small, Large, Small
            'panels' => $box_row[0]
        ],
        [
            'layout' => '1,1,1',  // Small, Large, Small
            'panels' => $box_row[1]
        ],
    ],
];

// $data = [
//     'kpi_rows' => [
//         [
//             'layout' => '6',  // 6 equal KPIs
//             'items' => [
//                 ['value' => '2,543', 'label' => 'Users'],
//                 ['value' => '$45.2K', 'label' => 'Revenue'],
//                 ['value' => '87%', 'label' => 'Success Rate'],
//                 ['value' => '1,234', 'label' => 'Orders'],
//                 ['value' => '432', 'label' => 'New Leads'],
//                 ['value' => '92%', 'label' => 'Uptime'],
//             ]
//         ],
//         [
//             'layout' => '2,1,1',  // Featured KPI, two smaller ones
//             'items' => [
//                 ['value' => '$125K', 'label' => 'Total Revenue'],
//                 ['value' => '234', 'label' => 'New'],
//                 ['value' => '89%', 'label' => 'Rate'],
//             ]
//         ],
//     ],
//     'panel_rows' => [
//         [
//             'layout' => '1,2,1',  // Small, Large, Small
//             'panels' => [
//                 ['title' => 'Quick Stats', 'content' => 'Brief statistics overview.'],
//                 ['title' => 'Main Chart', 'content' => 'Primary data visualization takes center stage.'],
//                 ['title' => 'Summary', 'content' => 'Key takeaways.'],
//             ]
//         ],
//         [
//             'layout' => '2,1,1',  // Large, Small, Small
//             'panels' => [
//                 ['title' => 'Detailed Analytics', 'content' => 'Comprehensive analytics dashboard.'],
//                 ['title' => 'User Count', 'content' => 'Active users.'],
//                 ['title' => 'Alerts', 'content' => 'System alerts.'],
//             ]
//         ],
//         [
//             'layout' => '1,1,2',  // Small, Small, Large
//             'panels' => [
//                 ['title' => 'Status', 'content' => 'Current status.'],
//                 ['title' => 'Uptime', 'content' => 'System uptime.'],
//                 ['title' => 'Performance Report', 'content' => 'Detailed performance metrics and analysis.'],
//             ]
//         ],
//     ],
// ];

// Helper function to parse layout and generate grid-template-columns
function getGridTemplate($layout) {
    // If layout is just a number, create equal columns
    if (is_numeric($layout)) {
        return "repeat($layout, 1fr)";
    }
    
    // Parse fractional layout like "1,2,1" or "2,1,1"
    $fractions = explode(',', $layout);
    $total = array_sum($fractions);
    
    $columns = array_map(function($fraction) use ($total) {
        return $fraction . 'fr';
    }, $fractions);
    
    return implode(' ', $columns);
}

ob_start();
?>
<style>
/* Dashboard CSS */
.dashboard {
	font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
	padding: 20px;
	min-height: 100vh;
	margin: 0 auto;
	/* background: #f3f4f6; */
}

.dashboard .header {
	text-align: center;
	color: #333;
	margin-bottom: 30px;
}

.dashboard .header h1 {
	font-size: 2.5em;
	font-weight: 300;
	letter-spacing: 2px;
}

/* Corner border style */
.dashboard .corner-border {
	position: relative;
	background: white;
	padding: 25px;
	margin: 15px;
	border-radius: 5px;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.dashboard .corner-border::before,
.dashboard .corner-border::after {
	content: '';
	position: absolute;
	width: 20px;
	height: 20px;
	border: 3px solid #667eea;
}

.dashboard .corner-border::before {
	top: 8px;
	left: 8px;
	border-right: none;
	border-bottom: none;
	border-radius: 5px 0 0 0;
}

.dashboard .corner-border::after {
	top: 8px;
	right: 8px;
	border-left: none;
	border-bottom: none;
	border-radius: 0 5px 0 0;
}

.dashboard .corner-border .corner-bottom-left,
.dashboard .corner-border .corner-bottom-right {
	content: '';
	position: absolute;
	width: 20px;
	height: 20px;
	border: 3px solid #667eea;
}

.dashboard .corner-border .corner-bottom-left {
	bottom: 8px;
	left: 8px;
	border-right: none;
	border-top: none;
	border-radius: 0 0 0 5px;
}

.dashboard .corner-border .corner-bottom-right {
	bottom: 8px;
	right: 8px;
	border-left: none;
	border-top: none;
	border-radius: 0 0 5px 0;
}

/* Dynamic Row System */
.dashboard .base-row {
	display: grid;
	gap: 15px;
	margin-bottom: 20px;
}

.dashboard .kpi-box {
	position: relative;
	background: white;
	padding: 20px 15px;
	text-align: center;
	transition: all 0.3s ease;
	border-radius: 5px;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.dashboard .kpi-box:hover {
	/* transform: translateY(-3px); */
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.dashboard .kpi-value {
	font-size: 2em;
	font-weight: bold;
	color: #667eea;
	margin-bottom: 5px;
}

.dashboard .kpi-label {
	font-size: 0.85em;
	color: #666;
	text-transform: uppercase;
	letter-spacing: 1px;
}

.dashboard .panel {
	min-height: 250px;
	transition: all 0.3s ease;
}

.dashboard .panel:hover {
	/* transform: translateY(-3px); */
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.dashboard .panel-title {
	font-size: 1.3em;
	color: #333;
	margin-bottom: 15px;
	padding-bottom: 10px;
	border-bottom: 2px solid #667eea;
    padding-left: 2px;
    padding-right: 2px;	
}

.dashboard .panel-content {
	color: #666;
	line-height: 1.6;
}

@media (max-width: 1200px) {
	/* On medium screens, try to maintain some structure */
	.dashboard .base-row {
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
	}
}

@media (max-width: 768px) {
	/* Stack on mobile */
    .dashboard .base-row {
        grid-template-columns: 1fr !important;
    }
    
    .dashboard [id^="chart_"] {
        height: 300px !important;
        min-height: 250px !important;
    }
    
    .dashboard .panel {
        min-height: auto !important;
    }
    
    .dashboard .corner-border {
        margin: 10px 5px;
        padding: 15px;
    }
}

/* Compact Gray Table Styles */
.dashboard .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85em;
}

.dashboard .data-table thead {
    background: #f5f5f5;
    border-bottom: 2px solid #ddd;
}

.dashboard .data-table th {
    padding: 8px 12px;
    text-align: left;
    font-weight: 600;
    color: #555;
    font-size: 0.9em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dashboard .data-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #eee;
    color: #666;
}

.dashboard .data-table tbody tr:nth-child(even) {
    background-color: #fafafa;
}

.dashboard .data-table tbody tr:hover {
    background-color: #f5f5f5;
}

.dashboard .data-table tbody tr:last-child td {
    border-bottom: none;
}

</style>
<div class="dashboard">
	
	<!-- <div class="header">
		<h1>ANALYTICS DASHBOARD</h1>
	</div> -->

	<!-- KPI Rows with Fractional Layouts -->
	<?php foreach ($data['kpi_rows'] as $kpiRow): ?>
		<div class="base-row kpi-row" style="grid-template-columns: <?php echo getGridTemplate($kpiRow['layout']) ?>;">
			<?php foreach ($kpiRow['items'] as $kpi): ?>
				<div class="kpi-box corner-border">
					<span class="corner-bottom-left"></span>
					<span class="corner-bottom-right"></span>
					<div class="kpi-value"><?php echo htmlspecialchars($kpi['value']) ?></div>
					<div class="kpi-label"><?php echo htmlspecialchars($kpi['label']) ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>

	<!-- Panel Rows with Fractional Layouts -->
	<?php foreach ($data['panel_rows'] as $row): ?>
		<div class="base-row panel-row" style="grid-template-columns: <?php echo getGridTemplate($row['layout']) ?>;">
			<?php foreach ($row['panels'] as $panel): ?>
				<div class="panel corner-border">
					<span class="corner-bottom-left"></span>
					<span class="corner-bottom-right"></span>
					<h2 class="panel-title"><?php echo htmlspecialchars($panel['title']) ?></h2>
					<div class="panel-content">
						<p><?php echo $panel['content'] ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>

</div>
<?php
$out = ob_get_clean();
 
$var = array();
$var["out"] = $out;

return $var;