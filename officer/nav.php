<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php
    // echo $_SERVER['PHP_SELF'];
    if ($_SERVER['PHP_SELF'] != '/file_tracker/index.php') {
    ?>
        <div class="container-fluid px-5" style="background-color : #FFFFFF">
            <div class="row mx-5 py-2">
                <div class="col mt-3" id="logo1">
                    <img src="../uploads/images/logo1.png" alt="">
                </div>
                <div class="col text-center mt-3">
                    <a class="navbar-brand" href="./" style="font-weight: 800; color:black; font-size:40;">
                        FILE TRACKER
                    </a>
                </div>
                <div class="col text-end" id="logo2">
                    <img src="../uploads/images/logo2.png" alt="">
                </div>
            </div>
        </div>
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark" id="navigation" style="background-color : black">
            <div class="container-fluid px-5">
                <a class="navbar-brand" href="./" style="font-weight: 800;">
                    FILE TRACKER
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="dash-nav" class="nav-link" aria-current="page" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="file-nav" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Files
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./addFile.php">Add File</a></li>
                                <li><a class="dropdown-item" href="./trackFile.php">Track File</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a id="my-nav" class="nav-link" aria-current="page" href="myFile.php">My Files</a>
                        </li>
                    </ul>
                    <a class="btn btn-outline-light btn-floating mx-3" href="./redirect.php" role="button"><i class="fa fa-user my-1"></i> Change Session</a>
                    <a href="./changePassword.php">
                        <button class="btn text-light border-light" name="logout" type="submit">Change Password</button>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="../logout.php">
                        <button class="btn btn-outline-light" name="logout" type="submit"><i class="fa fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                    </a>
                </div>
            </div>
        </nav>
    <?php
    } else {
    ?>

    <?php
    }
    ?>