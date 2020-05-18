<?php include "includes/header.php";

    $_SESSION['report_type'] = 8;

    $status = "";
    $color = "";


?>
<form method="post">

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

            
<div class="card" style="margin-left:10px; margin-right:10px; margin-top:60px;">
    <div class="card-header" style="font-size:15px;">EQUIPMENT ENGINEERING REPORTING
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right; font-size:10px;">FILTER RECORD</button>
    </div>
    
    <div class="card-body">
           
            <table class="record table-bordered table-hover" width="100%" cellspacing="0"  style="font-size:10px;">
                      <thead>
                            <tr>
                                <th width="40">ENTRY DATE</th>
                                <th width="300">ACTIVTIES DONE</th>
                                <th width="30">STATUS</th>
                                <th width="150">SUBMITTER</th>
                                <th width="50">UPDATER</th>
                                <th width="55">UPDATE DATE</th>
                            
                                <th width="30">VIEW</th>
                            </tr>
                     </thead>
                    <tbody>

                        
     
            <?php if (empty($_POST['startDate'])  && empty($_POST['endDate'])){     
                    
                $showallrec_query ="SELECT * FROM ee_reports WHERE isDeleted = 0 ORDER BY submit_date DESC";
                $result = mysqli_query($connection, $showallrec_query);
            }
            
            else{
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];

                $newquery ="SELECT * FROM ee_reports WHERE (DATE(submit_date) BETWEEN('$startDate' and '$endDate')) AND isDeleted = 0 order by submit_date DESC";
                $result = mysqli_query($connection, $newquery);  
            }
                         
                 while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                        <td><?php echo $row["submit_date"]?></td>
                        <td><?php echo $row["activity_done"]?></td>
                        <td><?php echo $row["stat"]?> </td>
                        <td><?php echo $row["sub_ffId"]?> </td>
                        <td><?php echo $row["updater"]?> </td>
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
       
                



   
    
    
    



