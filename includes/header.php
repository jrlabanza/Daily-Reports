<!DOCTYPE html>
<?php session_start();?>
<?php include "database/db.php";?>
<?php include "functions/functions.php";?>
<?php
if (isset($_SESSION['rs_username']))
  {
    $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
    $result = $userconnect-> query($sql);
    $s = get_data_array($result);
  } ?>

<html>
<head>
  <meta charset="utf-8">
  <title>REPAIR REPORTS</title>
    <link rel="icon" href="img/onlogo.png">
    <link href="node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.min.css"/>
    <link href="node_modules/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="node_modules/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/fixedColumns.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/fixedHeader.bootstrap4.min.css" />

    
    <link rel="stylesheet" type='text/css' href="css/css.css">


    <div id="massUp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content text-center">
                <form action="massupload.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">MASS UPLOAD</h4>
                      </div>
                    <div class="modal-body">
                    <label><h5><p>UPLOAD CSV ONLY</p></h5></label><br>

                        <input type="file" class="btn" name="massUpload" id="massUpload">

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="sub_mass" value="SUBMIT">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  

</head>
<body>

<?php
  if (isset($_SESSION['rs_username'])){ ?>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="font-size: 10px;">
    <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; margin-right: 30px;" ><i class="fas fa-globe-asia mr-1"></i>DAILY REPORTS
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD REPAIR REPORTS</a>
                  <a class="dropdown-item" href="lbpm-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD PREVENTIVE MAINTENANCE</a>
                  <a class="dropdown-item" href="lbim-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD ISSUE MONITORING</a>
                  <a class="dropdown-item" href="tester-repair-report-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER REPAIR REPORT</a>
                  <a class="dropdown-item" href="tester-preventive-maintenance-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER PREVENTIVE MAINTENANCE REPORT</a>
                  <a class="dropdown-item" href="tester-in-house-module-repair-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER IN-HOUSE MODULE REPAIR REPORT</a>
                  <a class="dropdown-item" href="tester-defective-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER DEFECTIVE BOARD/PARTS</a>
                  <a class="dropdown-item" href="sl-index.php" style="font-size: 12px;"><i class="fas fa-tachometer-alt mr-1"></i>SPEEDLOSS REPORTS</a>
                  <a class="dropdown-item" href="bib-index.php" style="font-size: 12px;"><i class="fas fa-burn mr-1"></i>BURN-IN BOARD REPORTS</a>
                  <a class="dropdown-item" href="ext-index.php" style="font-size: 12px;"><i class="fas fa-external-link-alt mr-1"></i>EXTERNAL BOARD REPAIR REPORTS</a>
                  <a class="dropdown-item" href="dmat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>DAILY MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="wmat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>WEEKLY MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="hcat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>HARDWARE C-SHOP ACTION TRACKER</a>
                  <a class="dropdown-item" href="emat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>EQUIPMENT STAFF MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="ee-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>EE REPORTS</a>
                  <a class="dropdown-item" href="lsg-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i> LSG REPAIR REPORTS</a>
                  <a class="dropdown-item" href="m3-index.php" style="font-size: 12px;"><i class="fas fa-satellite-dish mr-1"></i>ONLINE SETUP REQUEST</a>
                  <a class="dropdown-item" href="setup-index.php" style="font-size: 12px;"><i class="fas fa-stream mr-1"></i>SETUP REPORT</a>             
              </div>
  </div>               
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup"></div>
            <div class="nav-item dropdown" style="float:right; margin-right: 40px;">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                WELCOME <?php echo $s['firstName'] ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" style="font-size: 12px;" href="dr_create.php"><i class="fas fa-file-signature mr-1"></i>CREATE</a>
                  <?php  if ($_SESSION['userPriv'] == 2){ ?> 
                  <a class="dropdown-item" style="font-size: 12px;" href="" data-toggle="modal" data-target="#massUp"><i class="fas fa-file-upload mr-2"></i>MASS UPLOAD</a>
                  <?php } ?>
                <a class="dropdown-item" style="font-size: 12px;" href="http://10.153.239.120"><i class="fas fa-globe-asia mr-1"></i>PROMIS</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" style="font-size: 12px;" href="logout_page.php"><i class="fas fa-sign-out-alt mr-1"></i>LOG-OUT</a>
              </div>
            </div>
    
      </nav>
  <?php
  }
      
  else
  {
  ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="font-size: 10px;">
        <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; margin-right: 30px;" ><i class="fas fa-globe-asia mr-1"></i>DAILY REPORTS
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD REPAIR REPORTS</a>
                  <a class="dropdown-item" href="lbpm-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD PREVENTIVE MAINTENANCE</a>
                  <a class="dropdown-item" href="lbim-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i>LOAD BOARD ISSUE MONITORING</a>
                  <a class="dropdown-item" href="tester-repair-report-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER REPAIR REPORT</a>
                  <a class="dropdown-item" href="tester-preventive-maintenance-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER PREVENTIVE MAINTENANCE REPORT</a>
                  <a class="dropdown-item" href="tester-in-house-module-repair-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER IN-HOUSE MODULE REPAIR REPORT</a>
                  <a class="dropdown-item" href="tester-defective-index.php" style="font-size: 12px;"><i class="fas fa-memory mr-1"></i>TESTER DEFECTIVE BOARD/PARTS</a>
                  <a class="dropdown-item" href="sl-index.php" style="font-size: 12px;"><i class="fas fa-tachometer-alt mr-1"></i>SPEEDLOSS REPORTS</a>
                  <a class="dropdown-item" href="bib-index.php" style="font-size: 12px;"><i class="fas fa-burn mr-1"></i>BURN-IN BOARD REPORTS</a>
                  <a class="dropdown-item" href="ext-index.php" style="font-size: 12px;"><i class="fas fa-external-link-alt mr-1"></i>EXTERNAL BOARD REPAIR REPORTS</a>
                  <a class="dropdown-item" href="dmat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>DAILY MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="wmat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>WEEKLY MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="hcat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>HARDWARE C-SHOP ACTION TRACKER</a>
                  <a class="dropdown-item" href="emat-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>EQUIPMENT STAFF MEETING ACTION TRACKER</a>
                  <a class="dropdown-item" href="ee-index.php" style="font-size: 12px;"><i class="fas fa-chart-line mr-1"></i>EE REPORTS</a>
                  <a class="dropdown-item" href="lsg-index.php" style="font-size: 12px;"><i class="fas fa-truck-loading mr-1"></i> LSG REPAIR REPORTS</a>
                  <a class="dropdown-item" href="m3-index.php" style="font-size: 12px;"><i class="fas fa-satellite-dish mr-1"></i>ONLINE SETUP REQUEST</a>
                  <a class="dropdown-item" href="setup-index.php" style="font-size: 12px;"><i class="fas fa-stream mr-1"></i>SETUP REPORT</a>             
                </div>
                </div>               
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      </div>
        <div class="nav-item dropdown" style="float:right; margin-right: 40px;">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
            WELCOME
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" style="font-size: 12px;" href="http://10.153.239.120"><i class="fas fa-globe-asia mr-1"></i>PROMIS</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="font-size: 12px;" href="login_page.php"><i class="fas fa-sign-in-alt mr-1"></i>LOG-IN</a>
          </div>
        </div>

  </nav>

    <?php   
        
  } 
  
  ?>
    
    
    
    
    
    
    
    
    
    
