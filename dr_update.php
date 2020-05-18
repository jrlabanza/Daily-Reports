<?php
include "includes/header.php";
$readonly = "readonly";

$status = "";
$status_value = "";


if ($_SESSION['report_type'] == 1){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentData($dr_id);
    deleteLB($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from dailyreports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM lb_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/load_board/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [LOAD BOARD]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['dr_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Handler</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB ID</label>
                <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['LB_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB Name</label>
                <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['lb_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">Problem Full Description</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-6">
                <div class="form-group">
                    <label for="repair_s">Repair Stage</label>
                    <select type="text" name="repair_s" class="form-control" required="yes"<?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                        <option value="<?php echo $d['repair_s']?>"><?php echo $d['repair_s']?></option>
                        <option value="VISUAL INSPECTION">VISUAL INSPECTION</option>
                        <option value="CONTINUITY CHECK">CONTINUITY CHECK</option>
                        <option value="COMPONENT TESTING">"COMPONENT TESTING</option>
                        <option value="SIGNAL TRACING">SIGNAL TRACING</option>
                        <option value="PRODUCT DEBUG">PRODUCT DEBUG</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 2){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentData_SL($dr_id);
    deleteSL($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from speedloss WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM sl_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/speedloss/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [SPEEDLOSS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
           <div class="row">
           <div class="col-3">
            <div class="form-group">
            <label for="tester">DATE / TIME</label>
            <input type="text" name="date" class="form-control form-control-sm" autocomplete="off" readonly value="<?php echo $d['sl_date'] ?>">
            </div>
            </div>    
           <div class="col-3">
            <div class="form-group">
            <label for="tester">TESTER ID</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester_id'] ?>" readonly>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">TESTER PF</label>
                <input type="text" name="tester_pf" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester_pf'] ?>" readonly >
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">HANDLER</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler'] ?>" readonly >
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">HANDLER PF</label>
                <input type="text" name="handler_pf" class="form-control form-control-sm" autocomplete="off" required="yes" value="<?php echo $d['handler_pf'] ?>" readonly > 
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="lb_name">DEVICE</label>
                <input type="text" name="device" class="form-control form-control-sm" autocomplete="off" required="yes" value="<?php echo $d['device'] ?>"  readonly>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="pfd">STATUS</label>
                <input type="text" name="sl_status_owner" class="form-control form-control-sm" autocomplete="off"  required="yes" value="<?php echo $d['sl_status_owner'] ?>" readonly >
            </div>
            </div>
            
            <div class="col-3">
            <div class="form-group">
                <label for="fwa">STATUS OWNER</label>
                <input type="text" name="status_owner" class="form-control form-control-sm" required="yes" value="<?php echo $d['status_owner'] ?>" readonly >
            </div>
            </div>
            </div>
            <div class="row">
            
            <div class="col-4">
            <div class="form-group">
                <label for="action_d">DURATION (HRS.MIN)</label>
                <input type="text" name="duration" class="form-control form-control-sm" required="yes" value="<?php echo $d['duration'] ?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; } ?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="action_d">WHO [REQUEST]</label>
                <input type="text" name="who_1" class="form-control form-control-sm" required="yes" value="<?php echo $d['who_1'] ?>" readonly >
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="action_d">WHO [UPDATE]</label>
                <input type="text" name="who_2" class="form-control form-control-sm" required="yes" value="<?php echo $d['who_2'] ?>" readonly >
            </div>
            </div>
            </div>
            
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="pre_vac">PROBLEM</label>
                <textarea type="text" name="problem" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes" readonly ><?php echo $d['problem'] ?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="dt">ACTION DONE</label>
                <textarea type="text" name="act_done" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; } ?>><?php echo $d['act_done'] ?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">COMMIT</label>
                <input type="text" name="sl_commit" class="form-control form-control-sm" autocomplete="off" required="yes" value="<?php echo $d['sl_commit'] ?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; } ?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">STATUS</label>
                <input type="text" name="sl_status" class="form-control form-control-sm" autocomplete="off" required="yes" value="<?php echo $d['sl_status'] ?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; } ?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">SUBMITTER</label>
                <input type="text" name="who_2" class="form-control form-control-sm" autocomplete="off" required="yes" value="<?php echo $d['submitter'] ?>" readonly>
            </div>
            </div>
            </div>
           <div class="row">
             <div class="col-12">
            <div class="form-group">
                <label for="stat">REMARKS</label>
                <textarea type="text" name="remarks" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; } ?>><?php echo $d['sl_remarks'] ?></textarea>
            </div>
           </div>  
               
           </div>


            <?php if (isset($_SESSION['rs_username']) && ($_SESSION['userPriv'] == 2 || $_SESSION['userPriv'] == 1)) { ?>
            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                       <?php } ?>
            <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>       
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE
                            </button>
                            <?php } ?>

    </form>
    </div>
        </div>
    </div>

<?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 3){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentBib($dr_id);
    deleteBib($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from burnin_report WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM bib_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/burn_in/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [BURN IN BOARD]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['br_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">BURN IN OVEN #</label>
            <input type="text" name="burn_in_no" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['burn_in_no']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">FAMILY NAME</label>
                <input type="text" name="family_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['family_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">BURN IN BOARD ID</label>
                <input type="text" name="bib_id" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['bib_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">BURN IN BOARD NAME</label>
                <input type="text" name="bib_name" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['bib_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">PROBLEM FULL DESCRIPTION</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="act_done" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['act_done']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-3">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="qty">Quantity Replaced</label>
                <input type="text" name="qty" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['qty_replaced']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="br_status" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['br_status']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="who" class="form-control" autocomplete="off" value="<?php echo $d['who']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 4){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentExt($dr_id);
    deleteExt($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from ext_report WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM ext_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/external_rep/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [EXTERNAL]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">DATE</label>
            <input type="text" value="<?php echo $d['ex_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">ITEM DESCRIPTION</label>
            <input type="text" name="item_desc" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['item_desc']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">SERIAL ID</label>
                <input type="text" name="serial_id" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['serial_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">REQUESTING PERSONNEL</label>
                <input type="text" name="req_per" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['req_per']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">REQUESTING DEPARTMENT</label>
                <input type="text" name="req_dept" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['req_dept']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">PROBLEM FULL DESCRIPTION</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 WHY ANALYSIS</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">ACTION DONE</label>
                <textarea type="text" name="act_done" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['act_done']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">PREVENTIVE ACTION</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">DATE AND TIME RECEIVED</label>
                <input type="text" name="dtr" class="form-control form-control-sm demo" autocomplete="off" value="<?php echo $d['dtr']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">DATE AND TIME ENDORSED</label>
                <input type="text" name="dte" class="form-control form-control-sm demo" autocomplete="off" value="<?php echo $d['dte']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">DOWNTIME</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">STATUS</label>
                <input type="text" name="ex_status" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['ex_status']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">SUBMITTER</label>
              <input type="text" name="who" class="form-control" autocomplete="off" value="<?php echo $d['who']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if ($_SESSION['report_type'] == 5){
        //gets current id//////////////////////
        if (is_numeric($_GET['id'])){
            $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        }
        updateCurrentData_LBPM($dr_id);
        deleteLBPM($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from lbpm_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM lbpm_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/lbpm_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [LOAD BOARD PREVENTIVE MAINTENANCE] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>
        <div class="card-body">
        <div class="container">
            
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Handler</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">Load Board ID</label>
                <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['LB_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="lb_name">Load Board Name</label>
                <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['lb_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            </div>
            
            
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">PM Findings</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-2">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-2">
            <div class="form-group">
                <label for="stat">Status</label>
                <?php 
                    if ($d["stat"] == 0){
    
                            $status = "DONE PM/FOR FUNCTION TEST";
                            
                        }
                        else if ($d["stat"] == 1){

                            $status = "PASSED";
                        }
                        else if ($d["stat"] == 2){

                            $status = "FAILED";
                            
                        }
                    
                    ?>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $status; ?>" readonly >
                
            </div>
           </div>
           <div class="col-2">
            <div class="form-group">
                <label for="pm_date">PM DATE</label>
                <input type="text" name="pm_date" class="form-control form-control-sm searchdate" autocomplete="off" value="<?php echo $d['pm_date']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-2">
            <div class="form-group">
                <label for="pm_due">PM DUE</label>
                <input type="text" name="pm_due" class="form-control form-control-sm searchdate" autocomplete="off" value="<?php echo $d['pm_due']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
        <div class="row">
            <div class="col-6">
             <label for="ftf">Function Test Finding</label>
             <textarea type="text" class="form-control" name="ftf" rows="5" value="" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['ftf']?></textarea>  
            </div>
            <div class="col-6">
             <label for="ftf">Problem Description</label>
             <textarea type="text" class="form-control" name="prob_des" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['prob_des']?></textarea>  
            </div>     
        </div>
        <div class="row">
            <div class="col-6">
             <label for="ftf">Action Done</label>
             <textarea type="text" class="form-control" name="ad" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['ad']?></textarea> 
            </div>
            <div class="col-6">
             <label for="ftf">Root Cause</label>
             <textarea type="text" class="form-control" name="rc" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['rc']?></textarea>  
            </div>     
        </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" readonly>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <div class="row">
                   <div class="card ml-3">
                        <div class="card-header">NEW ACTION</div>
                        <div class="card-body">
                            <input class="btn btn-primary btn-sm" type="submit" name="submit_p" value="Passed">
                            <input class="btn btn-danger btn-sm mr-1" type="submit" name="submit_f" value="Failed">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        </div>
                    </div>
                </div>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 6){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentWMAT($dr_id);
    deleteWMAT($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from wmat WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM wmat_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);

    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all);

    $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
    $show_result = $userconnect->query($show_name);
    $sho = get_assocArray($show_result);
    $show_name = $sho['firstName'];
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/wmat_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_wmat" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [WEEKLY MEETING ACTION TRACKER] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>

        <div class="card-body">
        <div class="container">

            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">ENTRY DATE</label>
            <input type="text" value="<?php echo $d['entry_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>

            <div class="col-6">
            <div class="form-group">
                <label for="desc_act_item">DESCRIPTION OF ACTION ITEM</label>
                <textarea type="text" name="desc_act_item" class="form-control form-control-sm" autocomplete="off" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['desc_act_item']?></textarea>
            </div>
           </div>
           
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="responsible">RESPONSIBLE</label>
                <select list="listall"type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">     
                        <datalist id="listall">
                        <option value="<?php echo $d['responsible']?>" <?php if (empty($_SESSION['userPriv'])) { echo 'readonly'; } ?> > <?php echo $d['responsible']?> </option>
                        <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                        </datalist>
                    </select>
            </div>
            </div>
           <div class="col-3">
            <div class="form-group">
                <label for="commit_closure">COMMIT CLOSURE DATE</label>
                <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off"  value="<?php echo $d['commit_closure']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="act_date">ACTUAL CLOSURE DATE</label>
                <input type="text" name="act_date" class="form-control form-control-sm searchdate" autocomplete="off" value="<?php echo $d['act_date']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="stat">STATUS</label>
                <select type="text" name="stat" class="form-control form-control-sm" value="<?php echo $d['stat']?>" autocomplete="off" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
                <?php   if ($d['stat'] == "OPEN"){
                            $status = "OPEN";
                            
                        }
                        else if ($d['stat'] == "CLOSED"){
                            $status = "CLOSED";
                            
                        } 
                echo "<option value='". $d['stat'] . "'>". $status . "</option>";
                    ?>
                <option value="" disabled>--------------</option>
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>
                </select>
            </div>
            </div>
            </div>
            
            
            <div class="row">
            
            <div class="col-8">
            <div class="form-group">
                <label for="rem">REMARKS</label>
                <textarea type="text" name="rem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['rem']?></textarea>
            </div>
            </div>
            <div class="col-4">
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="duration">DURATION</label>
                <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['duration']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="dt">SUBMITTER</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['submitter']?>" readonly>
            </div>
            </div>
            </div>
            
            </div>
            </div>
        
        
           
                <?php if (isset($_SESSION['rs_username'])) { ?>
                
                   
                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        
                
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 7){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentData_LBIM($dr_id);
    deleteLBIM($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from lbim WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM lbim_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/lbim_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [LOAD BOARD ISSUE MONITORING]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['dr_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Handler</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB ID</label>
                <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['LB_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB Name</label>
                <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['lb_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">Problem Full Description</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 8){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentER($dr_id);
    deleteER($dr_id);

    $sql ="SELECT * from ee_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);


    $selectitem = "SELECT * FROM er_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);

    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all);

    $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
    $show_result = $userconnect->query($show_name);
    $sho = get_assocArray($show_result);
    $show_name = $sho['firstName'];
    ?>
    

            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/er_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";

                    }

                      ?>
                  </div>

                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
      
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">


                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>


                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>


                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_er" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [EE REPORTS] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>

        <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="desc_act_item">ACTIVITY DONE</label>
                        <textarea type="text" name="activity_done" class="form-control form-control-sm" autocomplete="off" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['activity_done']?></textarea>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-3"> 
                        <div class="form-group">
                            <label for="dr_date">SUBMIT DATE</label>
                            <input type="text" value="<?php echo $d['submit_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
                        </div>
                    </div>


                    <div class="col-3">
                        <div class="form-group">
                            <label for="stat">STATUS</label>
                            <select type="text" name="stat" class="form-control form-control-sm" value="<?php echo $d['stat']?>" autocomplete="off" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
                            <?php   if ($d['stat'] == "OPEN"){
                                        $status = "OPEN";
                                        
                                    }
                                    else if ($d['stat'] == "CLOSED"){
                                        $status = "CLOSED";
                                        
                                    } 
                            echo "<option value='". $d['stat'] . "'>". $status . "</option>";
                                ?>
                            <option value="" disabled>--------------</option>
                            <option value="OPEN">OPEN</option>
                            <option value="CLOSED">CLOSED</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="dt">SUBMITTER</label>
                            <input type="text" name="" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['sub_ffId']?>" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="dt">RECENT UPDATER</label>
                            <input type="text" name="" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['updater']?>" readonly>
                        </div>
                    </div>
                </div>
            
   
        
        
           
                <?php if (isset($_SESSION['rs_username'])) { ?>
                
                   
                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        
                
                    <?php } ?>
                    </div>
            </form>
            </div>
        </div>
    </div>

<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 9){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentDMAT($dr_id);
    deleteDMAT($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from dmat WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM dmat_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);

    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all);

    $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
    $show_result = $userconnect->query($show_name);
    $sho = get_assocArray($show_result);
    $show_name = $sho['firstName'];
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/dmat_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_dmat" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [DAILY MEETING ACTION TRACKER] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>

        <div class="card-body">
        <div class="container">

            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">ENTRY DATE</label>
            <input type="text" value="<?php echo $d['entry_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>

            <div class="col-6">
            <div class="form-group">
                <label for="desc_act_item">DESCRIPTION OF ACTION ITEM</label>
                <textarea type="text" name="desc_act_item" class="form-control form-control-sm" autocomplete="off" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['desc_act_item']?></textarea>
            </div>
           </div>
           
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="responsible">RESPONSIBLE</label>
                <select list="listall"type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">     
                        <datalist id="listall">
                        <option value="<?php echo $d['responsible']?>" <?php if (empty($_SESSION['userPriv'])) { echo 'readonly'; } ?> > <?php echo $d['responsible']?> </option>
                        <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                        </datalist>
                    </select>
            </div>
            </div>
           <div class="col-3">
            <div class="form-group">
                <label for="commit_closure">COMMIT CLOSURE DATE</label>
                <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off"  value="<?php echo $d['commit_closure']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="act_date">ACTUAL CLOSURE DATE</label>
                <input type="text" name="act_date" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['act_date']?>" readonly>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="stat">STATUS</label>
                <select type="text" name="stat" class="form-control form-control-sm" value="<?php echo $d['stat']?>" autocomplete="off" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>

                <?php echo "<option value='". $d['stat'] . "'>". $d['stat'] . "</option>";
                    ?>
                <option value="" disabled>--------------</option>
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>
                </select>
            </div>
            </div>
            </div>
            
            
            <div class="row">
            
            <div class="col-8">
            <div class="form-group">
                <label for="rem">REMARKS</label>
                <textarea type="text" name="rem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['rem']?></textarea>
            </div>
            </div>
            <div class="col-4">
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="duration">DURATION</label>
                <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['duration']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="dt">SUBMITTER</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['submitter']?>" readonly>
            </div>
            </div>
            </div>
            
            </div>
            </div>
        
        
           
                <?php if (isset($_SESSION['rs_username'])) { ?>
                
                   
                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        
                
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 10){
  //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
  updateM3($dr_id);
  // deleteDMAT($dr_id);
  ///////////////////////////////////////


  //get data infromation from id/////////
  $sql ="SELECT * from m3_reports WHERE id=".$dr_id;
  $result = $connection-> query($sql);
  $d = get_data_array($result);
  ///////////////////////////////////////

  $selectitem = "SELECT * FROM m3_uploads WHERE itemId=". $dr_id ; 
  $itemresult = $connection->query($selectitem);
  $item = get_assocArray($itemresult);
  $totalitem = sizeof($item);

  $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
  $fullresult = $userconnect-> query($showall_query);
  $all = get_assocArray($fullresult);
  $empsLen = sizeof($all);

  if (isset($_SESSION['rs_username']) && $_SESSION['rs_username'] == $d['sub_ffId'])
  {
    $readonly =  ''; $readonly_radio = '';    
  }
  else
  {
    $readonly =  'readonly'; $readonly_radio = 'disabled';    
  }
  // $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
  // $show_result = $userconnect->query($show_name);
  // $sho = get_assocArray($show_result);
  // $show_name = $sho['firstName'];
  ?>
  

  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Uploaded Files</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p><?php
          

          for ($i=0 ; $i < $totalitem ; $i++)
          {    
            echo "<div> <a href='uploads/m3_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
          }?>

        </div>
        <div class="modal-footer">
          <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
     
  <div class="modal fade" id="delModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"><p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p></div>
        <div class="modal-footer">
          <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
          <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
            <input type="submit" class="btn btn-danger" style="float:left;" name="del_dmat" value="Confirm Deletion">
          </form>
        </div>
      </div>
    </div>
  </div>
 
  <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
        <!-- <div class="card-header">UPDATE [DAILY MEETING ACTION TRACKER] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple >
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">SHOW UPLOADED DOCUMENTS</button></div>
        </div> -->
        <div class="card-header">UPDATE [ONLINE SETUP REQUEST] <div style="float:right;">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">SHOW UPLOADED DOCUMENTS</button></div>
        </div>

        <div class="card-body" style="background:#c4c4c4;">
          <div class="row">
            <div class="col-6">
                <div class="card mb-3">
                    <div class="card-header" style='background:yellow'> CURRENT SETUP</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div>Handler #</div>
                            </div>
                            <div class="col-4">
                                <div>Handler Platform</div>
                            </div>
                            <div class="col-4">
                                <div>Tester #</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='handler-cs' value='<?php echo $d['handler_CS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='handler-platform-cs' value='<?php echo $d['handler_platform_CS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='tester-cs' value='<?php echo $d['tester_CS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Tester Platform</div>
                            </div>
                            <div class="col-4">
                                <div>Family Name</div>
                            </div>
                            <div class="col-4">
                                <div>Loadboard Name</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='tester-platform-cs' value='<?php echo $d['tester_platform_CS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='family-name-cs' value='<?php echo $d['family_CS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='loadboard-name-cs' value='<?php echo $d['lb_name_CS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Load Board ID</div>
                            </div>
                            <div class="col-4">
                                <div>Package</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='loadboard-id-cs' value='<?php echo $d['lb_ID_CS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" class='form-control form-control-sm' name='package-cs' value='<?php echo $d['package_CS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header" style='background:#ffb963'> TYPE OF SETUP </div>
                    <div class="card-body">
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>YES</th>
                                    <th>NO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Program</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-program-ts" value='YES' <?php if ($d['change_program_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-program-ts" value='NO' <?php if ($d['change_program_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Center Board</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-center-board-ts" value='YES' <?php if ($d['change_center_board_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-center-board-ts" value='NO' <?php if ($d['change_center_board_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Load Board</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-load-board-ts" value='YES' <?php if ($d['change_load_board_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-load-board-ts" value='NO' <?php if ($d['change_load_board_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Package</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-package-ts" value='YES' <?php if ($d['change_package_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-package-ts" value='NO' <?php if ($d['change_package_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Kit</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-kit-ts" value='YES' <?php if ($d['change_kit_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-kit-ts" value='NO' <?php if ($d['change_kit_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Tester Transfer</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="tester-transfer-ts" value='YES' <?php if ($d['tester_transfer_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="tester-transfer-ts" value='NO' <?php if ($d['tester_transfer_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Handler Tester</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="handler-tester-ts" value='YES' <?php if ($d['handler_tester_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="handler-tester-ts" value='NO' <?php if ($d['handler_tester_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Handler</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-handler-ts" value='YES' <?php if ($d['change_handler_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-handler-ts" value='NO' <?php if ($d['change_handler_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Tester</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-tester-ts" value='YES' <?php if ($d['change_tester_TS'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-tester-ts" value='NO' <?php if ($d['change_tester_TS'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header" style='background:#ffb963'> CHANGE STATUS *Changes are inputted here</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div>Remarks</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <textarea name="submitter-remarks" rows='5' style='width:100%'></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div>STATUS</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <select class='form-control form-control-sm' name="status" value='<?php echo $d['status']; ?>' required>
                                    <option value=""></option>
                                    <option value="FOR PREPARATION">FOR PREPARATION</option>
                                    <option value="ON GOING PREPARATION">ON GOING PREPARATION</option>
                                    <!-- <option value="FOR PICK UP FROM CENTRAL SHOP">FOR PICK UP FROM CENTRAL SHOP</option> -->
                                    <option value="READY FOR BUY OFF">READY FOR BUY OFF</option>
                                    <!-- <option value="READY FOR PICK UP">READY FOR PICK UP</option> -->
                                    <option value="RELEASED">RELEASED</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-3">
                    <div class="card-header" style='background:#2bff47'> PROPOSE SETUP </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div>Handler #</div>
                            </div>
                            <div class="col-4">
                                <div>Handler Platform</div>
                            </div>
                            <div class="col-4">
                                <div>Tester #</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='handler-PS' class='form-control form-control-sm' value='<?php echo $d['handler_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='handler-platform-PS' class='form-control form-control-sm' value='<?php echo $d['handler_platform_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='tester-PS' class='form-control form-control-sm' value='<?php echo $d['tester_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Tester Platform</div>
                            </div>
                            <div class="col-4">
                                <div>Family Name</div>
                            </div>
                            <div class="col-4">
                                <div>Load Board Name</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='tester-platform-PS' class='form-control form-control-sm' value='<?php echo $d['tester_platform_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='family-name-PS' class='form-control form-control-sm' value='<?php echo $d['family_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='loadboard-name-PS' class='form-control form-control-sm' value='<?php echo $d['lb_name_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Load Board ID</div>
                            </div>
                            <div class="col-4">
                                <div>Package</div>
                            </div>
                            <div class="col-4">
                                <div>EDTM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='loadboard-ID-PS' class='form-control form-control-sm' value='<?php echo $d['lb_ID_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='package-PS' class='form-control form-control-sm' value='<?php echo $d['package_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='edtm-PS' class='form-control form-control-sm' value='<?php echo $d['EDTM_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Requested By</div>
                            </div>
                            <div class="col-4">
                                <div>Group</div>
                            </div>
                            <div class="col-4">
                                <div>Shift</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='requested-by-PS' class='form-control form-control-sm' value='<?php echo $d['requested_by_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='group-PS' class='form-control form-control-sm' value='<?php echo $d['group_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='shift-PS' class='form-control form-control-sm' value='<?php echo $d['shift_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Requested Date</div>
                            </div>
                            <div class="col-4">
                                <div>Expected Date of Setup</div>
                            </div>
                            <div class="col-4">
                                <div>Unscheduled Set-up</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='requested-date-PS' class='form-control form-control-sm m3_date' value='<?php echo $d['requested_date_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='expected-date-of-setup-PS' class='form-control form-control-sm m3_date' value='<?php echo $d['expected_date_of_setup_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='unscheduled-setup-PS' class='form-control form-control-sm' value='<?php echo $d['unscheduled_setup_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div>Reason for Unscheduled set up</div>
                            </div>
                            <div class="col-4">
                                <div>LSG Approver</div>
                            </div>
                            <div class="col-4">
                                <div>Remakrs</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name='reason-for-unscheduled-setup-PS' class='form-control form-control-sm' value='<?php echo $d['reason_for_unscheduled_setup_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='lsg-approver-PS' class='form-control form-control-sm' value='<?php echo $d['lsg_approver_PS'];?>' <?php echo $readonly ?>>
                            </div>
                            <div class="col-4">
                                <input type="text" name='remarks-PS' class='form-control form-control-sm' value='<?php echo $d['remarks_PS'];?>' <?php echo $readonly ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header" style='background:#2aede6'> SETUP MATERIAL </div>
                    <div class="card-body">
                    <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>YES</th>
                                    <th>NO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Change Kit</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-kit-sm" value='YES' <?php if ($d['change_kit_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="change-kit-sm" value='NO' <?php if ($d['change_kit_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Separator Plate</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="separator-plate-sm" value='YES' <?php if ($d['separator_plate_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="separator-plate-sm" value='NO' <?php if ($d['separator_plate_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Unloader Kit</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="unloader-kit-sm" value='YES' <?php if ($d['unloader_kit_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="unloader-kit-sm" value='NO' <?php if ($d['unloader_kit_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Work Press</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="work-press-sm" value='YES' <?php if ($d['work_press_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="work-press-sm" value='NO' <?php if ($d['work_press_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Baseplate</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="baseplate-sm" value='YES' <?php if ($d['baseplate_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="baseplate-sm" value='NO' <?php if ($d['baseplate_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Socket Jig</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="socket-jig-sm" value='YES' <?php if ($d['socket_jig_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="socket-jig-sm" value='NO' <?php if ($d['socket_jig_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Power Supply</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="power-supply-sm" value='YES' <?php if ($d['power_supply_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="power-supply-sm" value='NO' <?php if ($d['power_supply_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Oscilloscope</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="oscilloscope-sm" value='YES' <?php if ($d['oscilloscope_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="oscilloscope-sm" value='NO' <?php if ($d['oscilloscope_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Socket</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="socket-sm" value='YES' <?php if ($d['socket_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="socket-sm" value='NO' <?php if ($d['socket_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='radiotext'>Others</span> 
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="others-sm" value='YES' <?php if ($d['others_SM'] == 'YES'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="others-sm" value='NO' <?php if ($d['others_SM'] == 'NO'){ echo "checked"; }?> <?php echo $readonly_radio ?>></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header" style='background:#2bff47'> Current Remarks and Updaters </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>FOR PREPARATION Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['for_preparation_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['for_preparation_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['for_preparation_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>ON GOING PREPARATION Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['ongoing_preparation_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ongoing_preparation_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ongoing_preparation_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>For Pickup CSHOP Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['for_pickup_cshop_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['for_pickup_cshop_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['for_pickup_cshop_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>Ready for Buyoff Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['ready_for_buyoff_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ready_for_buyoff_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ready_for_buyoff_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>Ready For Pickup Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['ready_for_pickup_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ready_for_pickup_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['ready_for_pickup_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div>Released Remarks</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea  rows='5' style='width:100%' readonly><?php echo $d['released_remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Updater</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['released_updater']; ?>' readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>Date Updated</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <input class='form-control form-control-sm' type="text" value='<?php echo $d['released_date']; ?>' readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12"><input class="btn btn-primary"  type="submit" name="submit" value="UPDATE" style='float:right' <?php if(isset($_SESSION['rs_username']) == ""){ echo "hidden";}?>></div>
          </div>
        </div>
    </div>
  </form>
<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['report_type'] == 11){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentEMAT($dr_id);
    deleteEMAT($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from emat WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM emat_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);

    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all);

    $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
    $show_result = $userconnect->query($show_name);
    $sho = get_assocArray($show_result);
    $show_name = $sho['firstName'];
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/emat_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_emat" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [EQUIPMENT STAFF MEETING ACTION TRACKER] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>

        <div class="card-body">
        <div class="container">

            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">ENTRY DATE</label>
            <input type="text" value="<?php echo $d['entry_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>

            <div class="col-6">
            <div class="form-group">
                <label for="desc_act_item">DESCRIPTION OF ACTION ITEM</label>
                <textarea type="text" name="desc_act_item" class="form-control form-control-sm" autocomplete="off" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['desc_act_item']?></textarea>
            </div>
           </div>
           
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="responsible">RESPONSIBLE</label>
                <select list="listall"type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">     
                        <datalist id="listall">
                        <option value="<?php echo $d['responsible']?>" <?php if (empty($_SESSION['userPriv'])) { echo 'readonly'; } ?> > <?php echo $d['responsible']?> </option>
                        <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                        </datalist>
                    </select>
            </div>
            </div>
           <div class="col-3">
            <div class="form-group">
                <label for="commit_closure">COMMIT CLOSURE DATE</label>
                <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off"  value="<?php echo $d['commit_closure']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="act_date">ACTUAL CLOSURE DATE</label>
                <input type="text" name="act_date" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['act_date']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="stat">STATUS</label>
                <select type="text" name="stat" class="form-control form-control-sm" value="<?php echo $d['stat']?>" autocomplete="off" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>

                <?php echo "<option value='". $d['stat'] . "'>". $d['stat'] . "</option>";
                    ?>
                <option value="" disabled>--------------</option>
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>
                </select>
            </div>
            </div>
            </div>
            
            
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="rem">ACTION DONE</label>
                        <textarea type="text" name="action_done" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['action_done']?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="rem">REMARKS</label>
                        <textarea type="text" name="rem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['rem']?></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="duration">DURATION</label>
                                <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['duration']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="dt">SUBMITTER</label>
                                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['submitter']?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        
           
                <?php if (isset($_SESSION['rs_username'])) { ?>
                
                   
                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        
                
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
if ($_SESSION['report_type'] == 12){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateTRR($dr_id);
    deleteTRR($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from tester_repair_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM tester_repair_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/tester_repair_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_trr" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [TESTER REPAIR REPORTS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" name="platform" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['platform']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="problem">Problem Full Description</label>
                <textarea type="text" name="problem" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['problem']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

if ($_SESSION['report_type'] == 13){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateTPM($dr_id);
    deleteTPM($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from tester_preventive_maintenance_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM tester_preventive_maintenance_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/tester_preventive_maintenance_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_tpm" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [TESTER PREVENTIVE MAINTENANCE]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" name="platform" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['platform']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
                <label for="handler">PM Findings</label>
                <textarea type="text" name="pm_findings" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pm_findings']?></textarea>
            </div>
            </div>
           </div>
           <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="problem">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">Preventive Action</label>
                <textarea type="text" name="pre_vac" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pre_vac']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Remain Defective Parts</label>
                <textarea type="text" name="remain-defective-parts" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['remain_defective_parts']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Diag Data Logs</label>
                <input type="text" name="diag-data-logs" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['diag_data_logs']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

if ($_SESSION['report_type'] == 14){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateTIHM($dr_id);
    deleteTIHM($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from tester_in_house_module_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM tester_in_house_module_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/tester_in_house_module_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_tihm" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [TESTER IN HOUSE MODULE REPORTS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Part Name</label>
                <input type="text" name="part_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['part_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Part Number</label>
                <input type="text" name="part_number" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['part_number']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" name="platform" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['platform']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>

            <div class="col-3">
                    <div class="form-group">
                        <label for="problem">Serial Number</label>
                        <input type="text" name="serial_number" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['serial_number']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
                </div>
           </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">Problem</label>
                <textarea type="text" name="problem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['problem']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Diag Data Logs</label>
                <input type="text" name="diag_data_logs" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['diag_data_logs']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Diag Data Logs</label>
                <input type="text" name="diag-data-logs" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['diag_data_logs']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
            <label for="dt">Location</label>
            <input type="text" name="location" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['location']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
              </div>
           </div>
           </div>
           <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="stat">Status</label>
                        <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
                </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

if ($_SESSION['report_type'] == 15){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateTDR($dr_id);
    deleteTDR($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from tester_defective_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM tester_defective_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/tester_defective_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_tdr" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [TESTER DEFECTIVE REPORTS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Part Name</label>
                <input type="text" name="part_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['part_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Part Number</label>
                <input type="text" name="part_number" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['part_number']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" name="platform" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['platform']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>

            <div class="col-3">
                    <div class="form-group">
                        <label for="problem">Serial Number</label>
                        <input type="text" name="serial_number" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['serial_number']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
                </div>
           </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">Problem</label>
                <textarea type="text" name="problem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['problem']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Diag Data Logs</label>
                <input type="text" name="diag_data_logs" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['diag_data_logs']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Diag Data Logs</label>
                <input type="text" name="diag-data-logs" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['diag_data_logs']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
            <label for="dt">Location</label>
            <input type="text" name="location" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['location']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
              </div>
           </div>
           </div>
           <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="stat">Status</label>
                        <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
                </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}

if ($_SESSION['report_type'] == 16){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateLSGRR($dr_id);
    deleteLSGRR($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from lsg_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM lsg_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/lsg_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_lb" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [LSG REPAIR REPORTS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['dr_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
            <label for="tester">Tester</label>
            <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Handler</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
            <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB ID</label>
                <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off"  value="<?php echo $d['LB_id']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="lb_name">LB Name</label>
                <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['lb_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="pfd">Problem Full Description</label>
                <textarea type="text" name="pfd" class="form-control" rows="5" autocomplete="off" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-6">
                <div class="form-group">
                    <label for="repair_s">Repair Stage</label>
                    <select type="text" name="repair_s" class="form-control" required="yes"<?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                        <option value="<?php echo $d['repair_s']?>"><?php echo $d['repair_s']?></option>
                        <option value="VISUAL INSPECTION">VISUAL INSPECTION</option>
                        <option value="CONTINUITY CHECK">CONTINUITY CHECK</option>
                        <option value="COMPONENT TESTING">"COMPONENT TESTING</option>
                        <option value="SIGNAL TRACING">SIGNAL TRACING</option>
                        <option value="PRODUCT DEBUG">PRODUCT DEBUG</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
            <div class="col-4">
            <div class="form-group">
                <label for="pre_vac">Preventive Action</label>
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['pre_vac']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['dt']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
if ($_SESSION['report_type'] == 17){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateSR($dr_id);
    deleteSR($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from setup_reports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM setup_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/setup_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_sr" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [SETUP REPORTS]<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div>
        <div class="card-body">
        <div class="container">
            <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post">
            <div class="row">
            <div class="col-3">
            <div class="form-group">
                <label for="tester">Tester</label>
                <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['tester']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="handler">Handler</label>
                <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['handler']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>

            <div class="col-3">
            <div class="form-group">
            <label for="fam_name">Package</label>
            <input type="text" name="package" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['package']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; } ?> >
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="platform">Product Name</label>
                <input type="text" name="product-name" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['fam_name']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
           </div>
           <div class="col-3">
                    <div class="form-group">
                        <label for="problem">Setup Code</label>
                        <input type="text" name="setup-code" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['setup_code']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
            </div>
            <div class="col-3">
                    <div class="form-group">
                        <label for="problem">IE Time</label>
                        <input type="text" name="ie-time" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['ie_time']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
            </div>
            <div class="col-3">
                    <div class="form-group">
                        <label for="problem">Actual Setup Time</label>
                        <input type="text" name="actual-setup-time" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['actual_setup_time']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
            </div>
            <div class="col-3">
                    <div class="form-group">
                        <label for="problem">GAP</label>
                        <input type="text" name="gap" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['gap']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
                    </div>
            </div>
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">Date</label>
            <input type="text" value="<?php echo $d['dr_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>
           </div>
           <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="fwa">Problem Full Description</label>
                        <textarea type="text" name="pfd" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['pfd']?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="fwa">Five Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['fwa']?></textarea>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['action_d']?></textarea>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['category']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['stat']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>
            </div>
            </div>
           </div>
           <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea type="text" name="remarks" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>><?php echo $d['remarks']?></textarea>
                    </div>
                </div>
           </div>
           <div class="row" style="padding-bottom:10px;">
            <div class="col-4">
             <label for="stat">Submitter</label>
              <input type="text" name="submitter" class="form-control" autocomplete="off" value="<?php echo $d['submitter']?>" <?php if (empty($_SESSION['userPriv']) || $_SESSION['userPriv'] != 2) { echo "readonly"; }?>>            
            </div>
           </div>
                <?php if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2) { ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                      DELETE
                    </button>
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
if ($_SESSION['report_type'] == 18){
    //gets current id//////////////////////
    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentHCAT($dr_id);
    deleteHCAT($dr_id);
    ///////////////////////////////////////


    //get data infromation from id/////////
    $sql ="SELECT * from hcat WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);
    ///////////////////////////////////////

    $selectitem = "SELECT * FROM hcat_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item);

    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all);

    $show_name = "SELECT * FROM employeeinfos WHERE cidNum =". $d['responsible'];
    $show_result = $userconnect->query($show_name);
    $sho = get_assocArray($show_result);
    $show_name = $sho['firstName'];
    ?>
    
    <!-- The Modal -->
            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Uploaded Files</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p><?php echo $totalitem ?> FILE/S HAVE BEEN UPLOADED</p>
                    <?php



                    for ($i=0 ; $i < $totalitem ; $i++)
                    {    
                    echo "<div> <a href='uploads/hcat_uploads/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
        //            echo "<div> <a href='uploads/". $item[$i]['item_name'] ."' download='". $item[$i]['item_name'] ."'>" . $item[$i]['item_name'] ."</a></div>";
                    }

                      ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   <p style="font-size: 12px; float:left;">*Documents such as Excel and Word can only be downloaded not previewed</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
    <!-- THE MODAL DELETE   -->        
            <div class="modal fade" id="delModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">

                    <p>ARE YOU SURE YOU WANT TO DELETE THE DATA?</p>
                   
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                   
                    <button type="button" class="btn" style="float:right;" data-dismiss="modal">Close</button>
                    <form action="dr_update.php?id=<?php echo $dr_id;?>" method = "post">
                    <input type="submit" class="btn btn-danger" style="float:left;" name="del_hcat" value="Confirm Deletion">
                    </form>
                  </div>

                </div>
              </div>
            </div>
    <br>
    <br>
    <br>
    <form action="dr_update.php?id=<?php echo $dr_id; ?>" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:20px;">
        <div class="card-header">UPDATE [WEEKLY MEETING ACTION TRACKER] <div style="float:right;">Upload Additional Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple ><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                      SHOW UPLOADED DOCUMENTS
                    </button></div></div>

        <div class="card-body">
        <div class="container">

            <div class="row">
            <div class="col-3"> 
            <div class="form-group">
            <label for="dr_date">ENTRY DATE</label>
            <input type="text" value="<?php echo $d['entry_date']?>" readonly class="form-control form-control-sm" autocomplete="off">
            </div>
            </div>

            <div class="col-6">
            <div class="form-group">
                <label for="desc_act_item">DESCRIPTION OF ACTION ITEM</label>
                <textarea type="text" name="desc_act_item" class="form-control form-control-sm" autocomplete="off" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['desc_act_item']?></textarea>
            </div>
           </div>
           
           </div>
           <div class="row">
           <div class="col-3">
            <div class="form-group">
                <label for="responsible">RESPONSIBLE</label>
                <select list="listall"type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">     
                        <datalist id="listall">
                        <option value="<?php echo $d['responsible']?>" <?php if (empty($_SESSION['userPriv'])) { echo 'readonly'; } ?> > <?php echo $d['responsible']?> </option>
                        <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                        </datalist>
                    </select>
            </div>
            </div>
           <div class="col-3">
            <div class="form-group">
                <label for="commit_closure">COMMIT CLOSURE DATE</label>
                <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off"  value="<?php echo $d['commit_closure']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="act_date">ACTUAL CLOSURE DATE</label>
                <input type="text" name="act_date" class="form-control form-control-sm searchdate" autocomplete="off" value="<?php echo $d['act_date']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            <div class="col-3">
            <div class="form-group">
                <label for="stat">STATUS</label>
                <select type="text" name="stat" class="form-control form-control-sm" value="<?php echo $d['stat']?>" autocomplete="off" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
                <?php   if ($d['stat'] == "OPEN"){
                            $status = "OPEN";
                            
                        }
                        else if ($d['stat'] == "CLOSED"){
                            $status = "CLOSED";
                            
                        } 
                echo "<option value='". $d['stat'] . "'>". $status . "</option>";
                    ?>
                <option value="" disabled>--------------</option>
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>
                </select>
            </div>
            </div>
            </div>
            
            
            <div class="row">
            
            <div class="col-8">
            <div class="form-group">
                <label for="rem">REMARKS</label>
                <textarea type="text" name="rem" class="form-control" rows="5" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>><?php echo $d['rem']?></textarea>
            </div>
            </div>
            <div class="col-4">
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="duration">DURATION</label>
                <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['duration']?>" <?php if (empty($_SESSION['userPriv'])) { echo "readonly"; }?>>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-12">
            <div class="form-group">
                <label for="dt">SUBMITTER</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" value="<?php echo $d['submitter']?>" readonly>
            </div>
            </div>
            </div>
            
            </div>
            </div>
        
        
           
                <?php if (isset($_SESSION['rs_username'])) { ?>
                
                   
                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="UPDATE">
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                              DELETE FORM
                            </button>
                        
                
                    <?php } ?>
            </form>
            </div>
        </div>
    </div>

<?php
}
include "includes/footer.php";
?>
