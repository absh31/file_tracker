<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['auth']) ){
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include("../connection.php");
    include("../header.php");
    include("./nav.php");
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
                                    $todayCountSql = $conn->prepare("SELECT COUNT(*) AS today_cnt FROM tblfile WHERE file_time LIKE ?");
                                    $todayCountSql->bindParam(1, $today);
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
            <table>
            </table>
        </div>
        <h5> Departments </h5>
        <table class="table cell-border" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Pending Files</th>
                    <th scope="col">Completed Files</th>
                    <th scope="col">Total Files</th>
                    <th scope="col">FT Score</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                                    $dept_sql = $conn->prepare("SELECT * FROM tbldept");
                                   

                                    $dept_sql->execute();
                                    while($dept_arr = $dept_sql->fetch(PDO::FETCH_ASSOC)){
                                      
                                        ?>
                                        <tr>
                                            <td><?=$dept_arr['dept_name']?></td>
                                            <td><?php
                                                // $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED';");
                                                // $delaySql->bindParam(1, $dept_sql['dept_id']);
                                                // $delaySql->execute();
                                                // $delay = $delaySql->fetch();
                                                // $delay_time = explode('.', $delay['delay_time']);
                                                // echo $delay_time[0];
                                            ?></td>
                                            <td><?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 0 GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
                                                $sql->execute();
                                                echo $sql->rowCount();
                                            ?>
                                        </td>
                                
                                        <td><?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 1 GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
                                                $sql->execute();
                                                echo $sql->rowCount();
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no  GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
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
        <h5> Officers </h5>
        <table class="table cell-border" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Pending Files</th>
                    <th scope="col">Completed Files</th>
                    <th scope="col">Total Files</th>
                    <th scope="col">FT Score</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                                    $dept_sql = $conn->prepare("SELECT * FROM tblofficer");
                                    $dept_sql->execute();
                                    $sql2 = $conn->prepare("SELECT COUNT(*) as count FROM tblfile WHERE file_completed=1 GROUP BY file_added_by;");
                                    $sql2->execute();
                                    
                                    $sql4 = $conn->prepare("SELECT COUNT(*) as count FROM tblfile GROUP BY file_added_by;");
                                    $sql4->execute();
                                    
                                        // $sql3=$sql3->fetch();
                                    while($dept_arr = $dept_sql->fetch(PDO::FETCH_ASSOC) AND $sql2_arr = $sql2->fetch(PDO::FETCH_ASSOC) AND $sql4_arr = $sql4->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $sql3 = $conn->prepare(" SELECT * FROM tblfile WHERE file_completed = 0 AND file_current_holder =1 AND file_added_by = ?;");
                                        $sql3->bindParam(1,$dept_arr['officer_id']);
                                        $sql3->execute();
                                        
                                        
                                        ?>
                                        <tr>
                                            <td><?=$dept_arr['officer_name']?></td>
                                            <td></td>
                                            <td><?php 
                                            echo $sql3->rowCount();
                                            ?></td>
                                            <td><?=$sql2_arr['count']?></td>
                                            <td><?=$sql4_arr['count']?></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                
            </tbody>
        </table>
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