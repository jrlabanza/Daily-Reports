<?php include "includes/header.php";

    $_SESSION['report_type'] = 1;
    
    $query = "SELECT sample1, sample2 FROM sample";
    $result = $connection->query($query);

    $data = array();
    foreach ($result as $row){
    $data[] = $row;
    }

    // print json_encode($data);
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
              <!-- Area Chart Example-->
              <?php if (isset($_SESSION['userPriv']) && $_SESSION['userPriv'] == 2) { ?>        
          <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-area"></i>
                DATA CHART</div>
              <div class="card-body">
              
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tester</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Machine ID</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">WHO</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><canvas id="ChartTester" width="100%" height="30" style="margin-top:20px;"></canvas></div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><canvas id="ChartMachine" width="100%" height="30" style="margin-top:20px;"></div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><canvas id="ChartWho" width="100%" height="30" style="margin-top:20px;"></div>
              </div>
                
              </div>
          </div>
      <?php } ?> 

 <div class="card" style="margin-left:10px; margin-right:10px;">
    <div class="card-header" style="font-size:15px;">LOADBOARD REPAIR REPORTS
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
       </div>
        <div class="card-body">
          
                 <table class="record table-bordered table-hover table-responsive">
                      <thead>
                          <tr>
                            <th>WW</th>
                            <th>DATE</th>
                            <th>TESTER</th>
                            <th>HANDLER</th>
                            <th>FAMILY NAME</th>
                            <th>LOADBOARD ID</th>
                            <th>LOADBOARD NAME</th>
                            <th>PROBLEM FULL DESCRIPTION</th>
                            <th>5-WHY-ANALYSIS</th>
                            <th>ACTION DONE</th>
                            <th>REPAIR STAGE</th>
                            <th>PREVENTIVE ACTION</th>
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
         
    $showallrec_query ="SELECT * from dailyreports WHERE isDeleted = 0 ORDER BY dr_date DESC";
    $result = mysqli_query($connection, $showallrec_query);
}
     
else{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $newquery ="SELECT * FROM dailyreports WHERE DATE(dr_date) BETWEEN '$startDate' and '$endDate' order by dr_date DESC";
    $result = mysqli_query($connection, $newquery);  
}

                         
                 while ($row = mysqli_fetch_array($result)){
                        $ddate = $row["dr_date"];
                        $date = new DateTime($ddate);
                        $month = $date->format("n");
                        $day = $date->format("j");
                        $year = $date->format("y");
                       
                        if($year == 18){
                            $wwyear = '2018';
                            
                        }

                        else if($year == 19){
                            $wwyear = '2019';
                        }

                        else if($year == 20){
                          $wwyear = '2020';
                      }

                        $CalendarList = file_get_contents($wwyear."_cal.json");
                        $cal = json_decode($CalendarList, true);
                        
                        $findww = $cal[$month]; //week search 
                     
                        $workWeek = 0;
  
                        foreach($findww as $key => $value){ //display week of all id
                         
                           
                            $tempDays = explode(",", $value); // segregate week to array
                            // echo sizeof($tempDays);
                            $tempDaysLen = sizeof($tempDays);
                            
                            for($j=0; $j<$tempDaysLen; $j++){

                                if ($tempDays[$j] == $day){ //if array matches day data = true

                                $workWeek = $key;

                                break;
                                }
                            }
  
                        }
                        
                        
                        ?>
                    <tr>
                      <td><?php echo "WW".$workWeek; ?></td>
                      <td><?php echo $row["dr_date"] ?></td>
                      <td><?php echo $row["tester"] ?> </td>
                      <td><?php echo $row["handler"] ?> </td>
                      <td><?php echo $row["fam_name"] ?> </td>
                      <td><?php echo $row["LB_id"] ?> </td>
                      <td><?php echo $row["lb_name"] ?> </td>
                      <td><?php echo $row["pfd"] ?></td> 
                      <td><?php echo $row["fwa"] ?> </td>
                      <td><?php echo $row["action_d"] ?> </td>
                      <td><?php echo $row["repair_s"] ?> </td>
                      <td><?php echo $row["pre_vac"] ?> </td>
                      <td><?php echo $row["dt"] ?></td>
                      <td><?php echo $row["stat"] ?></td>
                      <td><?php echo $row["submitter"] ?></td>
                      <td><a href="dr_update.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" role="button" name="edit"><i class="fas fa-eye"></i></a></td>
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
       
                



   
    
    
    



