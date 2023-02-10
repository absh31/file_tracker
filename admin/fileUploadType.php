<?php
session_start();
include('../backend/checkSession.php');
checkSession();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    
    $xml = simplexml_load_file("../settings.xml");
    $array = array();
    foreach ($xml->fileType as $child) {
        array_push($array, strval($child[0]));
    }
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col">
                <h5>Manage File Upload Types</h5>
            </div>
        </div>
        <br>
        <div class="row">
            <form class="form-control" action="./backend/fileUploadType.php" method="POST">
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="jpg" <?php if(in_array('jpg', $array)){echo 'checked';}?>/> JPG<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="jpeg" <?php if(in_array('jpeg', $array)){echo 'checked';}?>/> JPEG<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="png" <?php if(in_array('png', $array)){echo 'checked';}?>/> PNG<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="pdf" <?php if(in_array('pdf', $array)){echo 'checked';}?>/> PDF<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('xlsx', $array)){echo 'checked';}?>/> XLSX<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('doc', $array)){echo 'checked';}?>/> DOC<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('docx', $array)){echo 'checked';}?>/> DOCX<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('txt', $array)){echo 'checked';}?>/> TXT<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('ppt', $array)){echo 'checked';}?>/> PPT<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('pptx', $array)){echo 'checked';}?>/> PPTX<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('odp', $array)){echo 'checked';}?>/> ODP<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('rtf', $array)){echo 'checked';}?>/> RTF<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('zip', $array)){echo 'checked';}?>/> ZIP<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('rar', $array)){echo 'checked';}?>/> RAR<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('csv', $array)){echo 'checked';}?>/> CSV<br/>
                <input class="form-check-input" type="checkbox" name="fileUpload[]" value="xlsx" <?php if(in_array('tar', $array)){echo 'checked';}?>/> TAR<br/>

                <input class="btn btn-submit btn-success" type="submit" name="fileUploadType" value="Allow" />
<!-- doc, docx, txt, ppt, pptx, odp, rtf, zip, rar, csv, tar,   -->
            </form>
        </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>

    <script>
        document.getElementById('my-nav').classList.remove('active');
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("manage-nav").classList.add('active');
        document.getElementById("dash-nav").classList.remove('active');
        $(document).ready(function() {
            $(".delete").on('click', function() {
                if (confirm("Are you sure you want to delete")) {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "backend/deleteFileCat.php",
                        data: {
                            fileCatId: id
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                }
            })
        });
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>