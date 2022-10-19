<?php
// echo date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime('2022-10-04 12:11:54' . '+60 minutes')) ? '1' : '0';
date_default_timezone_set("Asia/Kolkata");
echo date('Y-m-d H:i:s');
?>




<h5> Departments </h5>
        <table class="table cell-border" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Pending Files</th>
                    <th scope="col">Completed Files</th>
                    <th scope="col">Total Files</th>
                    <th scope="col">FT Score</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                                    $dept_sql = $conn->prepare("SELECT * FROM tbldept");
                                   

                                    $dept_sql->execute();
                                    while($dept_arr = $dept_sql->fetch(PDO::FETCH_ASSOC)){
                                      
                                        ?>
                                        <tr>
                                            <td><?=$dept_arr['dept_name']?></td>
                                            <td><?php
                                                // $delaySql = $conn->prepare("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(activity_ack_time, activity_time)))) AS delay_time FROM tblactivity WHERE activity_to = ? AND activity_type = 'FORWARDED';");
                                                // $delaySql->bindParam(1, $dept_sql['dept_id']);
                                                // $delaySql->execute();
                                                // $delay = $delaySql->fetch();
                                                // $delay_time = explode('.', $delay['delay_time']);
                                                // echo $delay_time[0];
                                            ?></td>
                                            <td><?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 0 GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
                                                $sql->execute();
                                                echo $sql->rowCount();
                                            ?>
                                        </td>
                                
                                        <td><?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 1 GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
                                                $sql->execute();
                                                echo $sql->rowCount();
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from IN (SELECT officer_id FROM tblofficer WHERE officer_dept_id = ?) AND f.file_track_no = a.activity_file_track_no  GROUP BY f.file_track_no;");
                                                $sql->bindParam(1,$dept_arr['dept_id']);
                                                $sql->execute();
                                                echo $sql->rowCount();
                                            ?>
                                        </td>
                                            </tr>
                                    
                                        <?php
                                    }
                                    ?>
                
            </tbody>
        </table>
        <br>
        <br>
        <h5> Officers </h5>
        <table class="table cell-border" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Pending Files</th>
                    <th scope="col">Completed Files</th>
                    <th scope="col">Total Files</th>
                    <th scope="col">FT Score</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                                    $dept_sql = $conn->prepare("SELECT * FROM tblofficer");
                                    $dept_sql->execute();
                                    $sql2 = $conn->prepare("SELECT COUNT(*) as count FROM tblfile WHERE file_completed=1 GROUP BY file_added_by;");
                                    $sql2->execute();
                                    
                                    $sql4 = $conn->prepare("SELECT COUNT(*) as count FROM tblfile GROUP BY file_added_by;");
                                    $sql4->execute();
                                    
                                        // $sql3=$sql3->fetch();
                                    while($dept_arr = $dept_sql->fetch(PDO::FETCH_ASSOC) AND $sql2_arr = $sql2->fetch(PDO::FETCH_ASSOC) AND $sql4_arr = $sql4->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $sql3 = $conn->prepare(" SELECT * FROM tblfile WHERE file_completed = 0 AND file_current_holder =1 AND file_added_by = ?;");
                                        $sql3->bindParam(1,$dept_arr['officer_id']);
                                        $sql3->execute();
                                        
                                        
                                        ?>
                                        <tr>
                                            <td><?=$dept_arr['officer_name']?></td>
                                            <td></td>
                                            <td><?php 
                                            echo $sql3->rowCount();
                                            ?></td>
                                            <td><?=$sql2_arr['count']?></td>
                                            <td><?=$sql4_arr['count']?></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                
            </tbody>
        </table>