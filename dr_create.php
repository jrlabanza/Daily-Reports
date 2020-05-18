<?php include "includes/header.php"; 
if (isset($_SESSION['rs_username'])) {
    
  $sql = "SELECT TABLE_NAME AS TEST FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='p1_equipt_db' AND (TABLE_NAME LIKE 'ts%' OR TABLE_NAME LIKE 'bi%' OR TABLE_NAME LIKE 'ag%' OR TABLE_NAME LIKE 'mc%' OR TABLE_NAME LIKE 'bk%' OR TABLE_NAME LIKE 'tct%' OR TABLE_NAME LIKE 'bh%') ";
  $result = $promis->query($sql);
  $tester = get_assocArray($result);
  $tesLen = sizeof($tester);
      
      
  $sql = "SELECT TABLE_NAME AS HAND FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='p1_equipt_db' AND TABLE_NAME LIKE 'hd%' ";
  $result = $promis->query($sql);
  $handler = get_assocArray($result);
  $hanLen = sizeof($handler);

  $sql = "SELECT TesterPF FROM testers";
  $result = $promis->query($sql);
  $platform = get_assocArray($result);
  $platformLen = sizeof($handler);
  
  
  if ($_SESSION['report_type'] == 1){
    createDR();
    $query ="SELECT FFID, isSuper FROM lsg_users WHERE FFID = '". $_SESSION['rs_username'] ."'";
    $result = mysqli_query($connection, $query);
    $user_check = get_data_array($result); ?>

  <script>
    
    var valid_user = "<?php echo $user_check['FFID'] ?>";
    var super_user = "<?php echo $user_check['isSuper'] ?>";
    if (valid_user == ""){
      
    }
    else if (super_user == 1){

    }
    else{
      alert("USER NOT VALID, RETURNING TO DASHBOARD");
      window.location.href = "index.php";
    }
    
    document.getElementById("disable-enter").onkeypress = function(e) {
      var key = e.charCode || e.keyCode || 0;     
      if (key == 13) {
        e.preventDefault();
      }
    }

 
  </script>
    <form action="dr_create.php" method = "post" enctype="multipart/form-data">
      <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
        <div class="card-header">
          CREATE [LOAD BOARD] <div style="float:right;">
            Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
          </div>
        </div>
        <div class="card-body">
          <div class="container">
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  <label for="tester">Tester</label>
                  <select type="text" name="tester" class="form-control form-control-sm" autocomplete="off">
                    <option value=""></option>
                    <option value="TS200HW">TS200HW</option>
                    <option value="UICHW">UICHW</option>
                    <?php   
                    for ($i = 0 ; $i < $tesLen; $i++){ 
                        echo "<option value='". strtoupper($tester[$i]['TEST']). "'>". strtoupper($tester[$i]['TEST']) ."</option>";        
                    } ?>
                  </select>
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label for="handler">Handler</label>
                  <select type="text" name="handler" class="form-control form-control-sm" autocomplete="off">
                    <option value=""></option>

                    <?php  
                    for ($i = 0 ; $i < $hanLen; $i++){ 
                        echo "<option value='". strtoupper($handler[$i]['HAND']). "'>". strtoupper($handler[$i]['HAND']) ."</option>";       
                    } ?>
                  </select>
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label for="handler">Family Name</label>
                  <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off"/>
                    </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label for="lb_name">LB ID</label>
                  <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                    </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  <label for="lb_name">LB Name</label>
                  <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                    </div>
              </div>

              <div class="col-9">
                <div class="form-group">
                  <label for="pfd">Problem Full Description</label>
                  <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="fwa">5 Why Analysis</label>
                  <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="action_d">Action Done</label>
                  <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="repair_s">Repair Stage</label>
                  <select type="text" name="repair_s" class="form-control" required="yes">
                    <option value="VISUAL INSPECTION"></option>
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
                  <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                    </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="dt">Downtime</label>
                  <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                    </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="stat">Status</label>
                  <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                    </div>
              </div>
            </div>
            <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>
            </div>
        </div>
      </div>
    </form><?php 
  }

     if ($_SESSION['report_type'] == 2){ 
        createSL();
        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [SPEEDLOSS] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="tester">Tester ID</label>
              <input type="text" name="tester" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="handler">Tester PF</label>
              <input type="text" name="tester_pf" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="handler">Handler</label>
              <input type="text" name="handler" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="lb_name">Handler PF</label>
              <input type="text" name="handler_pf" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="lb_name">Device</label>
              <input type="text" name="device" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="pfd">Status</label>
              <input type="text" name="sl_status_owner" class="form-control form-control-sm" autocomplete="off"  required="yes"/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="fwa">Status Owner</label>
              <input type="text" name="status_owner" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="action_d">Duration (HRS.)</label>
              <input type="number" name="duration" class="form-control form-control-sm" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="action_d">Who</label>
              <input type="text" name="who_1" class="form-control form-control-sm" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="pre_vac">Problem</label>
              <textarea type="text" name="problem" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="dt">Action Done</label>
              <textarea type="text" name="act_done" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="pre_vac">Commit</label>
              <input type="text" name="sl_commit" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="dt">Status</label>
              <input type="text" name="sl_status" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="stat">Remarks</label>
              <textarea type="text" name="remarks" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes"></textarea>
            </div>
          </div>

        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
    
    if ($_SESSION['report_type'] == 3){
    createBib();
    ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [BURN IN] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="tester">BURN IN OVEN #</label>
              <input type="text" name="burn_in_no" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">FAMILY NAME</label>
              <input type="text" name="family_name" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">BURN IN BOARD ID</label>
              <input type="text" name="bib_id" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">BURN IN BOARD NAME</label>
              <input type="text" name="bib_name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-9">
            <div class="form-group">
              <label for="pfd">Problem Full Description</label>
              <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="fwa">5 Why Analysis</label>
              <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="action_d">Action Done</label>
              <textarea type="text" name="act_done" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="pre_vac">Preventive Action</label>
              <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label for="dt">Downtime</label>
              <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label for="dt">Quantity Replaced</label>
              <input type="text" name="qty" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label for="stat">Status</label>
              <input type="text" name="br_status" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
        
    if ($_SESSION['report_type'] == 4){
    createExt();
    ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [EXTERNAL] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="tester">ITEM DESCRIPTION</label>
              <input type="text" name="item_desc" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">SERIAL ID</label>
              <input type="text" name="serial_id" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">REQUESTING PERSONNEL</label>
              <input type="text" name="req_per" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">REQUESTING DEPARTMENT</label>
              <input type="text" name="req_dept" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-9">
            <div class="form-group">
              <label for="pfd">PROBLEM FULL DESCRIPTION</label>
              <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="fwa">5 WHY ANALYSIS</label>
              <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="action_d">ACTION DONE</label>
              <textarea type="text" name="act_done" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="pre_vac">PREVENTIVE ACTION</label>
              <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="dt">DATE AND TIME RECEIVED</label>
              <input type="text" name="dtr" class="form-control form-control-sm demo" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="dt">DATE AND TIME ENDORSED</label>
              <input type="text" name="dte" class="form-control form-control-sm demo" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="dt">DOWNTIME</label>
              <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="stat">STATUS</label>
              <input type="text" name="ex_status" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
    
    if ($_SESSION['report_type'] == 5){ 
        createLBPM();
        
        

        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [LOAD BOARD PM] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="tester">Tester</label>
              <select type="text" name="tester" class="form-control form-control-sm" autocomplete="off">
                <option value=""></option>
                <option value="TS200HW">TS200HW</option>
                <option value="UICHW">UICHW</option>
                <?php   for ($i = 0 ; $i < $tesLen; $i++){ 
                                echo "<option value='". strtoupper($tester[$i]['TEST']). "'>". strtoupper($tester[$i]['TEST']) ."</option>";       
                            } ?>
              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">Handler</label>
              <select type="text" name="handler" class="form-control form-control-sm" autocomplete="off">
                <option value=""></option>
                <?php   for ($i = 0 ; $i < $hanLen; $i++){ 
                                echo "<option value='". strtoupper($handler[$i]['HAND']) ."'>". strtoupper($handler[$i]['HAND']) ."</option>";       
                            } ?>
              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">Family Name</label>
              <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">LB ID</label>
              <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">LB Name</label>
              <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="pfd">PM Findings</label>
              <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="action_d">Action Done</label>
              <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="pre_vac">Preventive Action</label>
              <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label for="dt">Downtime</label>
              <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="pm">PM Date</label>
              <input type="text" name="pm_date" class="form-control form-control-sm searchdate" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="pmd">PM Due</label>
              <input type="text" name="pm_due" class="form-control form-control-sm searchdate" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
    
    if ($_SESSION['report_type'] == 6){ 
        createWMAT();
        
        $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
        $fullresult = $userconnect-> query($showall_query);
        $all = get_assocArray($fullresult);
        $empsLen = sizeof($all);
        

        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [WEEKLY MEETING ACTION TRACKER] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="desc_act_item">DESCRIPTION OF ITEM</label>
              <textarea type="text" name="desc_act_item" class="form-control form-control-sm" rows="5" autocomplete="off"></textarea>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="responsible">RESPONSIBLE</label>
              <select list="listall" type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">
                <datalist id="listall">
                  <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                </datalist>
              </select>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="commit_closure" style="font-size:14px;">COMMIT CLOSURE DATE</label>
              <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off" />
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="act_date" style="font-size:14px;">ACTUAL CLOSURE DATE</label>
              <input type="text" name="act_date" class="form-control form-control-sm searchdate" autocomplete="off" />
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="stat">STATUS</label>
              <select type="text" name="stat" class="form-control form-control-sm" autocomplete="off" rows="5" required="yes">
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>

              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="duration">DURATION</label>
              <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>


        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="rem">REMARKS</label>
              <textarea type="text" name="rem" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
    
    if ($_SESSION['report_type'] == 7){ 
        createLBIM(); ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [LOAD BOARD ISSUE MONITORING] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="tester">Tester</label>
              <select type="text" name="tester" class="form-control form-control-sm" autocomplete="off">
                <option value=""></option>
                <option value="TS200HW">TS200HW</option>
                <option value="UICHW">UICHW</option>
                <?php   for ($i = 0 ; $i < $tesLen; $i++){ 
                                echo "<option value='". strtoupper($tester[$i]['TEST']). "'>". strtoupper($tester[$i]['TEST']) ."</option>";        
                            } ?>
              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">Handler</label>
              <select type="text" name="handler" class="form-control form-control-sm" autocomplete="off">
                <option value=""></option>

                <?php   for ($i = 0 ; $i < $hanLen; $i++){ 
                                echo "<option value='". strtoupper($handler[$i]['HAND']). "'>". strtoupper($handler[$i]['HAND']) ."</option>";       
                            } ?>
              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">Family Name</label>
              <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">LB ID</label>
              <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="lb_name">LB Name</label>
              <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>

          <div class="col-9">
            <div class="form-group">
              <label for="pfd">Problem Full Description</label>
              <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="fwa">5 Why Analysis</label>
              <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="action_d">Action Done</label>
              <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="pre_vac">Preventive Action</label>
              <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="dt">Downtime</label>
              <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="stat">Status</label>
              <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }

    if ($_SESSION['report_type'] == 8){ 
        createEE(); ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [EE Report] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">


        <div class="col-12">
          <div class="form-group">
            <label for="desc_act_item">ACTIVITIES DONE</label>
            <textarea type="text" name="activity_done" class="form-control form-control-sm" rows="15" autocomplete="off"></textarea>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="stat">STATUS</label>

            <select type="text" name="stat" class="form-control form-control-sm" autocomplete="off" rows="5" required="yes">
              <option value="OPEN">OPEN</option>
              <option value="CLOSED">CLOSED</option>
            </select>

          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>
                            </div>
        </div>

      </div>
    </div>
  </div>
</form>

<?php }

    if ($_SESSION['report_type'] == 9){ 
        createDMAT();
        
        $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
        $fullresult = $userconnect-> query($showall_query);
        $all = get_assocArray($fullresult);
        $empsLen = sizeof($all);
        

        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [DAILY MEETING ACTION TRACKER] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="desc_act_item">DESCRIPTION OF ITEM</label>
              <textarea type="text" name="desc_act_item" class="form-control form-control-sm" rows="5" autocomplete="off"></textarea>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="responsible">RESPONSIBLE</label>
              <select list="listall" type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true"/>
                <datalist id="listall">
                  <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                </datalist>
              </select>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="commit_closure" style="font-size:14px;">COMMIT CLOSURE DATE</label>
              <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off" />
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="stat">STATUS</label>
              <select type="text" name="stat" class="form-control form-control-sm" autocomplete="off" rows="5" required="yes">
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>

              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="duration">DURATION</label>
              <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>


        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="rem">REMARKS</label>
              <textarea type="text" name="rem" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }

    if ($_SESSION['report_type'] == 10)
    { 
        createM3();
        
        $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
        $fullresult = $userconnect-> query($showall_query);
        $all = get_assocArray($fullresult);
        $empsLen = sizeof($all);?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:80px; margin-right:80px; margin-top:60px;">
    <div class="card-header">
      CREATE [ONLINE SETUP REQUEST] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
      </div>
    </div>
    <div class="card-body" style="background:#c4c4c4;">
      <div class="row">
        <div class="col-6">
          <div class="card mb-3">
            <div class="card-header" style='background:yellow'> CURRENT SETUP </div>
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
                  <input type="text" class='form-control form-control-sm' name='handler-cs'/>
                                        </div>
                <div class="col-4">
                  <input type="text" class='form-control form-control-sm' name='handler-platform-cs'/>
                                        </div>
                <div class="col-4">
                  <input type="text" class='form-control form-control-sm' name='tester-cs'/>
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
                  <input type="text" class='form-control form-control-sm' name='tester-platform-cs'/>
                                        </div>
                <div class="col-4">
                  <input type="text" class='form-control form-control-sm' name='family-name-cs'/>
                                        </div>
                <div class="col-4">
                  <input type="text" class='form-control form-control-sm' name='loadboard-name-cs'/>
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
                  <input type="text" class='form-control form-control-sm' name='loadboard-id-cs'/>
                                        </div>
                <div class="col-4">
                  <input type="text" class='form-control form-control-sm' name='package-cs'/>
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
                    <th>N/A</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Program</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-program-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-program-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Center Board</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-center-board-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-center-board-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Load Board</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-load-board-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-load-board-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Package</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-package-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-package-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Kit</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-kit-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-kit-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Tester Transfer</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="tester-transfer-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="tester-transfer-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Handler Tester</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="handler-tester-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="handler-tester-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Handler</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-handler-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-handler-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Tester</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-tester-ts" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-tester-ts" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header" style='background:#ffb963'> OTHERS </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div>Remarks</div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <textarea name="submitter-remarks" rows='7' style='width:100%'></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div>STATUS</div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <select class='form-control form-control-sm' name="status" id="">
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
                  <input type="text" name='handler-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='handler-platform-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='tester-PS' class='form-control form-control-sm'/>
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
                  <input type="text" name='tester-platform-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='family-name-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='loadboard-name-PS' class='form-control form-control-sm'/>
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
                  <input type="text" name='loadboard-ID-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='package-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='edtm-PS' class='form-control form-control-sm'/>
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
                  <input type="text" name='requested-by-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='group-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='shift-PS' class='form-control form-control-sm'/>
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
                  <input type="text" name='requested-date-PS' class='form-control form-control-sm m3_date'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='expected-date-of-setup-PS' class='form-control form-control-sm m3_date'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='unscheduled-setup-PS' class='form-control form-control-sm'/>
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
                  <input type="text" name='reason-for-unscheduled-setup-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='lsg-approver-PS' class='form-control form-control-sm'/>
                                        </div>
                <div class="col-4">
                  <input type="text" name='remarks-PS' class='form-control form-control-sm'/>
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
                    <th>N/A</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <span class='radiotext'>Change Kit</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-kit-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="change-kit-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Separator Plate</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="separator-plate-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="separator-plate-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Unloader Kit</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="unloader-kit-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="unloader-kit-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Work Press</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="work-press-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="work-press-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Baseplate</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="baseplate-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="baseplate-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Socket Jig</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="socket-jig-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="socket-jig-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Power Supply</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="power-supply-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="power-supply-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Oscilloscope</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="oscilloscope-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="oscilloscope-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Socket</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="socket-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="socket-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class='radiotext'>Others</span>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="others-sm" value='YES'/>
                      </label>
                    </td>
                    <td>
                      <label class="radio-inline">
                        <input type="radio" name="others-sm" value='N/A'/>
                      </label>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-12">
          <input class="btn btn-primary"  type="submit" name="submit" value="CREATE" style='float:right'/>
        </div>
      </div>
    </div>
  </div>
</form>

<?php }

    if ($_SESSION['report_type'] == 11){ 
        createEMAT();
        
        $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
        $fullresult = $userconnect-> query($showall_query);
        $all = get_assocArray($fullresult);
        $empsLen = sizeof($all);
        

        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [EQUIPMENT STAFF MEETING ACTION TRACKER] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="desc_act_item">DESCRIPTION OF ITEM</label>
              <textarea type="text" name="desc_act_item" class="form-control form-control-sm" rows="5" autocomplete="off"></textarea>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="responsible">RESPONSIBLE</label>
              <select list="listall" type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">
                <datalist id="listall">
                  <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                </datalist>
              </select>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="commit_closure" style="font-size:14px;">COMMIT CLOSURE DATE</label>
              <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off"/>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="stat">STATUS</label>
              <select type="text" name="stat" class="form-control form-control-sm" autocomplete="off" rows="5" required="yes">
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>

              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="duration">DURATION</label>
              <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>


        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="rem">REMARKS</label>
              <textarea type="text" name="rem" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php

}
if ($_SESSION['report_type'] == 12){ 
    createTRR();
        
    $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
    $fullresult = $userconnect-> query($showall_query);
    $all = get_assocArray($fullresult);
    $empsLen = sizeof($all); 

    $machine_query = "SELECT * FROM machine";
    $machineresult = $connection->query($machine_query);
    $machine = get_assocArray($machineresult);
    $machineLen = sizeof($machine);
        
    $partname_query = "SELECT part_number, part_name FROM parts";
    $partname_result = $connection->query($partname_query);
    $partget = get_assocArray($partname_result);
    $partLen = sizeof($partget);
    ?>

    

  <form action="dr_create.php" method = "post" enctype="multipart/form-data">
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
      <div class="card-header">
        CREATE [TESTER REPAIR REPORT] <div style="float:right;">
          Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
        </div>
      </div>
      <div class="card-body">
      <div class="container">
        <div class="row">
        <div class="col-3">
          <div class="form-group">
            <label for="tester">Tester</label>
            <select type="text" name="tester" class="form-control form-control-sm tester" autocomplete="off">
              <?php   
              for ($i = 0 ; $i < $machineLen; $i++){ 
                  echo "<option value='". strtoupper($machine[$i]['machine_number']). "'>". strtoupper($machine[$i]['machine_number']) ."</option>";        
              } ?>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="platform">Platform</label>
            <input type="text" name="platform" class="form-control form-control-sm platform" autocomplete="off" readonly/>

              <?php  
              // for ($i = 0 ; $i < $machineLen; $i++){ 
              //     echo "<option value='". strtoupper($machine[$i]['platform']). "'>". strtoupper($machine[$i]['platform']) ."</option>";       
              // } 
              ?>
           
          </div>
        </div>
          <div class="col-3">
            <div class="form-group">
              <label for="handler">Family Name</label>
              <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off"/>
                </div>
          </div>
        </div>
        <div class="row">
          <div class="col-9">
            <div class="form-group">
              <label for="pfd">Problem</label>
              <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="fwa">5 Why Analysis</label>
              <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="action_d">Action Done</label>
              <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="pre_vac">Preventive Action</label>
              <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="dt">Downtime</label>
              <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="stat">Status</label>
              <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


        </div>
      </div>
    </div>
  </form>

  <?php

}

if ($_SESSION['report_type'] == 13){ 
  createTPM();
      
  $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
  $fullresult = $userconnect-> query($showall_query);
  $all = get_assocArray($fullresult);
  $empsLen = sizeof($all); 
  
  $machine_query = "SELECT * FROM machine";
  $machineresult = $connection->query($machine_query);
  $machine = get_assocArray($machineresult);
  $machineLen = sizeof($machine);
      
  $partname_query = "SELECT part_number, part_name FROM parts";
  $partname_result = $connection->query($partname_query);
  $partget = get_assocArray($partname_result);
  $partLen = sizeof($partget);
  ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [TESTER PREVENTIVE MAINTENENACE] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
      </div>
    </div>
    <div class="card-body">
    <div class="container">
      <div class="row">
      <div class="col-3">
          <div class="form-group">
            <label for="tester">Tester</label>
            <select type="text" name="tester" class="form-control form-control-sm tester" autocomplete="off">
              <?php   
              for ($i = 0 ; $i < $machineLen; $i++){ 
                  echo "<option value='". strtoupper($machine[$i]['machine_number']). "'>". strtoupper($machine[$i]['machine_number']) ."</option>";        
              } ?>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="platform">Platform</label>
            <input type="text" name="platform" class="form-control form-control-sm platform" autocomplete="off" readonly/>

              <?php  
              // for ($i = 0 ; $i < $machineLen; $i++){ 
              //     echo "<option value='". strtoupper($machine[$i]['platform']). "'>". strtoupper($machine[$i]['platform']) ."</option>";       
              // } 
              ?>
           
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="handler">PM Findings</label>
            <textarea type="text" name="pm_findings" class="form-control" rows="5" autocomplete="off"></textarea>
              </div>
        </div>
      </div>
      <div class="row">
        <div class="col-9">
          <div class="form-group">
            <label for="pfd">Action Done</label>
            <textarea type="text" name="action_d" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label for="fwa">Preventive Action</label>
            <textarea type="text" name="pre_vac" class="form-control" rows="5" required="yes"></textarea>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="action_d">Remain Defective Parts</label>
            <textarea type="text" name="remain-defective-parts" class="form-control" rows="5" required="yes"></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label for="pre_vac">Downtime</label>
            <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="dt">Diag Data Logs</label>
            <input type="text" name="diag-data-logs" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="stat">Status</label>
            <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
      </div>


      <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


      </div>
    </div>
  </div>
</form>

<?php

}

if ($_SESSION['report_type'] == 14){ 
  createTIHM();
      
  $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
  $fullresult = $userconnect-> query($showall_query);
  $all = get_assocArray($fullresult);
  $empsLen = sizeof($all); 

  $machine_query = "SELECT * FROM machine";
  $machineresult = $connection->query($machine_query);
  $machine = get_assocArray($machineresult);
  $machineLen = sizeof($machine);
      
  $partname_query = "SELECT part_number, part_name FROM parts";
  $partname_result = $connection->query($partname_query);
  $partget = get_assocArray($partname_result);
  $partLen = sizeof($partget);
  ?>
  

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [TESTER IN HOUSE MODULE REPORT] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
      </div>
    </div>
    <div class="card-body">
    <div class="container">
      <div class="row">
        <div class="col-3">
          <div class="form-group">
            <label for="handler">Part Name</label>
            <input type="text" name="part_name" class="form-control form-control-sm part_name" autocomplete="off" list="part_name"/>
            <datalist id="part_name">
            <?php 
              for ($i = 0; $i < $partLen; $i++){
                echo "<option value='". strtoupper($partget[$i]['part_name']) ."'>". strtoupper($partget[$i]['part_name']) ."</option>"; 
              }
            ?>
            </datalist>
              </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="pfd">Part Number</label>
            <input type="text" list="part_number" name="part_number" class="form-control form-control-sm part_number" autocomplete="off" required="yes" readonly>
            <datalist id="part_number">
            <?php 
              for ($i = 0; $i < $partLen; $i++){
                echo "<option value='". strtoupper($partget[$i]['part_number']) ."'>". strtoupper($partget[$i]['part_number']) ."</option>"; 
              }
            ?>
            </datalist>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="tester">Tester</label>
            <select type="text" name="tester" class="form-control form-control-sm tester" autocomplete="off">
              <?php   
              for ($i = 0 ; $i < $machineLen; $i++){ 
                  echo "<option value='". strtoupper($machine[$i]['machine_number']). "'>". strtoupper($machine[$i]['machine_number']) ."</option>";        
              } ?>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="platform">Platform</label>
            <input type="text" name="platform" class="form-control form-control-sm platform" autocomplete="off" readonly/>

              <?php  
              // for ($i = 0 ; $i < $machineLen; $i++){ 
              //     echo "<option value='". strtoupper($machine[$i]['platform']). "'>". strtoupper($machine[$i]['platform']) ."</option>";       
              // } 
              ?>
           
          </div>
        </div>

		<div class="col-3">
          <div class="form-group">
            <label for="fwa">Serial Number</label>
            <input type="text" name="serial_number" class="form-control form-control-sm" required="yes">
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-6">
          <div class="form-group">
            <label for="action_d">Problem</label>
            <textarea type="text" name="problem" class="form-control" rows="5" required="yes"></textarea>
          </div>
        </div>
		<div class="col-6">
          <div class="form-group">
            <label for="pre_vac">Action Done</label>
            <textarea type="text" name="action_d" class="form-control" rows="5" autocomplete="off" required="yes"></textarea>
              </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label for="dt">Diag Data Logs</label>
            <input type="text" name="diag_data_logs" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="dt">Location</label>
            <input type="text" name="location" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="stat">Status</label>
            <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
      </div>


      <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


      </div>
    </div>
  </div>
</form>

<?php

}

if ($_SESSION['report_type'] == 15){ 
  createTDR();
      
  $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
  $fullresult = $userconnect-> query($showall_query);
  $all = get_assocArray($fullresult);
  $empsLen = sizeof($all); 
  
  $machine_query = "SELECT * FROM machine";
  $machineresult = $connection->query($machine_query);
  $machine = get_assocArray($machineresult);
  $machineLen = sizeof($machine);
      
  $partname_query = "SELECT part_number, part_name FROM parts";
  $partname_result = $connection->query($partname_query);
  $partget = get_assocArray($partname_result);
  $partLen = sizeof($partget);
  ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [TESTER DEFECTIVE REPORTS] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple=""/>
      </div>
    </div>
    <div class="card-body">
    <div class="container">
      <div class="row">
      <div class="col-3">
          <div class="form-group">
            <label for="handler">Part Name</label>
            <input type="text" name="part_name" class="form-control form-control-sm part_name" autocomplete="off" list="part_name"/>
            <datalist id="part_name">
            <?php 
              for ($i = 0; $i < $partLen; $i++){
                echo "<option value='". strtoupper($partget[$i]['part_name']) ."'>". strtoupper($partget[$i]['part_name']) ."</option>"; 
              }
            ?>
            </datalist>
              </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="pfd">Part Number</label>
            <input type="text" list="part_number" name="part_number" class="form-control form-control-sm part_number" autocomplete="off" required="yes">
            <datalist id="part_number">
            <?php 
              for ($i = 0; $i < $partLen; $i++){
                echo "<option value='". strtoupper($partget[$i]['part_number']) ."'>". strtoupper($partget[$i]['part_number']) ."</option>"; 
              }
            ?>
            </datalist>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="tester">Tester</label>
            <select type="text" name="tester" class="form-control form-control-sm tester" autocomplete="off">
            <option value=''></option>
              <?php   
              for ($i = 0 ; $i < $machineLen; $i++){ 
                  echo "<option value='". strtoupper($machine[$i]['machine_number']). "'>". strtoupper($machine[$i]['machine_number']) ."</option>";        
              } ?>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="platform">Platform</label>
            <input type="text" name="platform" class="form-control form-control-sm platform" autocomplete="off" readonly/>

              <?php  
              // for ($i = 0 ; $i < $machineLen; $i++){ 
              //     echo "<option value='". strtoupper($machine[$i]['platform']). "'>". strtoupper($machine[$i]['platform']) ."</option>";       
              // } 
              ?>
           
          </div>
        </div>
        
		<div class="col-3">
          <div class="form-group">
            <label for="fwa">Serial Number</label>
            <input type="text" name="serial_number" class="form-control form-control-sm" required="yes"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label for="action_d">Problem</label>
            <textarea type="text" name="problem" class="form-control" rows="5" required="yes"></textarea>
          </div>
        </div>
		<div class="col-6">
          <div class="form-group">
            <label for="pre_vac">Action Done</label>
            <textarea type="text" name="action_d" class="form-control form-control-sm" rows="5" autocomplete="off" required="yes"></textarea>
              </div>
        </div>
      </div>
      <div class="row">

        <div class="col-4">
          <div class="form-group">
            <label for="dt">Diag Data Logs</label>
            <input type="text" name="diag_data_logs" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="dt">Location</label>
            <input type="text" name="location" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for="stat">Status</label>
            <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
              </div>
        </div>
      </div>
      <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>
      </div>
    </div>
  </div>
</form>

<?php
}

if ($_SESSION['report_type'] == 16){
  CreateLSGRR(); 
  
  $query ="SELECT FFID, isSuper FROM lsg_users WHERE FFID = '". $_SESSION['rs_username'] ."'";
  $result = mysqli_query($connection, $query);
  $user_check = get_data_array($result);
  ?>
  <script>
    
    var valid_user = "<?php echo $user_check['FFID'] ?>";
    var super_user = "<?php echo $user_check['isSuper'] ?>";
    if (valid_user != ""){
      
    }
    else if(super_user == 1){

    }
    else{
      alert("USER NOT VALID, RETURNING TO DASHBOARD");
      window.location.href = "lsg-index.php";
    }
    
    document.getElementById("disable-enter").onkeypress = function(e) {
      var key = e.charCode || e.keyCode || 0;     
      if (key == 13) {
        e.preventDefault();
      }
    }

 
  </script>
  <form id="disable-enter" action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to proceed with your attachment/s and information?</p>
        </div>
        <div class="modal-footer">
          <input class="btn btn-success" type="submit" name="submit" value="CREATE FORM"/>
          <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">CANCEL</button>
        </div>
      </div>

    </div>
  </div>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
      <div class="card-header">
        CREATE [LSG REPAIR REPORTS]<div style="float:right;">
          Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
        </div>
      </div>
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label for="tester">Tester</label>
                <select type="text" name="tester" class="form-control form-control-sm" autocomplete="off">
                  <option value=""></option>
                  <option value="TS200HW">TS200HW</option>
                  <option value="UICHW">UICHW</option>
                  <?php   
                  for ($i = 0 ; $i < $tesLen; $i++){ 
                      echo "<option value='". strtoupper($tester[$i]['TEST']). "'>". strtoupper($tester[$i]['TEST']) ."</option>";        
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="handler">Handler</label>
                <select type="text" name="handler" class="form-control form-control-sm" autocomplete="off">
                  <option value=""></option>

                  <?php  
                  for ($i = 0 ; $i < $hanLen; $i++){ 
                      echo "<option value='". strtoupper($handler[$i]['HAND']). "'>". strtoupper($handler[$i]['HAND']) ."</option>";       
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="handler">Family Name</label>
                <input type="text" name="fam_name" class="form-control form-control-sm" autocomplete="off"/>
                  </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="lb_name">LB ID</label>
                <input type="text" name="lb_id" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label for="lb_name">LB Name</label>
                <input type="text" name="lb_name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>

            <div class="col-9">
              <div class="form-group">
                <label for="pfd">Problem Full Description</label>
                <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
              </div>
            </div>
          </div>
          <div class="row" hidden>
            <div class="col-6">
              <div class="form-group">
                <label for="repair_s">Repair Stage</label>
                <select type="text" name="repair_s" class="form-control" required="yes">
                  <option value="VISUAL INSPECTION"></option>
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
                <input type="text" name="pre_vac" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="dt">Downtime</label>
                <input type="text" name="dt" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
          </div>
          <!-- <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/> -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right">CREATE</button>

          </div>
      </div>
    </div>
  </form><?php 
}
if ($_SESSION['report_type'] == 17){
  CreateSR(); 
  
  $query ="SELECT FFID, isSuper FROM lsg_users WHERE FFID = '". $_SESSION['rs_username'] ."'";
  $result = mysqli_query($connection, $query);
  $user_check = get_data_array($result);
  ?>
  <script>
    
    var valid_user = "<?php echo $user_check['FFID'] ?>";
    var super_user = "<?php echo $user_check['isSuper'] ?>";
    if (valid_user != ""){
      
    }
    else if(super_user == 1){

    }
    else{
      alert("USER NOT VALID, RETURNING TO DASHBOARD");
      window.location.href = "setup-index.php";
    }
    
    document.getElementById("disable-enter").onkeypress = function(e) {
      var key = e.charCode || e.keyCode || 0;     
      if (key == 13) {
        e.preventDefault();
      }
    }

 
  </script>
  <form id="disable-enter" action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to proceed with your attachment/s and information?</p>
        </div>
        <div class="modal-footer">
          <input class="btn btn-success" type="submit" name="submit" value="CREATE FORM"/>
          <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">CANCEL</button>
        </div>
      </div>

    </div>
  </div>
    <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
      <div class="card-header">
        CREATE [SETUP REPORTS]<div style="float:right;">
          Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
        </div>
      </div>
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label for="tester">Tester</label>
                <select type="text" name="tester" class="form-control form-control-sm" autocomplete="off">
                  <option value=""></option>
                  <option value="TS200HW">TS200HW</option>
                  <option value="UICHW">UICHW</option>
                  <?php   
                  for ($i = 0 ; $i < $tesLen; $i++){ 
                      echo "<option value='". strtoupper($tester[$i]['TEST']). "'>". strtoupper($tester[$i]['TEST']) ."</option>";        
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="handler">Handler</label>
                <select type="text" name="handler" class="form-control form-control-sm" autocomplete="off">
                  <option value=""></option>

                  <?php  
                  for ($i = 0 ; $i < $hanLen; $i++){ 
                      echo "<option value='". strtoupper($handler[$i]['HAND']). "'>". strtoupper($handler[$i]['HAND']) ."</option>";       
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="package">Package</label>
                <input type="text" name="package" class="form-control form-control-sm" autocomplete="off"/>
                  </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" name="product-name" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label for="setup-code">Setup Code</label>
                <select name="setup-code" id="setup-code" class="form-control form-control-sm" autocomplete="off" required="yes">
                  <option value=""></option>
                  <option value="P-SW">Change Program (SOUTHWING)</option>
                  <option value="P-NW">Change Program (NORTHWING)</option>
                  <option value="CK-SW">Change Kit (SOUTHWING)</option>
                  <option value="CK-NW">Change Kit (NORTHWING)</option>
                  <option value="LB-SW">Change LB (SOUTHWING)</option>
                  <option value="LB-NW">Change LB (NORTHWING)</option>
                  <option value="HT-SW">Handler Transfer (SOUTHWING)</option>
                  <option value="HT-NW">Handler Transfer (NORTHWING)</option>
                  <option value="TT-SW">Tester Transfer (SOUTHWING)</option>
                  <option value="TT-NW">Tester Transfer (NORTHWING)</option>
                </select>
                <!-- <input type="text" name="setup-code" class="form-control form-control-sm" autocomplete="off" required="yes"/> -->
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="ie-time">IE Time</label>
                <input type="text" name="ie-time" id="ie-time" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="actual-setup-time">Actual Setup Time</label>
                <input type="text" name="actual-setup-time" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="gap">GAP</label>
                <input type="text" name="gap" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
          </div>
          <div class="row">
              <div class="col-9">
                <div class="form-group">
                  <label for="pfd">Problem Full Description</label>
                  <textarea type="text" name="pfd" class="form-control" autocomplete="off" rows="5" required="yes"></textarea>
                </div>
              </div>
            </div> 
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="fwa">5 Why Analysis</label>
                <textarea type="text" name="fwa" class="form-control" rows="5" required="yes"></textarea>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="action_d">Action Done</label>
                <textarea type="text" name="action_d" class="form-control" rows="5" required="yes"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="category">Category</label>
                <select type="text" name="category" class="form-control" required="yes">
                  <option value=""></option>
                  <option value="PLANNED">PLANNED</option>
                  <option value="UNPLANNED">UNPLANNED</option>
                  <option value="PAD">PAD</option>
                  <option value="PDE">PDE</option>
                  <!-- <option value="UNPAD">UNPAD</option>
                  <option value="UNPDE">UNPDE</option> -->
                </select>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="stat">Status</label>
                <input type="text" name="stat" class="form-control form-control-sm" autocomplete="off" required="yes"/>
                  </div>
            </div>
          </div>
          <div class="row">
          <div class="col-6">
              <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea type="text" name="remarks" class="form-control" rows="5" required="yes"></textarea>
              </div>
          </div>
          <div class="col-6">
              <div class="form-group">
                <label for="remarks">Group</label>
                <select type="text" name="shift" class="form-control" required="yes">
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <!-- <option value="UNPAD">UNPAD</option>
                  <option value="UNPDE">UNPDE</option> -->
                </select>
              </div>
          </div>
          </div>
          <!-- <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/> -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right">CREATE</button>

          </div>
      </div>
    </div>
  </form><?php 
}
    
    if ($_SESSION['report_type'] == 18){ 
      createHCAT();
        
        $showall_query ="SELECT * from employeeinfos WHERE isDeleted=0 AND deptCode = '564-5404' ORDER BY firstName ASC";
        $fullresult = $userconnect-> query($showall_query);
        $all = get_assocArray($fullresult);
        $empsLen = sizeof($all);
        

        ?>

<form action="dr_create.php" method = "post" enctype="multipart/form-data">
  <div class="card mb-3" style="margin-left:120px; margin-right:120px; margin-top:60px;">
    <div class="card-header">
      CREATE [HARDWARE C-SHOP ACTION TRACKER] <div style="float:right;">
        Upload Files:  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="" />
      </div>
    </div>
    <div class="card-body">
      <div class="container">

        <div class="row">

          <div class="col-6">
            <div class="form-group">
              <label for="desc_act_item">DESCRIPTION OF ITEM</label>
              <textarea type="text" name="desc_act_item" class="form-control form-control-sm" rows="5" autocomplete="off"></textarea>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="responsible">RESPONSIBLE</label>
              <select list="listall" type="text"  name="responsible" class="form-control form-control-sm input mr-auto empName" required="true">
                <datalist id="listall">
                  <?php
                                for($i=0; $i<$empsLen; $i++){
                                    echo "<option data-empID='". $all[$i]['cidNum'] ."' value='". $all[$i]['cidNum'] ."'>". $all[$i]['firstName'] ." ". $all[$i]['lastName'] ." [". $all[$i]['cidNum'] ."] </option>";
                                }
                            ?>

                </datalist>
              </select>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label for="commit_closure" style="font-size:14px;">COMMIT CLOSURE DATE</label>
              <input type="text" name="commit_closure" class="form-control form-control-sm searchdate" autocomplete="off" />
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="act_date" style="font-size:14px;">ACTUAL CLOSURE DATE</label>
              <input type="text" name="act_date" class="form-control form-control-sm searchdate" autocomplete="off" />
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="stat">STATUS</label>
              <select type="text" name="stat" class="form-control form-control-sm" autocomplete="off" rows="5" required="yes">
                <option value="OPEN">OPEN</option>
                <option value="CLOSED">CLOSED</option>

              </select>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="duration">DURATION</label>
              <input type="text" name="duration" class="form-control form-control-sm" autocomplete="off" required="yes"/>
            </div>
          </div>


        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="rem">REMARKS</label>
              <textarea type="text" name="rem" class="form-control" rows="5" required="yes"></textarea>
            </div>
          </div>
        </div>


        <input class="btn btn-primary" type="submit" name="submit" value="CREATE"/>


    </div>
    </div>
  </div>
</form>

<?php }
    include "includes/footer.php";
}

else{

  header("Location: index.php");

}  




?>