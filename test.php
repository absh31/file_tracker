<?php
// echo date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime('2022-10-04 12:11:54' . '+60 minutes')) ? '1' : '0';
date_default_timezone_set("Asia/Kolkata");
echo date('Y-m-d H:i:s');
?>

<?php
 
$dataPoints = array(
	array("y" => 0, "label" => "Sunday Sunday Sunday Sunday Sunday Sunday Sunday Sunday"),
	array("y" => 0, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 2, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 1, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 5, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 0, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 0, "label" => "Sunday Sunday Sunday Sunday"),
	array("y" => 2, "label" => "Sunday Sunday Sunday Sunday")
);
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Activity at Each Section."
	},
	axisY: {
		title: "Number of Hours"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>