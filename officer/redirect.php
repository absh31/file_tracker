<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include('../backend/checkSession.php');
    checkSession();
    include("../connection.php");
    include "../header.php";
    unset($_SESSION['id']);
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col">
                <h5>Hey, <?= ucwords($_SESSION['officer_name']) ?></h5>

            </div>
        </div>
        <!-- <h3 class="dept-title">Select Role :</h3> -->
        <div class="px-4 mb-4 pt-3 apply" style="border: 1px solid #003865;">
            <div class="row">
                <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Select Session</h6>
                <?php
                $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE `officer_username` = ?");
                $sql->bindParam(1, $_SESSION['username']);
                $sql->execute();
                $keys = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($keys as $key) {
                    $deptsql = $conn->prepare("SELECT * FROM `tbldept` WHERE dept_id = ?");
                    $deptsql->bindParam(1, $key['officer_dept_id']);
                    $deptsql->execute();
                    $deptkey = $deptsql->fetch(PDO::FETCH_ASSOC);

                    $rolesql = $conn->prepare("SELECT * FROM `tblrole` WHERE role_id = ?");
                    $rolesql->bindParam(1, $key['officer_role_id']);
                    $rolesql->execute();
                    $rolekey = $rolesql->fetch(PDO::FETCH_ASSOC);
                ?>
                    <div class="col-sm">
                        <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center font-weight-bold" style="font-size: 30px; color: #003975;">
                                        <?php
                                        echo "Department : " . $deptkey['dept_name'] . "<br>";
                                        echo "Role : " . $rolekey['role_name'] . "<br>";
                                        echo "<a class='btn btn-dark mt-2 px-3' href='../officer/backend/redirect.php?id=" . $key['officer_id'] . "'>Login</a>";
                                        ?>
                                    </h5>
                                </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <br>
        </div>
        <div class="row">
            <div class="col text-right">
                <a class="btn btn-dark" href="../logout.php">Logout</a>
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