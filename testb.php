<?php
$aDoor = $_POST['formDoor'];
$N = count($aDoor);
print_r($aDoor);
$xml = new SimpleXMLElement('<xml/>');
for ($i = 0; $i < $N; ++$i) {
    $track = $xml->addChild('fileType', $aDoor[$i]);
}
Header('Content-type: text/xml');
print($xml->asXML('./settings.xml'));
exit;