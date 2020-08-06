<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include_once '../scripts/scripts.php';
$currentMap=get();
if($currentMap=='')echo "<div style='color:red;margin: 20px;position: absolute;'>Sorry, There is No Map associated with this Country</div>";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>COVID-19 <?php echo $_GET['country'];?> Dashboard</title>

<!-- amCharts includes -->
<script src="../deps/amcharts4/core.js"></script>
<script src="../deps/amcharts4/charts.js"></script>
<script src="../deps/amcharts4/maps.js"></script>

<script src="../deps/amcharts4/themes/dark.js"></script>
<script src="../deps/amcharts4/themes/animated.js"></script>

<script src="../deps/amcharts4-geodata/<?php echo $currentMap;?>.js"></script>

<!-- DataTables includes -->
<script src="../deps/jquery/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" media="all" href="../deps/datatables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" media="all" href="../deps/datatables/css/select.dataTables.min.css" />
<link rel="stylesheet" media="all" href="../deps/datatables/css/editor.dataTables.min.css" />
<script src="../deps/datatables/js/jquery.dataTables.min.js"></script>
<script src="../deps/datatables/js/dataTables.select.min.js"></script>

<!-- Data  -->
<script data-cfasync="false" src="../data/js/cc_timeline.js?rdm=<?php echo filemtime('../data/js/cc_timeline.js'); ?>"></script>
<script data-cfasync="false" src="../data/js/cc_total_timeline.js?rdm=<?php echo filemtime('../data/js/cc_total_timeline.js'); ?>"></script>

<!-- Stylesheet -->
<link rel="stylesheet" media="all" href="dark.css" />

<!-- Main app -->
<script src="app.js"></script>
</head>
<body>
<?php if($currentMap!=''){?>
<span style="color:white;font-style: oblique;position: fixed;bottom: 8px;right: 25px;font-size: large;border: 1px #131313 solid;border-radius: 5px;background: #1951ad;z-index: 1000;padding: 2px 16px;cursor: pointer;" onclick="window.open('../update/','_blank');">Update</span>
<input value="<?php echo $_GET['country'];?>" type="hidden" id="country"/>
<input value="<?php echo $_GET['cc'];?>" type="hidden" id="cc"/>
<?php }?>
<div class="flexbox">
<div id="chartdiv"></div>
<?php if($currentMap!=''){?>
<div id="list">
<table id="areas" class="compact hover order-column row-border">
<thead>
<tr>
<th>State</th>
<th>Confirmed</th>
<th>Deaths</th>
<th>Recovered</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<?php }?>
</div>
<!--
<div class="DTE DTE_Bubble" id="DTE_Bubble" style="display: none;">
<div class="DTE_Bubble_Liner"><div class="DTE_Bubble_Table">
<div class="DTE_Form_Content">
<div class="DTE_Field DTE_Field_Type_text">
<label class="DTE_Label" for="cc2">Country/State:</label>
<input id="cc2" type="text"></div>
<div class="DTE_Field DTE_Field_Type_text">
<label class="DTE_Label" for="confirmed">Confirmed:</label>
<input type="number" id="confirmed">
</div>
<div class="DTE_Field DTE_Field_Type_text">
<label class="DTE_Label" for="death">Death:</label>
<input type="number" id="death">
</div>
<div class="DTE_Field DTE_Field_Type_text">
<label class="DTE_Label" for="recovered">Recovered:</label>
<input id="recovered" type="number">
</div>
<div class="DTE_Field DTE_Field_Type_text">
<label class="DTE_Label" for="when">When:</label>
<input id="when" type="date">
</div>
</div>
<div class="DTE_Form_Success" style="display: none;color:green;">Please refresh WebPage in order to see the updates.</div>
<div class="DTE_Form_Error" style="display: none; ">Something went wrong! Please verify and retry.</div>
<div class="DTE_Processing_Indicator"><span></span></div>
<div class="DTE_Form_Buttons"><button class="btn" tabindex="0" onclick="addData();">Update</button></div>
<div class="DTE_Form_Buttons"><button class="btn" tabindex="1" onclick="$('#DTE_Bubble').hide('slow');">Cancel</button></div>
</div>
</div></div>
-->
</body>
</html>
