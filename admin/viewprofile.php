<link href="../timeline.css" rel="stylesheet">
<?php
session_start();
include('../backend/checkSession.php');
checkSession();
include "../header.php";
include '../connection.php';
include './nav.php';
include '../getFT.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

    if ($key['role_name'] == "Admin") {
?>
        <br>
        <div class="container">
            <br>
            <?php
            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_id =?");
                $sql->bindParam(1, $id);
                $sql->execute();
                $key = $sql->fetch(PDO::FETCH_ASSOC);
                if ($sql->rowCount() == 0) {
                    echo "<div class='col-md-12 text text-danger text-center'><br>No officer found! </div>";
                } else {

            ?>


                    <h5>Officer Details</h5>
                    <br>
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td colspan="3"><?php echo $key['officer_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td colspan="3"><?php echo $key['officer_email']; ?></td>
                            </tr>
                            <tr>
                                <td>Contact</td>
                                <td colspan="3"><?php echo $key['officer_mobile']; ?></td>
                            </tr>
                        </tbody>
                    </table>



                    <?php
                    $rolesql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_username = ?");
                    $rolesql->bindParam(1, $key['officer_username']);
                    $rolesql->execute();
                    $keyroles = $rolesql->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($keyroles as $keyrole) {
                        $roledetsql = $conn->prepare("select * from tblrole where role_id = ?");
                        $roledetsql->bindParam(1, $keyrole['officer_role_id']);
                        $roledetsql->execute();
                        $roledetkey = $roledetsql->fetch(PDO::FETCH_ASSOC);

                        $deptdetsql = $conn->prepare("select * from tbldept where dept_id = ?");
                        $deptdetsql->bindParam(1, $keyrole['officer_dept_id']);
                        $deptdetsql->execute();
                        $deptdetkey = $deptdetsql->fetch(PDO::FETCH_ASSOC);

                    ?>
                        <br>


                        <div class="row">
                            <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;"><?php echo $roledetkey['role_name'] . " - " . $deptdetkey['dept_name']; ?></h6>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center font-weight-bold" style="font-size: 30px; color: #003975;">
                                            <?php
                                            $workingTimeSql = $conn->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time)))) AS working_time FROM tblactivity WHERE activity_to = ?;");
                                            $workingTimeSql->bindParam(1, $keyrole['officer_id']);
                                            $workingTimeSql->execute();
                                            $workingTime = $workingTimeSql->fetch();
                                            $working_time = explode('.', $workingTime['working_time']);
                                            $days = explode(':', $working_time[0]);
                                            $day = (int)((int)$days[0] / 24);
                                            echo $working_time[0] . "<br> (" . $day . " Days)";
                                            ?>
                                        </h5>
                                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Processing Time</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center font-weight-bold" style="font-size: 30px; color: #003975;">
                                            <?php
                                            $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED';");
                                            $delaySql->bindParam(1, $keyrole['officer_id']);
                                            $delaySql->execute();
                                            $delay = $delaySql->fetch();
                                            $delay_time = explode('.', $delay['delay_time']);

                                            $days = explode(':', $delay_time[0]);
                                            $day = (int)((int)$days[0] / 24);
                                            echo $delay_time[0] . "<br> (" . $day . " Days)";
                                            ?>
                                        </h5>
                                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Delay Time</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center  font-weight-bold py-3" style="font-size: 30px; color: #003975;">
                                            <?php
                                            $sql4 = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from = ? AND f.file_track_no = a.activity_file_track_no GROUP BY f.file_track_no;");
                                            $sql4->bindParam(1, $keyrole['officer_id']);
                                            $sql4->execute();
                                            echo $sql4->rowCount() . " <br>";
                                            ?>
                                        </h5>
                                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Total Files</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center  font-weight-bold py-3" style="font-size: 30px; color: #003975;">
                                            <?php
                                            echo number_format(getFT($conn, $keyrole['officer_id']), 2) . " <br/>";
                                            ?>
                                        </h5>
                                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">FT Score</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                    <?php
                    }
                    ?>
            <?php
                }
            }
            ?>
        </div>
        </div>
        </div>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>
        <script>
            document.getElementById('my-nav').classList.remove('active');
            document.getElementById('file-nav').classList.add('active');
            document.getElementById("manage-nav").classList.remove('active');
            document.getElementById("dash-nav").classList.remove('active');
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>