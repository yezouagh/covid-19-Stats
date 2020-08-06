<?php 
error_reporting(-1);
ini_set('display_errors', 'On');

//include_once '../scripts/scripts.php';
//refresh_world();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>COVID-19 : Dashboard</title>

<!-- amCharts includes -->
<script src="../deps/amcharts4/core.js"></script>
<script src="../deps/amcharts4/charts.js"></script>
<script src="../deps/amcharts4/maps.js"></script>

<script src="../deps/amcharts4/themes/dark.js"></script>
<script src="../deps/amcharts4/themes/animated.js"></script>
<!-- Region Map ///////////////////////////////////////////////////////-->
<script src="../deps/amcharts4-geodata/worldMoroccoLow.js"></script>

<script src="../deps/amcharts4-geodata/data/countries2.js"></script>

<!-- DataTables includes -->
<script src="../deps/jquery/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" media="all" href="../deps/datatables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" media="all" href="../deps/datatables/css/select.dataTables.min.css" />
<script src="../deps/datatables/js/jquery.dataTables.min.js"></script>
<script src="../deps/datatables/js/dataTables.select.min.js"></script>

<!-- Data ///////////////////////////////////////////// -->
<script src="../data/js/world_timeline.js?rdm=<?php echo filemtime('../data/js/world_timeline.js'); ?>"></script>
<script src="../data/js/total_timeline.js?rdm=<?php echo filemtime('../data/js/total_timeline.js'); ?>"></script>

<!-- Stylesheet -->
<link rel="stylesheet" media="all" href="dark.css" />

<!-- Main app -->
<script src="app.js"></script>
</head>
<body>
<span style="font-style: oblique;position: fixed;bottom: 8px;right: 25px;font-size: large;border: 1px #131313 solid;border-radius: 5px;background: #1951ad;z-index: 1000;padding: 2px 16px;cursor: pointer;" onclick="window.open('../update/','_blank');">Update</span>
<div class="flexbox">
<div id="chartdiv"></div>
<div id="list">
<table id="areas" class="compact hover order-column row-border">
<thead>
<tr>
<th>Country/State</th>
<th>Confirmed</th>
<th>Deaths</th>
<th>Recovered</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
</body>
</html>
