<?php include "includes/header.php";

$_SESSION['report_type'] = 10;
    
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
    <div class="card-header" style="font-size:15px;">ONLINE SETUP REQUEST
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
    </div>
      <div class="card-body">

        <table class="record table-sm table-bordered table-hover" width="100%" cellspacing="0"  style="font-size:12px;">
            <thead>
                <tr>
                  <th>DATE/TIME</th>
                  <th>SUBMITTER</th>
                  <th>FAMILY NAME</th>
                  <th>PACKAGE</th>
                  <th>HANDLER</th>
                  <th>PLATFORM</th>
                  <th>STATUS</th>
                  <th>HOURS OPEN</th>
                  <th>UPDATER</th>
                  <th>DATE UPDATED</th>
                  <th width='50'>VIEW</th>
                </tr>
            </thead>
            <tbody><?php
              ///////SHOW DATA FROM DATABASE////////////////////////////////////////////////////////////////////////
              if (empty($_POST['startDate'])  && empty($_POST['endDate']))
              {     
                      
                  $showallrec_query ="SELECT * from m3_reports WHERE isDeleted = 0 ORDER BY date_submitted DESC";
                  $result = mysqli_query($connection, $showallrec_query);

              }
                  
              else
              {

                  $startDate = $_POST['startDate'];
                  $endDate = $_POST['endDate'];
                  $newquery ="SELECT * FROM m3_reports WHERE DATE(date_submitted) BETWEEN '$startDate' and '$endDate' order by date_submitted DESC";
                  $result = mysqli_query($connection, $newquery);  

              }
                                      
                while ($row = mysqli_fetch_array($result))
                {
                  
                  if ($row["status"]== "FOR PREPARATION")
                  {
                      $now = time();
                      $your_date = strtotime($row["for_preparation_date"]);
                      $datediff = $now - $your_date;
                      $hoursOpen = round($datediff / (60 * 60 * 24));

                      $status_date = $row['for_preparation_date'];
                      $status_updater = $row['for_preparation_updater'];
                      $statColor = "#dee2e6";
                  }
                  else if ($row["status"]== "ON GOING PREPARATION")
                  {
                    $now = time();
                    $your_date = strtotime($row["ongoing_preparation_date"]);
                    $datediff = $now - $your_date;
                    $hoursOpen = round($datediff / (60 * 60 * 24));

                      $status_date = $row['ongoing_preparation_date'];
                      $status_updater = $row['ongoing_preparation_updater'];
                      $statColor = "#dee2e6";
                  }
                  // else if ($status == "FOR PICK UP FROM CENTRAL SHOP")
                  // {
                  //     $status_date = $row['for_pickup_cshop_date'];
                  //     $status_updater = $row['for_pickup_cshop_updater'];
                  //     $statColor = "#dee2e6";
                      
                  // }
                  else if ($row["status"] == "READY FOR BUY OFF")
                  {
                    $now = time();
                    $your_date = strtotime($row["ready_for_buyoff_date"]);
                    $datediff = $now - $your_date;
                    $hoursOpen = round($datediff / (60 * 60 * 24));

                      $status_date = $row['ready_for_buyoff_date'];
                      $status_updater = $row['ready_for_buyoff_updater'];
                      $statColor = "#e7f56c";
                  }
                  // else if ($row["status"]== "READY FOR PICK UP")
                  // {
                  //     $status_date = $row['ready_for_pickup_date'];
                  //     $status_updater = $row['ready_for_pickup_updater'];
                  //     $statColor = "#e7f56c";
                  // }
                  else if ($row["status"] == "RELEASED")
                  {
                    $now = time();
                    $your_date = strtotime($row["date_submitted"]);
                    $datediff = $now - $your_date;
                    $hoursOpen = round($datediff / (60 * 60 * 24));

                      $status_date = $row['released_date'];
                      $status_updater = $row['released_updater'];
                      $statColor = "#71f442";
                  }
                  else{
                    $statColor ="";
                    $hoursOpen = "";
                  }?>
                    <tr>
                    <td><?php echo $row["date_submitted"]?></td>
                    <td><?php echo $row["submitter"]?> </td>
                    <td><?php echo $row["family_PS"]?> </td>
                    <td><?php echo $row["package_PS"]?> </td>
                    <td><?php echo $row["handler_CS"]?> </td>
                    <td><?php echo $row["handler_platform_CS"]?> </td>
                    <td style="background-color:<?php echo $statColor ?>"><?php echo $row["status"]?> </td>
                    <td><?php echo $hoursOpen ?></td>
                    <td><?php echo $status_updater?></td>
                    <td><?php echo $status_date?></td>
                    <td> <a href="dr_update.php?id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" role="button" name="edit"><i class="fas fa-eye"></i></a></td> 
                    </tr><?php    
                }?>
            </tbody>
          </table>
    </div>
</div>
        
<?php

    $connection-> close();        
    

     include "includes/footer.php";
                
?>
       
                



   
    
    
    



