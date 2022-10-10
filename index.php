<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
include './connection.php';
include "header.php";
include "nav.php";
?>
<style>
    body {
        background-image: url(./uploads/images/login_bg_1.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    @media screen and (max-width : 600px) {
        #logo1{
            display: none;
        }
        #logo2{
            display: none;
        }
    }
</style>
<br>
<div class="container">
    <div class="col-md-5 mx-auto my-5 p-4 transparent" style="background : url(./uploads/images/Rectangle32.png) ">
        <div class="row">
            <div class="col text-center">
                <h4 style="font-weight: 700; color : #000000;">Login</h4>
                <hr>
            </div>
        </div>
        <div class="px-3 mb-4 pt-3 apply">
            <form method="post" action="./backend/logon.php">
                <div class="mt-3 headingsall">
                    <label name="username" style="margin-bottom : 10px; color : #000000; font-weight : 600;">Username</label>
                    <!-- <label name="username">Username</label> -->
                    <input name="username" type="text" class="form-control" required="required" placeholder="Enter Username" style="border : 2px solid #000000; opacity : 0.7">
                </div>
                <div class="mt-3 headingsall">
                    <label name="password" style="margin-bottom : 10px; color : #000000; font-weight : 600;">Password</label>
                    <!-- <label name="password">Password</label> -->
                    <input name="password" type="password" class="form-control" required="required" placeholder="Enter Password" style="border : 2px solid #000000; opacity : 0.7">
                </div>
                <div class="form-group mt-4">
                    <div class="g-recaptcha" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <div class="col-md-6 mx-auto my-4 text-center">
                    <input type="submit" name="AuthLogin" class="btn text-light py-2 px-5" style="background-color : #000000" value="Login" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="space" style="margin-bottom: 8.4%;"></div>
</body>
<?php include './footer.php';?>