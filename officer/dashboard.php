<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include('../backend/checkSession.php');
    checkSession();
    include("../connection.php");
    include "../header.php";
    include './nav.php';
    include '../getFT.php';
?>
<br>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col">
            <h5>Hey, <?= ucwords($_SESSION['officer_name']) ?></h5>
        </div>
    </div>
    <br>
    <div class="row">
        <h6 class="card-title text-left fw-bolder" style="font-size: 30px;">Files </h6>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                        <?php
                                    $recievedCountSql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_to = ? AND a.activity_ack = 0 AND a.activity_type = 'Forwarded' AND f.file_completed = 0 AND a.activity_file_track_no = f.file_track_no GROUP BY a.activity_file_track_no ORDER BY a.activity_time DESC;");
                                    $recievedCountSql->bindParam(1, $_SESSION['id']);
                                    $recievedCountSql->execute();
                                    $recievedCount = $recievedCountSql->rowCount();
                                    echo (int)$recievedCount;
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Recieved</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                        <?php
                                    $pendingCountSql = $conn->prepare("SELECT * FROM tblfile WHERE file_current_holder = ?");
                                    $pendingCountSql->bindParam(1, $_SESSION['id']);
                                    $pendingCountSql->execute();
                                    $pendingCount = $pendingCountSql->rowCount();
                                    echo (int)$pendingCount;
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center  font-weight-bold" style="font-size: 60px; color: #003975;">
                        <?php
                                    $forwardCountSql = $conn->prepare("SELECT * 
                                    FROM tblfile f, tblactivity a 
                                    WHERE a.activity_from = ? AND f.file_completed = 0 AND a.activity_type = 'Forwarded' AND a.activity_file_track_no = f.file_track_no
                                    GROUP BY f.file_track_no
                                    ORDER BY a.activity_time DESC;");
                                    $forwardCountSql->bindParam(1, $_SESSION['id']);
                                    $forwardCountSql->execute();
                                    $forwardCount = $forwardCountSql->rowCount();
                                    echo (int)$forwardCount;
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Forwarded</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center  font-weight-bold" style="font-size: 60px; color: #003975;">
                        <?php
                                    $totalWorkedSql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from = ? AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 1 GROUP BY f.file_track_no;");
                                    $totalWorkedSql->bindParam(1, $_SESSION['id']);
                                    $totalWorkedSql->execute();
                                    $totalWorked = $totalWorkedSql->rowCount();
                                    echo (int)$totalWorked;
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Total Worked Upon
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="row">
        <h6 class="card-title text-left fw-bolder" style="font-size: 30px;">Your Stats</h6>

        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 40px; color: #003975;">
                        <?php
                                    $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED';");
                                    $delaySql->bindParam(1, $_SESSION['id']);
                                    $delaySql->execute();
                                    $delay = $delaySql->fetch();
                                    $delay_time = explode('.', $delay['delay_time']);
                                    $days= explode(':',$delay_time[0]);
                                    $day = (int)((int)$days[0]/24);
                                    echo $delay_time[0]." (".$day." Days)";
                                    // echo $delay_time[0];
                                    // echo $delay['delay_time'];
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Average Delay Time
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 40px; color: #003975;">
                        <?php
                                        echo number_format(getFT($conn, $_SESSION['id']), 2);
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">FT Score</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 40px; color: #003975;">
                        <?php
                                    $workingTimeSql = $conn->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time)))) AS working_time FROM tblactivity WHERE activity_to = ?;");
                                    $workingTimeSql->bindParam(1, $_SESSION['id']);
                                    $workingTimeSql->execute();
                                    $workingTime = $workingTimeSql->fetch();
                                    $working_time = explode('.',$workingTime['working_time']);
                                    // echo $workingTime['working_time'];
                                    $days= explode(':',$working_time[0]);
                                    $day = (int)((int)$days[0]/24);
                                    echo $working_time[0]." (".$day." Days)";
                                    // echo $working_time[0];
                                    ?>
                    </h5>
                    <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Working Time</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 40px; color: #003975;">
                        <a href="./addFile.php" style="color: #003975;">Add File</a>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold" style="font-size: 40px; color: #003975;">
                        <a href="./trackFile.php" style="color: #003975;">Track File</a>
                    </h5>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
</div>
<br><br>
<script>
document.getElementById('my-nav').classList.remove('active');
document.getElementById("file-nav").classList.remove('active');
document.getElementById("manage-nav").classList.remove('active');
document.getElementById("dash-nav").classList.add('active');
</script>
<?php include '../footer.php'; ?>
</body>

</html>
<?php
}
?>