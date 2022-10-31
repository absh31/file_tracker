<?php
session_start();
include '../../getFT.php';
include '../../connection.php';
$deptId = $_POST['deptId'];
$officersSql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_dept_id = ? AND officer_active = 1");
$officersSql->bindParam(1, $deptId);
$officersSql->execute();
// echo "<option disabled selected>Select Officer</option>";
$officers = $officersSql->fetchAll(PDO::FETCH_ASSOC);
// foreach ($officers as $officer) {
//     $officerRoleSql = $conn->prepare("SELECT * FROM tblrole WHERE role_id = ?");
//     $officerRoleSql->bindParam(1, $officer['officer_role_id']);
//     $officerRoleSql->execute();
//     $officerRole = $officerRoleSql->fetch(PDO::FETCH_ASSOC); 
//     echo "<option value='".$officer['officer_id']."'>".$officer['officer_name']." - ".$officerRole['role_name']."</option>";
// }
?>
<table class="table cell-border" id="myTable1">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Delay Time</th>
            <th scope="col">Processing Time</th>
            <th scope="col">Pending Files</th>
            <th scope="col">Completed Files</th>
            <th scope="col">Total Files</th>
            <th scope="col">FT Score</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if (empty($officers)) {
        ?>
            <tr>
                <td class="text-center text-danger" scope='col' colspan="7">No Data</td>
            </tr>
            <?php
        } else {
            foreach ($officers as $officer) {
                $officerRoleSql = $conn->prepare("SELECT * FROM tblrole WHERE role_id = ?");
                $officerRoleSql->bindParam(1, $officer['officer_role_id']);
                $officerRoleSql->execute();
                $officerRole = $officerRoleSql->fetch(PDO::FETCH_ASSOC);

                // $sql3=$sql3->fetch();
                $sql3 = $conn->prepare(" SELECT * FROM tblfile WHERE file_completed = 0 AND file_current_holder = ?;");
                $sql3->bindParam(1, $officer['officer_id']);
                $sql3->execute();
                $sql2 = $conn->prepare("SELECT * 
                        FROM tblfile f, tblactivity a 
                        WHERE a.activity_from = ?  AND a.activity_type IN ('Forwarded', 'Completed') AND a.activity_file_track_no = f.file_track_no
                        GROUP BY f.file_track_no
                        ORDER BY a.activity_time DESC;");
                $sql2->bindParam(1, $officer['officer_id']);
                $sql2->execute();


                $sql4 = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from = ? AND f.file_track_no = a.activity_file_track_no GROUP BY f.file_track_no;");
                $sql4->bindParam(1, $officer['officer_id']);
                $sql4->execute();
            ?>
                <tr>

                    <td><?= $officer['officer_name'] ?></td>
                    <?php
                    $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED';");
                    $delaySql->bindParam(1, $officer['officer_id']);
                    $delaySql->execute();
                    $delay = $delaySql->fetch();
                    $delay_time = explode('.', $delay['delay_time']);
                    // echo $delay_time[0];
                    $days = explode(':', $delay_time[0]);
                    $day = (int)((int)$days[0] / 24);
                    // echo $delay_time[0]." (".$day." Days)";
                    ?>
                    <td><?php echo $delay_time[0] . " (" . $day . " Days)"; ?></td>

                    <?php
                    $workingTimeSql = $conn->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time)))) AS working_time FROM tblactivity WHERE activity_to = ?;");
                    $workingTimeSql->bindParam(1, $officer['officer_id']);
                    $workingTimeSql->execute();
                    $workingTime = $workingTimeSql->fetch();
                    $working_time = explode('.', $workingTime['working_time']);
                    $days = explode(':', $working_time[0]);
                    $day = (int)((int)$days[0] / 24);
                    // echo $workingTime['working_time'];

                    ?>
                    <td><?php echo $working_time[0] . " (" . $day . " Days)"; ?></td>

                    <td><?php
                        echo $sql3->rowCount();
                        ?></td>
                    <td><?= $sql2->rowCount() ?></td>
                    <td><?= $sql4->rowCount() ?></td>
                    <td><?php echo number_format(getFT($conn, $officer['officer_id']), 2); ?></td>
                </tr>
        <?php
            }
        }
        ?>

    </tbody>
</table>