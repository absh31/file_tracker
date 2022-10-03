<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['auth']) ){
    echo "<script>window.open('../index.php','_self')</script>";
}else{
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
                    <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Files Count</h6>
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
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Today</p>
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
                                <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">This Week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center  font-weight-bold" style="font-size: 60px; color: #003975;">
                                    <?php
                                    $officerCountSql = $conn->prepare("SELECT COUNT(*) AS count FROM tblofficer WHERE officer_active = 1");
                                    $officerCountSql->execute();
                                    $officerCount = $officerCountSql->fetch();
                                    echo $officerCount['count'];
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


        </div>
    </div>
    <br><br>
    <script>
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