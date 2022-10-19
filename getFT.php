<?php
// include './connection.php';
// echo "absh";
function getFT($conn, $id)
{
    $x1Sql = $conn->prepare("SELECT f.file_id FROM tblfile f, tblactivity a WHERE a.activity_from = ? AND f.file_track_no = a.activity_file_track_no GROUP BY f.file_track_no;");
    $x1Sql->bindValue(1, $id);
    $x1Sql->execute();
    $x1 = $x1Sql->rowCount();
    $t1Sql = $conn->prepare("SELECT file_id FROM tblfile WHERE file_current_holder = ?");
    $t1Sql->bindParam(1, $id);
    $t1Sql->execute();
    $t1 = $t1Sql->rowCount();
    $x12Sql = $conn->prepare("SELECT f.file_id FROM tblfile f, tblactivity a WHERE a.activity_to = ? AND f.file_track_no = a.activity_file_track_no AND a.activity_ack = 0 GROUP BY f.file_track_no;");
    $x12Sql->bindValue(1, $id);
    $x12Sql->execute();
    $x12 = $x12Sql->rowCount();
    if($x1 == 0){
        $y1 = 0;
    }else{
        $y1 = ($x1 - $x12 - $t1) / $x1;
    }
    // echo "y1 = " . (($y1) * 55) . "<br>";

    $x2Sql = $conn->prepare("SELECT AVG(((SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED' AND activity_ack = 1)-(SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time))) AS delay_time FROM tblactivity WHERE activity_type = 'FORWARDED' AND activity_ack = 1))/(SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time))) AS delay_time FROM tblactivity WHERE activity_type = 'FORWARDED' AND activity_ack = 1)) AS d FROM tblactivity;");
    $x2Sql->bindValue(1, $id);
    $x2Sql->execute();
    $x2key = $x2Sql->fetch(PDO::FETCH_ASSOC);
    $x2 = $x2key['d'];
    $y2 = $x2;
    // echo "y2 = " . (($y2) * -20) . "<br>";

    $x3Sql = $conn->prepare("SELECT AVG(((SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time))) AS working_time FROM tblactivity WHERE activity_to = ?)-(SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time))) AS working_time FROM tblactivity))/(SELECT AVG(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time))) AS working_time FROM tblactivity)) AS w FROM tblactivity;");
    $x3Sql->bindParam(1, $id);
    $x3Sql->execute();
    $x3key = $x3Sql->fetch(PDO::FETCH_ASSOC);
    $x3 = $x3key['w'];
    $y3 = $x3;
    // echo "y3 = " . (($y3) * -10) . "<br>";

    $x4Sql = $conn->prepare("SELECT (SELECT COUNT(*) FROM tblfile WHERE file_added_by = ?)/(SELECT COUNT(*) FROM tblfile) AS a FROM tblfile");
    $x4Sql->bindParam(1, $id);
    $x4Sql->execute();
    $x4key = $x4Sql->fetch(PDO::FETCH_ASSOC);
    $x4 = $x4key['a'];
    $y4 = $x4;
    // echo "y4 = " . (($y4) * 5) . "<br>";

    $x5Sql = $conn->prepare("SELECT (SELECT COUNT(*) FROM tblactivity WHERE activity_from = ? AND activity_type = 'Completed')/(SELECT COUNT(*) FROM tblfile WHERE file_completed = 1) AS c FROM tblfile");
    $x5Sql->bindParam(1, $id);
    $x5Sql->execute();
    $x5key = $x5Sql->fetch(PDO::FETCH_ASSOC);
    $x5 = $x5key['c'];
    $y5 = $x5;
    // echo "y5 = " . (($y5) * 5) . "<br>";

    $x6Sql = $conn->prepare("SELECT (SELECT COUNT(*) FROM tbldocument WHERE document_by = ?)/(SELECT COUNT(*) FROM tbldocument) AS d FROM tbldocument");
    $x6Sql->bindParam(1, $id);
    $x6Sql->execute();
    $x6key = $x6Sql->fetch(PDO::FETCH_ASSOC);
    $x6 = $x6key['d'];
    $y6 = $x6;
    // echo "y6 = " . (($y6) * 5) . "<br>";

    $y = 55 * $y1 + (-20) * $y2 + (-10) * $y3 + 5 * $y4 + 5 * $y5 + 5 * $y6;
    // echo "FTScore = Y = " . ($y);
    if($y < 0){
        return 0;
    }else{
        return $y;
    }
}
// getFT($conn, 8);
