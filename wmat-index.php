<?php include "includes/header.php";

    $_SESSION['report_type'] = 6;

    $status = "";
    $color = "";

    $sql = "SELECT COUNT(*) AS open FROM wmat WHERE stat = 'OPEN' AND isDeleted = 0";
    $result = $connection->query($sql);
    $o = get_data_array($result);
    $sql = "SELECT COUNT(*) AS closed FROM wmat WHERE stat = 'CLOSED' AND isDeleted = 0";
    $result = $connection->query($sql);
    $c = get_data_array($result);
    
    $hit_rate = $c['closed'] / ($c['closed'] + $o['open']);
    $ht_total = round($hit_rate * 100). "%";

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

<div class="card text-center" style="margin-top:50px;">
  <div class="card-header">
    CLOSURE RATE
  </div>
  <div class="card-body" style="margin:auto;">
    <div class="container" style="border:solid;">
        <table class="table-bordered ">
             
                <tr>
                    <td style="font-size:20px;"><b>OPEN</b></td>
                    <td style="font-size:20px;"><b>CLOSED</b></td>
                    <td style="font-size:20px;"><b>HIT RATE</b></td>
                    
                </tr>
                <tr>
                    <td><?php echo $o['open']; ?></td>
                    <td><?php echo $c['closed']; ?></td>
                    <td><?php echo $ht_total ?></td>
                </tr>
        </table>
        
    </div>
  </div>
</div>
            
<div class="card" style="margin-left:10px; margin-right:10px; margin-top:10px;">
    <div class="card-header" style="font-size:15px;">EQUIPMENT ENGINEERING WEEKLY MEETING
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
    </div>
    
    <div class="card-body">
           
                    <table class="record table-bordered table-hover" width="100%" cellspacing="0"  style="font-size:10px;">
                      <thead>
                            <tr>
                                <th width="40">ENTRY DATE</th>
                                <th width="45">DAYS OPEN</th>
                                <th width="300">DESCRIPTION OF ACTION ITEM</th>
                                <th width="55">RESPONSIBLE</th>
                                <th width="60">COMMIT CLOSURE DATE</th>
                                <th width="60">ACTUAL DATE CLOSURE</th>
                                <th width="30">STATUS</th>
                                <th width="150">REMARKS</th>
                                <th width="50">DURATION</th>
                                <th width="55">SUBMITTER</th>
                                <th width="40">DATE UPDATED</th>      
                                <th width="30">VIEW</th>
                            </tr>
                     </thead>
                    <tbody>

                        
     
            <?php if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
                    
                $showallrec_query ="SELECT * FROM wmat WHERE isDeleted = 0 ORDER BY entry_date DESC";
                $result = mysqli_query($connection, $showallrec_query);
            }
            
            else{
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $newquery ="SELECT * FROM wmat WHERE (DATE(entry_date) BETWEEN('$startDate' and '$endDate')) AND isDeleted = 0 order by entry_date DESC";
                $result = mysqli_query($connection, $newquery);  
            }
                         
                 while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                        <td><?php echo $row["entry_date"]?></td>
                        <?php
                        if ($row['stat'] == "OPEN"){

                        $now = time(); 
                        $your_date = strtotime($row["entry_date"]);
                        $datediff = $now - $your_date;

                        ?><td><?php echo round($datediff / (60 * 60 * 24))?></td><?php  

                        }
                        else if ($row['stat'] == "CLOSED"){
                            
                          $now = strtotime($row["act_date"]); 
                          $your_date = strtotime($row["entry_date"]);
                          $datediff = $now - $your_date;

                          ?><td><?php echo round($datediff / (60 * 60 * 24))?></td><?php 
                        }
                        ?>
                        <td><?php echo $row["desc_act_item"]?> </td>
                        <?php
                            $query = "SELECT * FROM employeeinfos WHERE cidNum= ". $row["responsible"];
                            $con = $userconnect->query($query);
                            $res = get_data_array($con);
                            $res_name = $res["firstName"];
                            echo "<td>". $res_name ."</td>";  
                        ?>
                        <td><?php echo $row["commit_closure"]?> </td>
                        <td><?php echo $row["act_date"]?> </td>
                        
                        <?php
                        if ($row['stat'] == "OPEN"){
                            
                            $color = "#ff2626";
                        }
                        else if ($row['stat'] == "CLOSED"){
                            
                            $color = "#71f442";
                        }
                        
                        echo "<td style='background-color:". $color ."'>". $row['stat'] ."</td>";
                        ?>
                        <td><?php echo $row["rem"]?></td> 
                        <td><?php echo $row["duration"]?> </td>
                        <td><?php echo $row["submitter"]?> </td>
                        <td><?php echo $row["update_date"]?></td>
                        <td> <a href="dr_update.php?id=<?php echo $row['id'];?>" target="_blank" class="btn btn-info btn-sm" role="button" name="edit"><i class="fas fa-eye"></i></a></td>
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
       
                



   
    
    
    



