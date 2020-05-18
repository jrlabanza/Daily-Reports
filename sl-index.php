<?php include "includes/header.php";

$_SESSION['report_type'] = 2;
    
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
    <div class="card-header" style="font-size:15px;">SPEEDLOSS REPAIR REPORTS
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
       </div>
        <div class="card-body">
          
                 <table class="record table-sm table-bordered table-hoverr" width="100%" cellspacing="0"  style="font-size:8px;">
                      <thead>
                          <tr>
                            <th>DATE/TIME</th>
                            <th>TESTER ID</th>
                            <th>TESTER PF</th>
                            <th>HANDLER</th>
                            <th>HANDLER PF</th>
                            <th>DEVICE</th>
                            <th>STATUS</th>
                            <th>STATUS OWNER</th>
                            <th>DURATION</th>
                            <th>WHO[REPAIR]</th>
                            <th>PROBLEM</th>
                            <th>WHO[UPDATE]</th>
                            <th>ACTION DONE</th>
                            <th>COMMIT</th>
                            <th>STATUS</th>
                            <th>REMARKS</th>
                            <th>SUBMITTER</th>
                            <th>VIEW</th>
                            </tr>
                     </thead>
                    <tbody>

<?php
 ///////SHOW DATA FROM DATABASE////////////////////////////////////////////////////////////////////////
if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
         
    $showallrec_query ="SELECT * from speedloss WHERE isDeleted = 0 ORDER BY sl_date DESC";
    $result = mysqli_query($connection, $showallrec_query);
}
     
else{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $newquery ="SELECT * FROM speedloss WHERE DATE(sl_date) BETWEEN '$startDate' and '$endDate' order by sl_date DESC";
    $result = mysqli_query($connection, $newquery);  
}
                         
                 while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                    <td><?php echo $row["sl_date"]?></td>
                    <td><?php echo $row["tester_id"]?> </td>
                    <td><?php echo $row["tester_pf"]?> </td>
                    <td><?php echo $row["handler"]?> </td>
                    <td><?php echo $row["handler_pf"]?> </td>
                    <td><?php echo $row["device"]?> </td>
                    <td><?php echo $row["sl_status_owner"]?> </td>
                    <td><?php echo $row["status_owner"]?> </td>
                    <td><?php echo $row["duration"]?></td>
                    <td><?php echo $row["who_1"]?></td> 
                    <td><?php echo $row["problem"]?> </td>
                    <td><?php echo $row["who_2"]?></td> 
                    <td><?php echo $row["act_done"]?> </td>
                    <td><?php echo $row["sl_commit"]?></td>
                    <td><?php echo $row["sl_status"]?></td>
                    <td><?php echo $row["sl_remarks"]?></td>
                    <td><?php echo $row["submitter"]?> </td>
                    <td> <a href="dr_update.php?id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" role="button" name="edit"><i class="fas fa-eye"></i></a></td>
                            
       
        
        </tr>
       

          <?php }?>
                     </tbody>
                </table>
            
        
    </div>
</div>
        
<?php

    $connection-> close();        
    

     include "includes/footer.php";
                
?>
       
                



   
    
    
    



