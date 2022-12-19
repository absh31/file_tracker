<?php
// echo date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime('2022-10-04 12:11:54' . '+60 minutes')) ? '1' : '0';
$xml = new SimpleXMLElement('<xml/>');

for ($i = 1; $i <= 8; ++$i) {
    $track = $xml->addChild('track');
    $track->addChild('path', "song$i.mp3");
    $track->addChild('title', "Track $i - Track Title");
}

Header('Content-type: text/xml');
print($xml->asXML('./settings.xml'));
exit();
$xml = simplexml_load_file("./settings.xml");
$json = json_encode($xml);
$array = json_decode($json);
print_r($array->DBHOST);
// echo $array->DBHOST[1];
exit;
$i = 0;
$files = array();
foreach ($xml->children() as $child) {
	array_push($files, $child[0][0]);
	$array_child[$i] = $child[0];
	$i = $i + 1;
	var_dump($child[0]);
	echo "<br>";
}
// print_r($files);
// echo $files[2];
exit;
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
		window.onload = function() {

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