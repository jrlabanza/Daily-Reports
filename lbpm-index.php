<?php include "includes/header.php";

    $_SESSION['report_type'] = 5;
    
    $status = "";
    $status_color = "";
    
    

    


?>

<form method="post">
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content text-center">
      <div class="modal-header">
        <h4 class="modal-title text-center">HISTORY FILTER</h4>
      </div>
      <div class="modal-body">
        <label><h5><p>DATE</p></h5></label>
        <h5><p>From:</p></h5>
        <input class="form-group searchdate" name="startDate">
        <h5><p>To:</p></h5>
        <input class="form-group searchdate" name="endDate">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary mr-auto" name="search" value="SEARCH DATE">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- DATATABLE -->

<div style="padding-top: 60px;">
 <div class="card" style="margin-left:10px; margin-right:10px;">
    <div class="card-header" style="font-size:15px;">LOADBOARD PREVENTIVE MAINTENANCE
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:0px;">FILTER RECORD</button>
       </div>
        <div class="card-body">
          
                <table class="record table-bordered table-hover" width="100%" cellspacing="0"  style="font-size:8px;">
                      <thead>
                          <tr>
                            <th>DATE</th>
                            <th>TESTER</th>
                            <th>HANDLER</th>
                            <th>FAMILY NAME</th>
                            <th>LOADBOARD ID</th>
                            <th>LOADBOARD NAME</th>
                            <th>PM FINDINGS</th>
                            <th>ACTION DONE</th>
                            <th>PREVENTIVE ACTION</th>
                            <th>DOWNTIME</th>
                            <th>STATUS</th>
                            <th>PM DATE</th>
                            <th>PM DUE</th>
                            <th>SUBMITTER</th>
                            <th>FUNCTION TEST FINDINGS</th>
                            <th>PROBLEM DESCRIPTION</th>
                            <th>ACTION DONE</th>
                            <th>ROOT CAUSE</th>
                            <th>UPDATER</th>
                            <th>VIEW</th>
                            </tr>
                     </thead>
                    <tbody>

<?php
 ///////SHOW DATA FROM DATABASE////////////////////////////////////////////////////////////////////////
if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
         
    $showallrec_query ="SELECT * from lbpm_reports WHERE isDeleted = 0 ORDER BY date DESC";
    $result = mysqli_query($connection, $showallrec_query);
}
     
else{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $newquery ="SELECT * FROM lbpm_reports WHERE DATE(date) BETWEEN '$startDate' and '$endDate' order by date DESC";
    $result = mysqli_query($connection, $newquery);  
}
                         
                 while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                    <td><?php echo $row["date"]?></td>
                    <td><?php echo $row["tester"]?> </td>
                    <td><?php echo $row["handler"]?> </td>
                    <td><?php echo $row["fam_name"]?> </td>
                    <td><?php echo $row["LB_id"]?> </td>
                    <td><?php echo $row["lb_name"]?> </td>
                    <td><?php echo $row["pfd"]?></td> 
                    <td><?php echo $row["action_d"]?> </td>
                    <td><?php echo $row["pre_vac"]?> </td>
                    <td><?php echo $row["dt"]?></td>
                    <?php
                        if ($row["stat"] == 0){
    
                            $status = "DONE PM/FOR FUNCTION TEST";
                            $status_color = "";
                            
                        }
                        else if ($row["stat"] == 1){

                            $status = "PASSED";
                            $status_color = "#71f442";
                        }
                        else if ($row["stat"] == 2){

                            $status = "FAILED";
                            $status_color = "#ff2626";
                        }
                                                            
                     echo "<td style='background-color:". $status_color .";'>". $status ."</td>"    
                        
                        ?>
                   
                    <td><?php echo $row["pm_date"]?></td>
                    <td><?php echo $row["pm_due"]?></td>
                    <td><?php echo $row["submitter"]?></td>
                    <td><?php echo $row["ftf"]?></td>
                    <td><?php echo $row["prob_des"]?></td>
                    <td><?php echo $row["ad"]?></td>
                    <td><?php echo $row["rc"]?></td>
                    <?php $sql = "SELECT * FROM employeeinfos WHERE ffId ='". $row['updater_ffId'] ."'";
                    $res = $userconnect->query($sql);
                    $user = get_data_array($res);
                    if (isset($row['updater_ffId'])){ ?>
                        <td><?php echo $user['firstName']. " " .$user['lastName']?></td>
                    <?php }
                    else {
                        echo "<td></td>";
                    }    
                        ?>
                    
                    <td> <a href="dr_update.php?id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" role="button" name="edit"><i class="fas fa-eye"></i></a></td>
                            
       
        
        </tr>
       

          <?php } ?>
                     </tbody>
                </table>
            
        
    </div>
</div>
        
<?php

    $connection-> close();        
    

     include "includes/footer.php";
                
?>
       
                



   
    
    
    



