<form action="testb.php" method="post">

    Which buildings do you want access to?<br />
    <input type="checkbox" name="formDoor[]" value="jpg" />Acorn Building<br />
    <input type="checkbox" name="formDoor[]" value="jpeg" />Brown Hall<br />
    <input type="checkbox" name="formDoor[]" value="png" />Carnegie Complex<br />
    <input type="checkbox" name="formDoor[]" value="pdf" />Drake Commons<br />
    <input type="checkbox" name="formDoor[]" value="xls" />Elliot House

    <input type="submit" name="formSubmit" value="Submit" />

</form>
<?php
$xml = simplexml_load_file("./settings.xml");
$array = array();
foreach ($xml->fileType as $child) {
    array_push($array, strval($child[0]));
}
print_r($array);
?>