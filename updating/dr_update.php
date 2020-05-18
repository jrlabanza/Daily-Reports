<?php
    include "includes/header.php";
    $readonly = "readonly";

    $status = "";
    $status_value = "";

    if (is_numeric($_GET['id'])){
        $dr_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    }
    updateCurrentData($dr_id);
    deleteLB($dr_id);

    $sql ="SELECT * from dailyreports WHERE id=".$dr_id;
    $result = $connection-> query($sql);
    $d = get_data_array($result);

    $selectitem = "SELECT * FROM lb_uploads WHERE itemId=". $dr_id ; 
    $itemresult = $connection->query($selectitem);
    $item = get_assocArray($itemresult);
    $totalitem = sizeof($item); ?>

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
                        echo "<div> <a href='uploads/load_board/". $item[$i]['item_name'] ."'  target='_blank'>" . $item[$i]['item_name'] ."</a></div>";
                    } ?>
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
        <div class="card-header">UPDATE [LOAD BOARD]
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">
                SHOW UPLOADED DOCUMENTS
            </button>
        </div>
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
                <?php
                if (isset($_SESSION['rs_username']) && $_SESSION['userPriv'] == 2){ ?>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Update">
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal" style="float:right;">
                        DELETE
                    </button>
                <?php } ?>
            </form>
        </div>
        </div>
    </div>

<?php include "includes/footer.php"; ?>
