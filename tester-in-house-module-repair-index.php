<?php include "includes/header.php";

    $_SESSION['report_type'] = 14;
    
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
  <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-chart-area"></i>
        DATA CHART</div>
      <div class="card-body">
      
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Platform</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><canvas id="ChartPlatformTesterInhouseModule" width="100%" height="30" style="margin-top:20px;"></canvas></div>
      </div>
        
      </div>
  </div>
 <div class="card" style="margin-left:10px; margin-right:10px;">
    <div class="card-header" style="font-size:15px;">TESTER IN HOUSE MODULE REPORTS
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
    </div>
      <div class="card-body">
        <table class="record table-bordered table-hover">
            <thead>
                <tr>
                  <th>WW</th>
                  <th>DATE</th>
                  <th>TESTER</th>
                  <th>PLATFORM</th>
                  <th>PART NAME</th>
                  <th>PART NUMBER</th>
                  <th>SERIAL NUMBER</th>
                  <th>PROBLEM</th>
                  <th>ACTION DONE</th>
                  <th>DIAG DATA LOGS</th>
                  <th>LOCATION</th>
                  <th>STATUS</th>
                  <th>WHO</th>
                  <th>VIEW</th>
                </tr>
            </thead>
          <tbody>

          <?php

          if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
                  
              $showallrec_query ="SELECT * from tester_in_house_module_reports WHERE isDeleted = 0 ORDER BY date DESC";
              $result = mysqli_query($connection, $showallrec_query);
          }
              
          else{
              $startDate = $_POST['startDate'];
              $endDate = $_POST['endDate'];
              $newquery ="SELECT * FROM tester_in_house_module_reports WHERE DATE(date) BETWEEN '$startDate' and '$endDate' order by date DESC";
              $result = mysqli_query($connection, $newquery);  
          }

                          
          while ($row = mysqli_fetch_array($result)){
                  $ddate = $row["date"];
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
                <td><?php echo $row["date"] ?></td>
                <td><?php echo $row["tester"] ?> </td>
                <td><?php echo $row["platform"] ?> </td>
                <td><?php echo $row["part_name"] ?> </td>
                <td><?php echo $row["part_number"] ?> </td>
                <td><?php echo $row["serial_number"] ?> </td>
                <td><?php echo $row["problem"] ?> </td>
                <td><?php echo $row["action_d"] ?> </td>
                <td><?php echo $row["diag_data_logs"] ?></td>
                <td><?php echo $row["location"] ?></td>
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
       
                



   
    
    
    



