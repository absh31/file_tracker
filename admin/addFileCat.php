<?php
session_start();
include('../backend/checkSession.php');
checkSession();
include "../header.php";
include '../connection.php';
include './nav.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col">
                <h5>Add Category</h5>
            </div>
        </div>
        <br>
        <form action="./backend/addFileCat.php" enctype="multipart/form-data" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td>Category Name</td>
                            <td><input class="form-control" type="text" name="catName" id="file_title" required></td>
                        </tr>
                        <tr>
                            <td>Category Format</td>
                            <td><textarea class="form-control" name="catFormat" id="dept_email" required></textarea></td>
                        </tr>
                        <tr>
                            <td>Category Document</td>
                            <td><input type="file" name="catDoc"> </td>
                        </tr>
                        <tr>
                            <td>File Remarks</td>
                            <td><textarea class="form-control" name="catRemarks" id="dept_remarks"></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./fileCategory.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-5" type="submit" name="addCat" value="Add">
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>

    <script>
        document.getElementById('my-nav').classList.remove('active');
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("manage-nav").classList.add('active');
        document.getElementById("dash-nav").classList.remove('active');
    </script>
<?php
}
?>