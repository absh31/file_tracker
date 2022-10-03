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
                    <h5>Add Department</h5>
                </div>
            </div>
            <br>
            <form action="./backend/addRole.php" method="POST">
                <div class="row">
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>Role Name</td>
                                <td><input class="form-control" type="text" name="roleName" id="dept_name" required></td>
                            </tr>
                            <tr>
                                <td>Add Role After</td>
                                <td>
                                    <select name="rolePriority" id="rolePriority" class="form-control" required>
                                        <option value="" selected disabled>Add Role After</option>
                                        <?php
                                        $role_sql = $conn->prepare("SELECT DISTINCT(role_name) AS role_name, role_priority FROM tblrole WHERE role_active = 1");
                                        $role_sql->execute();
                                        $roles = $role_sql->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($roles as $role) {
                                        ?>
                                            <option value="<?php echo $role['role_priority'] ?>"><?php echo $role['role_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col text-center">
                        <a href="./roles.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                        <input class="btn btn-dark px-5" type="submit" name="addRole" value="Add">
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>