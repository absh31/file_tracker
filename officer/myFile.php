<?php
session_start();
include "../header.php";
include './nav.php';
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    echo $_SESSION['officer_name'];
}
?>
<?php include '../footer.php'; ?>

<script>
    document.getElementById('file-nav').classList.add('active');
    document.getElementById("my-nav").classList.remove('active');
    document.getElementById("dash-nav").classList.remove('active');
</script>