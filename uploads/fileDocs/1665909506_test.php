<?php include "./header.php"; ?>
<?php include "./Connection.php"; ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJhGKpeFeaHsgQnkFv1yztvFuGU-NTZKI&libraries=drawing,geometry">
</script>
<div id="row">
    <?php
        $conn = connecttodb();
        $geofenceQuery = $conn->prepare("SELECT * FROM geofencing_details");
        $geofenceQuery->execute();
        $geofences = $geofenceQuery->fetchAll(PDO::FETCH_ASSOC);
    ?>
</div>
<?php include "./footer.php"; ?>
<script>
    let doc = "";
    var data1 = <?php echo json_encode($geofences); ?>;
    for(var i=0; i<data1.length; i++){
        const coordinates = JSON.parse(data1[i]['geofencing_area']);
        const data = new google.maps.Polygon({
            paths: coordinates
        });
        const point = new google.maps.LatLng(23.259426, 69.670559);
        const result = google.maps.geometry.poly.containsLocation(point, data);
        if(result === true){
            doc = data1[i]['charge_name'];
            break;
        }
    }
</script>
<?php echo "<script>document.writeln(doc)</script>";

$geofenceQuery = $conn->prepare("SELECT * FROM geofencing_details");
$geofenceQuery->execute();
$geofences = $geofenceQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
    let doc = "";
    var data1 = <?php echo json_encode($geofences); ?>;
    for (var i = 0; i < data1.length; i++) {
        const coordinates = JSON.parse(data1[i]['geofencing_area']);
        const data = new google.maps.Polygon({
            paths: coordinates
        });
        const point = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
        const result = google.maps.geometry.poly.containsLocation(point, data);
        if (result === true) {
            doc = data1[i]['charge_name'];
            break;
        }
    }
    <?php $abc = "<script>document.write(doc)</script>"?>  
</script>