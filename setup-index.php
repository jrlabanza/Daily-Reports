<?php include "includes/header.php";

    $_SESSION['report_type'] = 17;
    
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
  <div class="container">
    <div class="card mb-3" >
        <div class="card-header">
          <i class="fas fa-chart-area"></i>
          LEGEND</div>
        <div class="card-body">
        <div class="row">
          <div class="col">
          <table class="table-bordered table-hover"  style="font-size:14px">
            <tr>
              <th colspan="2" rowspan="2">SouthWing</th>
              <th colspan="2" >IE Time</th>
              <tr>
                <th>Mins</th>
                <th>Hrs</th>
              </tr>
            </tr>
            <tr style='background-color:yellow'>
              <td>S1</td>
              <td>P = Change Program</td>
              <td>11.71</td>
              <td>0.20</td>
            </tr>
            <tr style='background-color:#8fbaff'>
              <td>S5</td>
              <td>CK = Change Kit</td>
              <td>113.44</td>
              <td>1.89</td>
            </tr>
            <tr style='background-color:#8fff9c'>
              <td>S2 & S4</td>
              <td>LB = Change LB</td>
              <td>35.06</td>
              <td>0.58</td>
            </tr>
            <tr style='background-color:#ff8f8f'>
              <td>S7 & S8</td>
              <td>HT = Handler Transfer</td>
              <td>274.12</td>
              <td>4.57</td>
            </tr>
            <tr style='background-color:#ffc98f'>
              <td>S6</td>
              <td>TT = Tester Transfer</td>
              <td>95.98</td>
              <td>1.60</td>
            </tr>
          </table>  
          </div>
          <div class="col">
          <table class="table-bordered table-hover"  style="font-size:14px">
            <tr>
              <th colspan="2" rowspan="2">NorthWing</th>
              <th colspan="2" >IE Time</th>
              <tr>
                <th>Mins</th>
                <th>Hrs</th>
              </tr>
            </tr>
            <tr style='background-color:yellow'>
              <td>S1</td>
              <td>P = Change Program</td>
              <td>18.08</td>
              <td>0.30</td>
            </tr>
            <tr style='background-color:#8fbaff'>
              <td>S5</td>
              <td>CK = Change Kit</td>
              <td>222.97</td>
              <td>3.72</td>
            </tr>
            <tr style='background-color:#8fff9c'>
              <td>S2 & S4</td>
              <td>LB = Change LB</td>
              <td>58.18</td>
              <td>0.97</td>
            </tr>
            <tr style='background-color:#ff8f8f'>
              <td>S7 & S8</td>
              <td>HT = Handler Transfer</td>
              <td>294.68</td>
              <td>4.91</td>
            </tr>
            <tr style='background-color:#ffc98f'>
              <td>S6</td>
              <td>TT = Tester Transfer</td>
              <td>95.88</td>
              <td>1.60</td>
            </tr>
          </table> 
          </div>
        </div>
        

        </div>
    </div>
  </div>    
 <div class="card" style="margin-left:10px; margin-right:10px;">
    <div class="card-header" style="font-size:15px;">SETUP REPORTS
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
       </div>
        <div class="card-body"> 
          
                 <table class="record table-bordered table-hover">
                      <thead>
                          <tr>
                            <th>WW</th>
                            <th>DATE</th>
                            <th>GROUP</th>
                            <th>HANDLER</th>
                            <th>TESTER</th>
                            <th>PACKAGE</th>
                            <th>FAMILY</th>
                            <th>SETUP</th>
                            <th>IE TIME</th>
                            <th>ACTUAL SETUP TIME</th>
                            <th>GAP</th>
                            <th>PROBLEM FULL DESCRIPTION</th>
                            <th>ANALYSIS</th>
                            <th>ACTION DONE</th>
                            <th>STATUS</th>
                            <th>CATEGORY</th>
                            <th>WHO</th>
                            <th>REMARKS</th>
                            <th>VIEW</th>
                          </tr>
                     </thead>
                    <tbody>

<?php
 ///////SHOW DATA FROM DATABASE////////////////////////////////////////////////////////////////////////
if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
         
    $showallrec_query ="SELECT * from setup_reports WHERE isDeleted = 0 ORDER BY dr_date DESC";
    $result = mysqli_query($connection, $showallrec_query);
}
     
else{
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $newquery ="SELECT * FROM setup_reports WHERE DATE(dr_date) BETWEEN '$startDate' and '$endDate' order by dr_date DESC";
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
                      <td><?php echo $row["groups"] ?></td>
                      <td><?php echo $row["handler"] ?></td>
                      <td><?php echo $row["tester"] ?> </td>
                      <td><?php echo $row["package"] ?> </td>
                      <td><?php echo $row["fam_name"] ?> </td>
                      <td><?php echo $row["setup_code"] ?> </td>
                      <td><?php echo $row["ie_time"] ?> </td>
                      <td><?php echo $row["actual_setup_time"] ?> </td>
                      <td><?php echo $row["gap"] ?> </td>
                      <td><?php echo $row["pfd"] ?></td> 
                      <td><?php echo $row["fwa"] ?> </td>
                      <td><?php echo $row["action_d"] ?> </td>
                      <td><?php echo $row["stat"] ?> </td>
                      <td><?php echo $row["category"] ?> </td>
                      <td><?php echo $row["submitter"] ?> </td>
                      <td><?php echo $row["remarks"] ?> </td>
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
       
                



   
    
    
    



