<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['auth'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
    include('../backend/checkSession.php');
    checkSession();
    include("../header.php");
    include("./nav.php");
?>
    <br />
    <div class="container">
        <div class="col-md-5 mx-auto my-5 p-4">
            <div class="row">
                <div class="col text-center">
                    <h4 style="font-weight: 700; color : #000000;">Change Password</h4>
                    <hr>
                </div>
            </div>
            <div class="px-3 mb-4 pt-3 apply">
                <form method="POST" action="./backend/changePassword.php" onsubmit="return checkPass()">
                    <div class="mt-3 headingsall">
                        <label name="currPassword" style="margin-bottom : 10px; color : #000000; font-weight : 600;">Current Password</label>
                        <input name="currPassword" type="password" class="form-control" required="required" placeholder="Enter Current Password" style="border : 2px solid #000000; opacity : 0.7">
                    </div>
                    <div class="mt-3 headingsall">
                        <label name="newPassword" style="margin-bottom : 10px; color : #000000; font-weight : 600;">New Password</label>
                        <input name="newPassword" id="newPass" type="password" class="form-control" required="required" placeholder="Enter New Password" style="border : 2px solid #000000; opacity : 0.7">
                    </div>
                    <div class="mt-3 headingsall">
                        <label name="confirmPassword" style="margin-bottom : 10px; color : #000000; font-weight : 600;">Confirm Password</label>
                        <input name="confirmPassword" id='confirmPass' type="password" class="form-control" required="required" placeholder="Confirm Password" style="border : 2px solid #000000; opacity : 0.7">
                    </div>
                    <div class="col-md-6 mx-auto my-4 text-center">
                        <input type="submit" name="changePass" class="btn text-light py-2 px-5" style="background-color : #000000" value="Change Password" />
                    </div>
                </form>
                <div class="col-md-6 mx-auto my-4 text-center">
                    <a href="./dashboard.php">
                        <input type="submit" name="" class="btn text-light py-2 px-5" style="background-color : #000000" value="Cancel" />
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
    include '../footer.php';
}
?>
<script>
    document.getElementById('my-nav').classList.remove('active');
    document.getElementById("file-nav").classList.remove('active');
    document.getElementById("manage-nav").classList.remove('active');
    document.getElementById("dash-nav").classList.remove('active');

    function checkPass() {
        var pass = document.getElementById("newPass").value;
        var confirmPass = document.getElementById("confirmPass").value;
        console.log(pass);
        console.log(confirmPass);
        if (pass !== confirmPass) {
            alert('Passwords does not match!');
            return false;
        } else {
            return true;
        }
    }
</script>