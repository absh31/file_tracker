<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

    if ($key['role_name'] == "Admin") {
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>File Category</h5>
                </div>
            </div>
            <br>

            <?php
            if (isset($_GET['id'])) {

                $fileCatId = $_GET['id'];
                $sql = $conn->prepare("SELECT * FROM `tblfilecat` WHERE filecat_id =?");
                $sql->bindParam(1, $fileCatId);
                $sql->execute();
                $key = $sql->fetch(PDO::FETCH_ASSOC);

            ?>
                <table class="table align-middle table-fluid">
                    <tbody>
                        <tr>
                            <td>Category</td>
                            <td><?php echo $key['filecat_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Format</td>
                            <td><?php echo $key['filecat_format']; ?></td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><?php echo $key['filecat_remarks']; ?></td>
                        </tr>
                        <tr>
                            <td>Document</td>
                            <?php if ($key['filecat_doc_path'] != ''){
                                 ?>
                            <td><a class="btn btn-dark" href="<?php echo $key['filecat_doc_path']; ?>" target="_blank">View</a></td>
                                <?php }else{
                                    ?>
                                    <td class="text text-danger">No Document</td>
                                <?php
                                }
                                ?>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><?php echo $key['filecat_remarks']; ?></td>
                        </tr>

                    </tbody>
                </table>
            <?php
            }
            ?>
        </div>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>
        <script>
            document.getElementById('file-nav').classList.remove('active');
            document.getElementById("manage-nav").classList.add('active');
            document.getElementById("dash-nav").classList.remove('active');
        </script>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>