
<?php include "includes/header.php";

$_SESSION['report_type'] = 4;

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
    <div class="card-header" style="font-size:15px;">EXTERNAL BOARD REPORTS
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
       </div>
        <div class="card-body">
          
                 <table class="record table table-bordered table-responsive table-hover" width="100%" cellspacing="0"  style="font-size:8px;">
                      <thead>
                          <tr>
                            <th>DATE</th>
                            <th>ITEM DESCRIPTION</th>
                            <th>SERIAL ID</th>
                            <th>REQUESTING PERSONNEL</th>
                            <th>REQUESTING DEPARTMENT</th>
                            <th>PROBLEM FULL DESCRIPTION</th>
                            <th>5-WHY-ANALYSIS</th>
                            <th>ACTION DONE</th>
                            <th>PREVENTIVE ACTION</th>
                            <th>DATE AND TIME RECEIVED</th>
                            <th>DATE AND TIME ENDORSED</th>
                            <th>DOWNTIME</th>
                            <th>STATUS</th>
                            <th>WHO</th>
                            <th>VIEW</th>
                            </tr>
                     </thead>
                    <tbody>

<?php
 ///////SHOW DATA FROM DATABASE////////////////////////////////////////////////////////////////////////
if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
         
    $showallrec_query ="SELECT * from ext_report WHERE isDeleted = 0 ORDER BY ex_date DESC";
    $result = mysqli_query($connection, $showallrec_query);
}
     
else{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $newquery ="SELECT * FROM ext_report WHERE DATE(ex_date) BETWEEN '$startDate' and '$endDate' order by ex_date DESC";
    $result = mysqli_query($connection, $newquery);  
}
                         
                 while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                    <td><?php echo $row["ex_date"]?></td>
                    <td><?php echo $row["item_desc"]?></td>
                    <td><?php echo $row["serial_id"]?> </td>
                    <td><?php echo $row["req_per"]?> </td>
                    <td><?php echo $row["req_dept"]?> </td>
                    <td><?php echo $row["pfd"]?></td> 
                    <td><?php echo $row["fwa"]?> </td>
                    <td><?php echo $row["act_done"]?> </td>
                    <td><?php echo $row["pre_vac"]?> </td>
                    <td><?php echo $row["dtr"]?></td>
                    <td><?php echo $row["dte"]?></td>
                    <td><?php echo $row["dt"]?></td>
                    <td><?php echo $row["ex_status"]?></td>
                    <td><?php echo $row["who"]?></td>
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
       
                



   
    
    
    



