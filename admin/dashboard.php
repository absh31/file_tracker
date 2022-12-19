<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['auth'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include('../backend/checkSession.php');
    checkSession();
    include("../connection.php");
    include("../header.php");
    include("./nav.php");
    include '../getFT.php';
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Hey, <?= ucwords($_SESSION['officer_name']) ?></h5>
            </div>
            <h3 class="dept-title">Dashboard</h3>
            <div class="px-4 mb-4 pt-3 apply" style="border: 1px solid #003865;">
                <div class="row">
                    <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Files Added</h6>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $today = date('Y-m-d');
                                    $today1 = $today . "%";
                                    $todayCountSql = $conn->prepare("SELECT COUNT(*) AS today_cnt FROM tblfile WHERE file_time LIKE ?");
                                    $todayCountSql->bindParam(1, $today1);
                                    $todayCountSql->execute();
                                    $todayCount = $todayCountSql->fetch();
                                    echo (int)$todayCount['today_cnt'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Today</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $weekCountSql = $conn->prepare("SELECT COUNT(*) AS week_cnt FROM tblfile WHERE DATEDIFF(?, file_time) <= 7");
                                    $weekCountSql->bindParam(1, $today);
                                    $weekCountSql->execute();
                                    $weekCount = $weekCountSql->fetch();
                                    echo (int)$weekCount['week_cnt'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">This Week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center  font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $weekCountSql = $conn->prepare("SELECT COUNT(*) AS week_cnt FROM tblfile WHERE DATEDIFF(?, file_time) <= 30");
                                    $weekCountSql->bindParam(1, $today);
                                    $weekCountSql->execute();
                                    $weekCount = $weekCountSql->fetch();
                                    echo (int)$weekCount['week_cnt'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            <div class="px-4 mb-4 pt-3 apply" style="border: 1px solid #003865;">
                <div class="row">
                    <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Files Status</h6>

                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $deptCountSql = $conn->prepare("SELECT COUNT(*) AS total_cnt FROM tblfile");
                                    $deptCountSql->execute();
                                    $deptCount = $deptCountSql->fetch();
                                    echo (int)$deptCount['total_cnt'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Total</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center text-danger font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $roleCountSql = $conn->prepare("SELECT COUNT(*) AS count FROM tblfile WHERE file_completed = 0");
                                    $roleCountSql->execute();
                                    $rolesCount = $roleCountSql->fetch();

                                    echo $rolesCount['count'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center text-success font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $officerCountSql = $conn->prepare("SELECT COUNT(*) AS count FROM tblfile WHERE file_completed = 1");
                                    $officerCountSql->execute();
                                    $officerCount = $officerCountSql->fetch();
                                    echo $officerCount['count'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            <div class="px-4 mb-4 pt-3 apply" style="border: 1px solid #003865;">
                <div class="row">
                    <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Office</h6>

                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $deptCountSql = $conn->prepare("SELECT COUNT(*) AS dept_cnt FROM tbldept WHERE dept_active = 1");
                                    $deptCountSql->execute();
                                    $deptCount = $deptCountSql->fetch();
                                    echo (int)$deptCount['dept_cnt'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Departments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $roleCountSql = $conn->prepare("SELECT DISTINCT(COUNT(role_name)) AS count FROM tblrole WHERE role_active = 1");
                                    $roleCountSql->execute();
                                    $rolesCount = $roleCountSql->fetch();

                                    echo $rolesCount['count'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Roles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $officerCountSql = $conn->prepare("SELECT COUNT(*) AS count FROM tblofficer WHERE officer_active = 1");
                                    $officerCountSql->execute();
                                    $officerCount = $officerCountSql->fetch();
                                    echo $officerCount['count'];
                                    ?>
                                </h5>
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Officers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col text-center text-primary">
                    <h5 class="btn btn-outline-dark active" id="div_dept_menu">Departments</h5>
                </div>
                <div class="col text-center text-primary">
                    <h5 class="btn btn-outline-dark" id="div_officer_menu">Officers</h5>
                </div>
                <div class="col text-center text-primary">
                    <h5 class="btn btn-outline-dark" id="div_search_menu">Search</h5>
                </div>
            </div>
            <div id="div_dept">
                <!-- <h5> Departments </h5> -->
                <table class="table cell-border" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Delay Time</th>
                            <th scope="col">Processing Time</th>
                            <th scope="col">Pending Files</th>
                            <th scope="col">Completed Files</th>
                            <th scope="col">Total Files</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $dept_sql = $conn->prepare("SELECT * FROM tbldept WHERE dept_active = 1");
                        $dept_sql->execute();
                        while ($dept_arr = $dept_sql->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                            <tr>
                                <td><?= $dept_arr['dept_name'] ?></td>
                                <td><?php
                                    $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND activity_type = 'FORWARDED';");
                                    $delaySql->bindParam(1, $dept_arr['dept_id']);
                                    $delaySql->execute();
                                    $delay = $delaySql->fetch(PDO::FETCH_ASSOC);
                                    $delay_time = explode('.', $delay['delay_time']);
                                    $days = explode(':', $delay_time[0]);
                                    $day = (int)((int)$days[0] / 24);
                                    echo $delay_time[0] . " (" . $day . " Days)";
                                    ?></td>
                                <td><?php
                                    $delaySql = $conn->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(activity_time_taken, activity_ack_time)))) AS working_time FROM tblactivity WHERE activity_to IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?);");
                                    $delaySql->bindParam(1, $dept_arr['dept_id']);
                                    $delaySql->execute();
                                    $delay = $delaySql->fetch(PDO::FETCH_ASSOC);
                                    $delay_time = explode('.', $delay['working_time']);
                                    $days = explode(':', $delay_time[0]);
                                    $day = (int)((int)$days[0] / 24);
                                    echo $delay_time[0] . " (" . $day . " Days)";
                                    ?></td>
                                <td><?php
                                    $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 0 GROUP BY f.file_track_no;");
                                    $sql->bindParam(1, $dept_arr['dept_id']);
                                    $sql->execute();
                                    echo $sql->rowCount();
                                    ?>
                                </td>

                                <td><?php
                                    $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 1 GROUP BY f.file_track_no;");
                                    $sql->bindParam(1, $dept_arr['dept_id']);
                                    $sql->execute();
                                    echo $sql->rowCount();
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no  GROUP BY f.file_track_no;");
                                    $sql->bindParam(1, $dept_arr['dept_id']);
                                    $sql->execute();
                                    echo $sql->rowCount();
                                    ?>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>
                </table>
                <br>
                <br>
            </div>
            <div id="div_officer">
                <!-- <h5> Officers </h5> -->
                <label>Department</label>
                <br>
                <div class="row">
                    <div class="col-3">
                        <form class="form">
                            <select name="deptId" id="" class="form-control" onChange="getOfficersDetails(this.value)">
                                <option disabled selected>Select Department</option>
                                <?php
                                $deptSql = $conn->prepare("SELECT * FROM tbldept WHERE dept_active = 1");
                                $deptSql->execute();
                                $departments = $deptSql->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($departments as $department) {
                                ?>
                                    <option value="<?php echo $department['dept_id'] ?>"><?php echo $department['dept_name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row" id="officerDetails">

                </div>

                <br>
            </div>
            <div id="div_search">
                <!-- <h5> Search Files </h5> -->
                <br>
                <form class="form" name="adfiles" method="POST">

                    <div class="row text-center ">
                        <div class="col">
                            <label>From:</label>
                            <input type="date" class="form-control" id="s_date" placeholder="Start Date" name="sdate" required>
                        </div>
                        <div class="col">
                            <label>To:</label>
                            <input type="date" class="form-control" id="e_date" placeholder="End Date" name="edate" required>
                        </div>
                        <div class="col">
                            <input type="button" class="btn btn-primary" value="Search Files" onClick=getFileList()>
                        </div>
                    </div>
                </form>
                <div id="list">
                </div>
            </div>
        </div>
        <br><br>
    </div>
    <?php include '../footer.php'; ?>
    </body>
    <script>
        document.getElementById('my-nav').classList.remove('active');
        document.getElementById("file-nav").classList.remove('active');
        document.getElementById("manage-nav").classList.remove('active');
        document.getElementById("dash-nav").classList.add('active');

        function getFileList() {
            var s_date = document.getElementById("s_date").value;
            var e_date = document.getElementById("e_date").value;


            $.ajax({
                    method: "POST",
                    url: "./backend/getFileList.php",
                    dataType: "html",
                    data: {
                        sdate: s_date,
                        edate: e_date
                    }
                })
                .done(function(data) {
                    $("#list").html(data);
                });
        }

        function getOfficersDetails(deptId) {
            $.ajax({
                    method: "POST",
                    url: "./backend/getOfficerDetails.php",
                    dataType: "html",
                    data: {
                        deptId: deptId
                    }
                })
                .done(function(data) {
                    $("#officerDetails").html(data);
                });
        }
        $(document).ready(function() {
            $('#myTable').DataTable();
            $('#myTable1').DataTable();
        });

        $('#div_dept').show();
        $('#div_search').hide();
        $('#div_officer').hide();

        $('#div_dept_menu').click(function() {
            $('#div_dept').show(function() {
                $('#div_dept_menu').addClass('active')
            });
            $('#div_search').hide(function() {
                $('#div_search_menu').removeClass('active')
            });
            $('#div_officer').hide(function() {
                $('#div_officer_menu').removeClass('active')
            });
        })
        $('#div_search_menu').click(function() {
            $('#div_search').show(function() {
                $('#div_search_menu').addClass('active')
            });
            $('#div_dept').hide(function() {
                $('#div_dept_menu').removeClass('active')
            });
            $('#div_officer').hide(function() {
                $('#div_officer_menu').removeClass('active')
            });
        })
        $('#div_officer_menu').click(function() {
            $('#div_officer').show(function() {
                $('#div_officer_menu').addClass('active')
            });
            $('#div_search').hide(function() {
                $('#div_search_menu').removeClass('active')
            });
            $('#div_dept').hide(function() {
                $('#div_dept_menu').removeClass('active')
            });
        })
    </script>

    </html>
<?php
}
?>