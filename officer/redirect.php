<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include("../connection.php");
    include "../header.php";
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Hey, <?= ucwords($_SESSION['officer_name']) ?></h5>
            </div>
            <!-- <h3 class="dept-title">Select Role :</h3> -->
            <div class="px-4 mb-4 pt-3 apply" style="border: 1px solid #003865;">
                <div class="row">
                    <h6 class="card-title text-left font-weight-bold" style="font-size: 30px; color: #003975;">Select Role</h6>
                    <div class="col-sm">
                        <div class="card">
                            <a href="#">
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
</a>
                        </div>
                    </div>
                </div>
                <br>
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