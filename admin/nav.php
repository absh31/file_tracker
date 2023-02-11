<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="container-fluid px-5" style="background-color : #FFFFFF">
        <div class="row py-2">
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
    <nav class="navbar container-fluid px-5 sticky-top navbar-expand-lg navbar-dark" id="navigation" style="background-color : black">
        <a class="navbar-brand" href="./" style="font-weight: 800;">
            FILE TRACKER
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a id="dash-nav" class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manage-nav" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="./roles.php">Roles</a></li>
                        <li><a class="dropdown-item" href="./dept.php">Departments</a></li>
                        <li><a class="dropdown-item" href="./officer.php">Officers</a></li>
                        <li><a class="dropdown-item" href="./fileCategory.php">File Category</a></li>
                        <li><a class="dropdown-item" href="./fileUploadType.php">File Upload </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a id="my-nav" class="nav-link active" aria-current="page" href="myFile.php">My Files</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="file-nav" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Files
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="./files.php">Files</a></li>
                        <li><a class="dropdown-item" href="./addFile.php">Add File</a></li>
                        <li><a class="dropdown-item" href="./trackFile.php">Track File</a></li>
                    </ul>
                </li>
            </ul>
            &nbsp;
            <a href="./changePassword.php">
                <button class="btn text-light border-light" name="logout" type="submit">Change Password</button>
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="../logout.php">
                <button class="btn text-light border-light" name="logout" type="submit">Logout</button>
            </a>

        </div>
    </nav>