<?php include "database/db.php";?>

<?php

function sendmail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '', $cc=""){
    $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
    $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

    $headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";

    if ($cc != ""){
        $headers .= "CC: ". $cc ." \r\n";
    }

    return mail($to, $subject, $message, $headers);
}

function get_data_array($result){
        
    $data = array();
    
    if (is_object($result) && !empty($result->num_rows)) {
        while ($row = $result->fetch_assoc()) {
            foreach($row as $col => $value){
                $data[$col] = $value;
            }
        }
        $result->free();
    }
    
    return $data;
    
}

function get_assocArray($result){ 

        $data = array(); 

        if (is_object($result) && !empty($result->num_rows)) { 

            while ($row = $result->fetch_assoc()) { 
                $tempColumns = array(); 
                foreach($row as $col => $value){ 
                    $tempColumns[$col] = $value; 
                } 
                array_push($data, $tempColumns); 
            } 
            $result->free(); 
        }
        return $data; 
}


function sanitizeInput($input){ 
	global $connection;
    $inputTemp = ""; 

    $inputTemp = htmlspecialchars($input, ENT_QUOTES); 
    $inputTemp = filter_var($inputTemp, FILTER_SANITIZE_STRING); 
    $inputTemp = $connection->real_escape_string($inputTemp); 

    return $inputTemp; 
}


function createDR(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $repair_s = sanitizeInput($_POST['repair_s']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO dailyreports(tester,handler,fam_name,lb_name,pfd,fwa,action_d,repair_s,pre_vac,dt,stat,submitter,LB_id,sub_ffId) VALUES ('$tester' ,'$handler' ,'$fam_name', '$lb_name' , '$pfd' , '$fwa' , '$action_d' , '$repair_s' , '$pre_vac' , '$dt' , '$stat', '$submitter', '$lb_id', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM dailyreports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY dr_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/load_board/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO lb_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='index.php';
        </script>");
	}
}

function createLBPM(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        $pm_date = sanitizeInput($_POST['pm_date']);
        $pm_due = sanitizeInput($_POST['pm_due']);
        
       
              
        $query = "INSERT INTO lbpm_reports(tester,handler,fam_name,lb_name,pfd,fwa,action_d,pre_vac,dt,submitter,LB_id,sub_ffId,pm_date,pm_due) VALUES ('$tester' ,'$handler' ,'$fam_name', '$lb_name' , '$pfd' , '$fwa' , '$action_d' , '$pre_vac' , '$dt' , '$submitter', '$lb_id', '$sub_ffId', '$pm_date', '$pm_due')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM lbpm_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/lbpm_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {


                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO lbpm_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='lbpm-index.php';
        </script>");
	}
}

function createLBIM(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO lbim(tester,handler,fam_name,lb_name,pfd,fwa,action_d,pre_vac,dt,stat,submitter,LB_id,sub_ffId) VALUES ('$tester' ,'$handler' ,'$fam_name', '$lb_name' , '$pfd' , '$fwa' , '$action_d' , '$pre_vac' , '$dt' , '$stat', '$submitter', '$lb_id', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM lbim WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY dr_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/lbim_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO lbim_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='lbim-index.php';
        </script>");
	}
}



function createSL(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $tester_pf = sanitizeInput($_POST['tester_pf']);
        $handler = sanitizeInput($_POST['handler']);
        $handler_pf = sanitizeInput($_POST['handler_pf']); 
        $device = sanitizeInput($_POST['device']);
        $sl_status_owner = sanitizeInput($_POST['sl_status_owner']);
        $status_owner = sanitizeInput($_POST['status_owner']);
        $duration = sanitizeInput($_POST['duration']);
        $problem = sanitizeInput($_POST['problem']);
        $act_done = sanitizeInput($_POST['act_done']);
        $sl_commit = sanitizeInput($_POST['sl_commit']);
        $sl_status = sanitizeInput($_POST['sl_status']);
        $remarks = sanitizeInput($_POST['remarks']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        $who_1 = sanitizeInput($_POST['who_1']);
              
        $query = "INSERT INTO speedloss(tester_id,tester_pf,handler,handler_pf,device,sl_status_owner,status_owner,duration,problem,act_done,sl_commit,sl_status,sl_remarks,submitter,sub_ffId,who_1) VALUES ('$tester' ,'$tester_pf' ,'$handler', '$handler_pf' , '$device' , '$sl_status_owner' , '$status_owner' , '$duration' , '$problem' , '$act_done', '$sl_commit', '$sl_status', '$remarks', '$submitter', '$sub_ffId', '$who_1')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM speedloss WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY sl_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/speedloss/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO sl_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='sl-index.php';
        </script>");
	}
}

function createBib(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$burn_in_no = sanitizeInput($_POST['burn_in_no']);
        $family_name = sanitizeInput($_POST['family_name']);
        $bib_id = sanitizeInput($_POST['bib_id']);
        $bib_name = sanitizeInput($_POST['bib_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $act_done = sanitizeInput($_POST['act_done']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $br_status = sanitizeInput($_POST['br_status']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        $qty_replaced = sanitizeInput($_POST['qty']);
              
        $query = "INSERT INTO burnin_report(burn_in_no,family_name,bib_id,bib_name,pfd,fwa,act_done,pre_vac,dt,br_status,who,sub_ffId,qty_replaced) VALUES ('$burn_in_no' ,'$family_name' ,'$bib_id', '$bib_name' , '$pfd' , '$fwa' , '$act_done' , '$pre_vac' , '$dt' , '$br_status', '$submitter', '$sub_ffId', '$qty_replaced')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM burnin_report WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY br_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/burn_in/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO bib_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='bib-index.php';
        </script>");
	}
}

function createExt(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$item_desc = sanitizeInput($_POST['item_desc']);
        $serial_id = sanitizeInput($_POST['serial_id']);
        $req_per = sanitizeInput($_POST['req_per']);
        $req_dept = sanitizeInput($_POST['req_dept']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $act_done = sanitizeInput($_POST['act_done']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dtr = sanitizeInput($_POST['dtr']);
        $dte = sanitizeInput($_POST['dte']);
        $dt = sanitizeInput($_POST['dt']);
        $ex_status = sanitizeInput($_POST['ex_status']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
              
        $query = "INSERT INTO ext_report(item_desc,serial_id,req_per,req_dept,pfd,act_done,pre_vac,dtr,dte,dt,ex_status,who,sub_ffId) VALUES ('$item_desc' ,'$serial_id' ,'$req_per', '$req_dept' , '$pfd' , '$act_done' , '$pre_vac' , '$dtr', '$dte', '$dt' , '$ex_status', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM ext_report WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY ex_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/external_rep/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO ext_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='ext-index.php';
        </script>");
	}
}

function createWMAT(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 
        $act_date = sanitizeInput($_POST['act_date']);
        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
        $query = "INSERT INTO wmat(desc_act_item,responsible,commit_closure,act_date,stat,rem,duration,submitter,sub_ffId) VALUES ('$desc_act_item' ,'$responsible', '$commit_closure' , '$act_date' , '$stat' , '$rem' , '$duration', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM wmat WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY entry_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/wmat_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO wmat_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        sendmail_utf8($send['email'], "REPORT SYSTEM", "apps.donotreply@onsemi.com", "Pending Task from ". $s['firstName'] ." ". $s['lastName'], "</b> You have a new task. Please see status on your form.</p> <p>Please use Google Chrome or Mozilla FireFox <a href='http://phsm01ws014.ad.onsemi.com/fthrdr/wmat-index.php'>VIEW FORM</a></p><br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> REPORT SYSTEM", $s['email']);    

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='wmat-index.php';
        </script>");
	}
}

function createHCAT(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 
        $act_date = sanitizeInput($_POST['act_date']);
        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
        $query = "INSERT INTO hcat(desc_act_item,responsible,commit_closure,act_date,stat,rem,duration,submitter,sub_ffId) VALUES ('$desc_act_item' ,'$responsible', '$commit_closure' , '$act_date' , '$stat' , '$rem' , '$duration', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM hcat WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY entry_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/hcat_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO hcat_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        sendmail_utf8($send['email'], "REPORT SYSTEM", "apps.donotreply@onsemi.com", "Pending Task from ". $s['firstName'] ." ". $s['lastName'], "</b> You have a new task. Please see status on your form.</p> <p>Please use Google Chrome or Mozilla FireFox <a href='http://phsm01ws014.ad.onsemi.com/fthrdr/dr_update.php?id=". $ir['id'] ."&datatype=hcat'>VIEW FORM</a></p><br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> REPORT SYSTEM", $s['email']);    

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='hcat-index.php';
        </script>");
	}
}

function createEE(){
	global $connection;
    global $userconnect;

        $sql ="SELECT * FROM employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		
        $activity_done = sanitizeInput($_POST['activity_done']);
        $stat = sanitizeInput($_POST['stat']);
        $sub_ffId = $_SESSION['rs_username'];
        
        $query = "INSERT INTO ee_reports(activity_done,stat,sub_ffId) VALUES ('$activity_done' ,'$stat', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			};
             
        $itemquery = "SELECT * FROM ee_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY submit_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/er_uploads/";


                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');


                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";

                } else {

                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO er_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='ee-index.php';
        </script>");
	}
}

function createDMAT(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 

        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
        $query = "INSERT INTO dmat(desc_act_item,responsible,commit_closure,act_date,stat,rem,duration,submitter,sub_ffId) VALUES ('$desc_act_item' ,'$responsible', '$commit_closure' , '$act_date' , '$stat' , '$rem' , '$duration', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM dmat WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY entry_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/dmat_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO dmat_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        sendmail_utf8($send['email'], "REPORT SYSTEM", "apps.donotreply@onsemi.com", "Pending Task from ". $s['firstName'] ." ". $s['lastName'], "</b> You have a new task. Please see status on your form.</p> <p>Please use Google Chrome or Mozilla FireFox <a href='http://phsm01ws014.ad.onsemi.com/fthrdr/dmat-index.php'>VIEW FORM</a></p><br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> REPORT SYSTEM", $s['email']);    

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='dmat-index.php';
        </script>");
	}
}

function createEMAT(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 

        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
        $query = "INSERT INTO emat(desc_act_item,responsible,commit_closure,act_date,stat,rem,duration,submitter,sub_ffId) VALUES ('$desc_act_item' ,'$responsible', '$commit_closure' , '$act_date' , '$stat' , '$rem' , '$duration', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM emat WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY entry_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/emat_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO emat_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        sendmail_utf8($send['email'], "REPORT SYSTEM", "apps.donotreply@onsemi.com", "Pending Task from ". $s['firstName'] ." ". $s['lastName'], "</b> You have a new task. Please see status on your form.</p> <p>Please use Google Chrome or Mozilla FireFox <a href='http://phsm01ws014.ad.onsemi.com/fthrdr/emat-index.php'>VIEW FORM</a></p><br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> REPORT SYSTEM", $s['email']);    

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='emat-index.php';
        </script>");
	}
}


function createM3(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		
        $handler_CS = sanitizeInput($_POST['handler-cs']);
        $handler_platform_CS = sanitizeInput($_POST['handler-platform-cs']);
        $tester_CS = sanitizeInput($_POST['tester-cs']);
        $tester_platform_CS = sanitizeInput($_POST['tester-platform-cs']); 
        $family_CS = sanitizeInput($_POST['family-name-cs']);
        $lb_name_CS = sanitizeInput($_POST['loadboard-name-cs']);
        $lb_ID_CS = sanitizeInput($_POST['loadboard-id-cs']);
        $package_CS = sanitizeInput($_POST['package-cs']);
        $change_program_TS = sanitizeInput($_POST['change-program-ts']);
        $change_center_board_TS = sanitizeInput($_POST['change-center-board-ts']);
        $change_load_board_TS = sanitizeInput($_POST['change-load-board-ts']);
        $change_package_TS = sanitizeInput($_POST['change-package-ts']);
        $change_kit_TS = sanitizeInput($_POST['change-kit-ts']);
        $tester_transfer_TS = sanitizeInput($_POST['tester-transfer-ts']);
        $handler_tester_TS = sanitizeInput($_POST['handler-tester-ts']);
        $change_handler_TS = sanitizeInput($_POST['change-handler-ts']);
        $change_tester_TS = sanitizeInput($_POST['change-tester-ts']);
        $handler_PS = sanitizeInput($_POST['handler-PS']);
        $handler_platform_PS = sanitizeInput($_POST['handler-platform-PS']);
        $tester_PS = sanitizeInput($_POST['tester-PS']);
        $tester_platform_PS = sanitizeInput($_POST['tester-platform-PS']);
        $family_PS = sanitizeInput($_POST['family-name-PS']);
        $lb_name_PS = sanitizeInput($_POST['loadboard-name-PS']);
        $lb_ID_PS = sanitizeInput($_POST['loadboard-ID-PS']);
        $package_PS = sanitizeInput($_POST['package-PS']);
        $EDTM_PS = sanitizeInput($_POST['edtm-PS']);
        $requested_by_PS = sanitizeInput($_POST['requested-by-PS']);
        $group_PS = sanitizeInput($_POST['group-PS']);
        $shift_PS = sanitizeInput($_POST['shift-PS']);
        $requested_date_PS = sanitizeInput($_POST['requested-date-PS']);
        $expected_date_of_setup_PS = sanitizeInput($_POST['expected-date-of-setup-PS']);
        $unscheduled_setup_PS = sanitizeInput($_POST['unscheduled-setup-PS']);
        $reason_for_unscheduled_setup_PS = sanitizeInput($_POST['reason-for-unscheduled-setup-PS']);
        $lsg_approver_PS = sanitizeInput($_POST['lsg-approver-PS']);
        $remarks_PS = sanitizeInput($_POST['remarks-PS']);
        $change_kit_SM = sanitizeInput($_POST['change-kit-sm']);
        $separator_plate_SM = sanitizeInput($_POST['separator-plate-sm']);
        $unloader_kit_SM = sanitizeInput($_POST['unloader-kit-sm']);
        $work_press_SM = sanitizeInput($_POST['work-press-sm']);
        $baseplate_SM = sanitizeInput($_POST['baseplate-sm']);
        $socket_jig_SM = sanitizeInput($_POST['socket-jig-sm']);
        $power_supply_SM = sanitizeInput($_POST['power-supply-sm']);
        $oscilloscope_SM = sanitizeInput($_POST['oscilloscope-sm']);
        $socket_SM = sanitizeInput($_POST['socket-sm']);
        $others_SM = sanitizeInput($_POST['others-sm']);

        $status = sanitizeInput($_POST['status']);
        $submitter_remarks = sanitizeInput($_POST['submitter-remarks']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];

        if ($status == "FOR PREPARATION")
        {
            $query_submitter_remarks = "for_preparation_remarks";
            $query_submitter = "for_preparation_updater";
            $query_date_update ="for_preparation_date";
        }
        else if ($status == "ON GOING PREPARATION")
        {
            $query_submitter_remarks = "ongoing_preparation_remarks";
            $query_submitter = "ongoing_preparation_updater";
            $query_date_update ="ongoing_preparation_date";
        }
        else if ($status == "FOR PICK UP FROM CENTRAL SHOP")
        {
            $query_submitter_remarks = "for_pickup_cshop_remarks";
            $query_submitter = "for_pickup_cshop_updater";
            $query_date_update ="for_pickup_cshop_date";
            
        }
        else if ($status == "READY FOR BUY OFF")
        {
            $query_submitter_remarks = "ready_for_buyoff_remarks";
            $query_submitter = "ready_for_buyoff_updater";
            $query_date_update ="ready_for_buyoff_date";
        }
        else if ($status == "READY FOR PICK UP")
        {
            $query_submitter_remarks = "ready_for_pickup_remarks";
            $query_submitter = "ready_for_pickup_updater";
            $query_date_update ="ready_for_pickup_date";
        }
        else if ($status == "RELEASED")
        {
            $query_submitter_remarks = "released_remarks";
            $query_submitter = "released_updater";
            $query_date_update ="released_date";
        }
        
        $query = "INSERT INTO m3_reports(handler_CS,handler_platform_CS,tester_CS,tester_platform_CS,family_CS,lb_name_CS,lb_ID_CS,package_CS,".
        "change_program_TS,change_center_board_TS,change_load_board_TS,change_package_TS,change_kit_TS,tester_transfer_TS,handler_tester_TS,".
        "change_handler_TS,change_tester_TS,handler_PS,handler_platform_PS,tester_PS,tester_platform_PS,family_PS,lb_name_PS,lb_ID_PS,".
        "package_PS,EDTM_PS,requested_by_PS,group_PS,shift_PS,requested_date_PS,expected_date_of_setup_PS,unscheduled_setup_PS,".
        "reason_for_unscheduled_setup_PS,lsg_approver_PS,remarks_PS,change_kit_SM,separator_plate_SM,unloader_kit_SM,work_press_SM,".
        "baseplate_SM,socket_jig_SM,power_supply_SM,oscilloscope_SM,socket_SM,others_SM,status,submitter_remarks,submitter,sub_ffId,$query_submitter_remarks,$query_submitter,$query_date_update)".
        " VALUES ('$handler_CS' ,'$handler_platform_CS', '$tester_CS' , '$tester_platform_CS' , '$family_CS' , '$lb_name_CS' , '$lb_ID_CS',".
        " '$package_CS', ' $change_program_TS', '$change_center_board_TS', '$change_load_board_TS', '$change_package_TS', '$change_kit_TS',".
        " '$tester_transfer_TS', '$handler_tester_TS', '$change_handler_TS', '$change_tester_TS', '$handler_PS', '$handler_platform_PS',".
        " '$tester_PS', '$tester_platform_PS', '$family_PS', '$lb_name_PS', '$lb_ID_PS', '$package_PS', '$EDTM_PS', '$requested_by_PS',".
        " '$group_PS', '$shift_PS', '$requested_date_PS', '$expected_date_of_setup_PS', '$unscheduled_setup_PS', '$reason_for_unscheduled_setup_PS',".
        " '$lsg_approver_PS', '$remarks_PS', '$change_kit_SM', '$separator_plate_SM', '$unloader_kit_SM', '$work_press_SM', '$baseplate_SM',".
        " '$socket_jig_SM', '$power_supply_SM', '$oscilloscope_SM', '$socket_SM', '$others_SM', '$status', '$submitter_remarks','$submitter', '$sub_ffId','$submitter_remarks','$submitter',CURRENT_TIMESTAMP)";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM m3_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY entry_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/m3_uploads/";

    //            basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
    //            if (file_exists($target_file)) {
    //                echo "Sorry, file already exists.";
    //                $uploadOk = 0;
    //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx' , 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO m3_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        $sql = "SELECT * FROM employeeinfos WHERE cidNum =". $ir['responsible'];    
        $query = $userconnect->query($sql);
        $send = get_data_array($query);

        // sendmail_utf8($send['email'], "REPORT SYSTEM", "apps.donotreply@onsemi.com", "Pending Task from ". $s['firstName'] ." ". $s['lastName'], "</b> You have a new task. Please see status on your form.</p> <p>Please use Google Chrome or Mozilla FireFox <a href='http://phsm01ws014.ad.onsemi.com/fthrdr/dmat-index.php'>VIEW FORM</a></p><br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> REPORT SYSTEM", $s['email']);    

        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='m3-index.php';
        </script>");
	}
}

function createTRR(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO tester_repair_reports(tester,platform,fam_name,problem,fwa,action_d,pre_vac,dt,stat,submitter,sub_ffId) VALUES ('$tester' ,'$platform' ,'$fam_name', '$pfd' , '$fwa' , '$action_d' , '$pre_vac' , '$dt' , '$stat', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM tester_repair_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/tester_repair_uploads/";

                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip', 's', 'S' ,'asc');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO tester_repair_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='tester-repair-report-index.php';
        </script>");
	}
}

function createTPM(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $pm_findings = sanitizeInput($_POST['pm_findings']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $remain_defective_parts = sanitizeInput($_POST['remain-defective-parts']);
        $dt = sanitizeInput($_POST['dt']);
        $diag_data_logs = sanitizeInput($_POST['diag-data-logs']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO tester_preventive_maintenance_reports(tester,platform,pm_findings,action_d,pre_vac,remain_defective_parts,dt,diag_data_logs,stat,submitter,sub_ffId) VALUES ('$tester' ,'$platform' ,'$pm_findings', '$action_d' , '$pre_vac' , '$remain_defective_parts' , '$dt' , '$diag_data_logs' , '$stat', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM tester_preventive_maintenance_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/tester_preventive_maintenance_uploads/";

                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip', 's', 'S' ,'asc');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO tester_preventive_maintenance_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='tester-preventive-maintenance-index.php';
        </script>");
	}
}

function createTIHM(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $part_name = sanitizeInput($_POST['part_name']);
        $part_number = sanitizeInput($_POST['part_number']);
        $serial_number = sanitizeInput($_POST['serial_number']);
        $problem = sanitizeInput($_POST['problem']);
        $action_d = sanitizeInput($_POST['action_d']);
        $diag_data_logs = sanitizeInput($_POST['diag_data_logs']);
        $location = sanitizeInput($_POST['location']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO tester_in_house_module_reports(tester,platform,part_name,part_number,serial_number,problem,action_d,diag_data_logs,location,stat,submitter,sub_ffId) VALUES ('$tester' ,'$platform' ,'$part_name', '$part_number' , '$serial_number' , '$problem' , '$action_d' , '$diag_data_logs' , '$location' ,  '$stat', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM tester_in_house_module_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/tester_in_house_module_uploads/";

                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip', 's', 'S' ,'asc');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO tester_in_house_module_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='tester-in-house-module-repair-index.php';
        </script>");
	}
}

function createTDR(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $part_name = sanitizeInput($_POST['part_name']);
        $part_number = sanitizeInput($_POST['part_number']);
        $serial_number = sanitizeInput($_POST['serial_number']);
        $problem = sanitizeInput($_POST['problem']);
        $action_d = sanitizeInput($_POST['action_d']);
        $diag_data_logs = sanitizeInput($_POST['diag_data_logs']);
        $location = sanitizeInput($_POST['location']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO tester_defective_reports(tester,platform,part_name,part_number,serial_number,problem,action_d,diag_data_logs,location,stat,submitter,sub_ffId) VALUES ('$tester' ,'$platform' ,'$part_name', '$part_number' , '$serial_number' , '$problem' , '$action_d' , '$diag_data_logs' , '$location' ,  '$stat', '$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM tester_defective_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/tester_defective_uploads/";

                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip', 's', 'S' ,'asc');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_create.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO tester_defective_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='tester-defective-index.php';
        </script>");
	}
}

function CreateLSGRR(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $repair_s = sanitizeInput($_POST['repair_s']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO lsg_reports(tester,handler,fam_name,lb_name,pfd,fwa,action_d,repair_s,pre_vac,dt,stat,submitter,LB_id,sub_ffId) VALUES ('$tester' ,'$handler' ,'$fam_name', '$lb_name' , '$pfd' , '$fwa' , '$action_d' , '$repair_s' , '$pre_vac' , '$dt' , '$stat', '$submitter', '$lb_id', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM lsg_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY dr_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/lsg_uploads/";

                //basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
                //            if (file_exists($target_file)) {
                //                echo "Sorry, file already exists.";
                //                $uploadOk = 0;
                //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO lsg_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='lsg-index.php';
        </script>");
	}
}

function CreateSR(){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
	if (isset($_POST['submit'])){
		//POST is used when sending information from a form//
		$tester = sanitizeInput($_POST['tester']);//
        $handler = sanitizeInput($_POST['handler']);//
        $package = sanitizeInput($_POST['package']);
        $product_name = sanitizeInput($_POST['product-name']);
        $setup_code = sanitizeInput($_POST['setup-code']);
        $ie_time = sanitizeInput($_POST['ie-time']);
        $actual_setup_time = sanitizeInput($_POST['actual-setup-time']);
        $gap = sanitizeInput($_POST['gap']);
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $category = sanitizeInput($_POST['category']);
        $stat = sanitizeInput($_POST['stat']);
        $group = sanitizeInput($_POST['group']);
        $remarks = sanitizeInput($_POST['remarks']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
        
              
        $query = "INSERT INTO setup_reports(tester,handler,package,fam_name,setup_code,ie_time,actual_setup_time,gap,pfd,fwa,action_d,category,groups,stat,remarks,submitter,sub_ffId)
         VALUES ('$tester','$handler','$package','$product_name','$setup_code','$ie_time','$actual_setup_time','$gap','$pfd','$fwa','$action_d','$category', '$group','$stat','$remarks','$submitter', '$sub_ffId')";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
				}
             
        $itemquery = "SELECT * FROM setup_reports WHERE sub_ffId ='". $_SESSION['rs_username'] . "' ORDER BY dr_date DESC LIMIT 1";
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
            for ($i=0; $i<$total; $i++){

                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/setup_uploads/";

                //basename($_FILES["fileToUpload"]["name"][$i])
                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if file already exists
                //            if (file_exists($target_file)) {
                //                echo "Sorry, file already exists.";
                //                $uploadOk = 0;
                //            }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'ppt', 'txt', 'xls', 'msg', 'txt', 'zip');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='create-form.php';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";

                        }
                    }
                $iteminsert = "INSERT INTO setup_uploads (item_name,itemId) VALUES ('$newfilename',$itemNo)";
                $itemeun = $connection->query($iteminsert);
                }
    }
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Created');
        window.location.href='setup-index.php';
        </script>");
	}
}

//function createData(){
//	global $connection;
//	if (isset($_POST['submit'])){
//		//POST is used when sending information from a form//
//		$username = sanitizeInput($_POST['username']);
//		$password = sanitizeInput($_POST['password']);
//
//		//accepts string special code
//		$username = mysqli_real_escape_string($connection, $username);
//		$password = mysqli_real_escape_string($connection, $password);
//		
//		//Password Encryption
//		$hashFormat = "$2y$10$";
//		$salt = "iusesomecrazystrings22";
//		$hashF_and_salt = $hashFormat . $salt;
//		$password = crypt($password, $hashF_and_salt);	
//
//		if(!$username || !$password){
//			$message = "DATA ERROR PLEASE TRY AGAIN";
//			echo "<script type='text/javascript'>alert('$message');</script>";
//			die(mysql_error());
//		}						
//
//        $query = "INSERT INTO users(username,password) VALUES ('$username', '$password')";
//
//        $result = mysqli_query($connection, $query);
//	       if(!$result){
//		      die(mysqli_error());
//			
//				}
//	       else {
//		  echo "SUCCESS";
//		}
//	}
//}


//$query pulls data information from the database//
//function getAllDR() {
//	global $connection;
//	$query = "SELECT * FROM dailyreport";
//	$result = mysqli_query($connection, $query);
//	if(!$result) {
//		die('Query Failed' . mysqli_error());
//				}
//	//research how to show all of the ID, NAME AND PASS
//	while($row = mysqli_fetch_assoc($result)){
//		$id = $row['dr_date'];
//    //$username = $row['username'];
//	echo "<option value ='$date'>$date</option>";
//		}
//		}



function showRecentDR(){
    
    $query = "SELECT * FROM dailyreports";
    
        
}


function updateCurrentData($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $repair_s = sanitizeInput($_POST['repair_s']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = sanitizeInput($_POST['submitter']);
        
        
		$query = "UPDATE dailyreports SET tester = '$tester', handler = '$handler',fam_name = '$fam_name', lb_name = '$lb_name', pfd = '$pfd', fwa='$fwa', action_d='$action_d', repair_s='$repair_s' , pre_vac='$pre_vac', dt='$dt', stat='$stat', LB_id='$lb_id', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateTRR($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $problem = sanitizeInput($_POST['problem']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = sanitizeInput($_POST['submitter']);
        
        
		$query = "UPDATE tester_repair_reports SET tester = '$tester', platform = '$platform',fam_name = '$fam_name',problem = '$problem', fwa='$fwa', action_d='$action_d', pre_vac='$pre_vac', dt='$dt', stat='$stat', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateTPM($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $pm_findings = sanitizeInput($_POST['pm_findings']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $remain_defective_parts = sanitizeInput($_POST['remain-defective-parts']);
        $dt = sanitizeInput($_POST['dt']);
        $diag_data_logs = sanitizeInput($_POST['diag-data-logs']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = sanitizeInput($_POST['submitter']);
        
        
		$query = "UPDATE tester_preventive_maintenance_reports SET tester = '$tester', platform = '$platform', pm_findings = '$pm_findings',action_d = '$action_d', pre_vac='$pre_vac', remain_defective_parts='$remain_defective_parts', dt='$dt', diag_data_logs='$diag_data_logs', stat='$stat', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateTIHM($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $part_name = sanitizeInput($_POST['part_name']);
        $part_number = sanitizeInput($_POST['part_number']);
        $serial_number = sanitizeInput($_POST['serial_number']);
        $problem = sanitizeInput($_POST['problem']);
        $action_d = sanitizeInput($_POST['action_d']);
        $diag_data_logs = sanitizeInput($_POST['diag_data_logs']);
        $location = sanitizeInput($_POST['location']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = sanitizeInput($_POST['submitter']);
   
        
        
		$query = "UPDATE tester_in_house_module_reports SET tester = '$tester', platform = '$platform', part_name = '$part_name',part_number = '$part_number', serial_number='$serial_number', problem='$problem', action_d='$action_d', diag_data_logs = '$diag_data_logs' , location='$location', stat='$stat', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateTDR($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $platform = sanitizeInput($_POST['platform']);
        $part_name = sanitizeInput($_POST['part_name']);
        $part_number = sanitizeInput($_POST['part_number']);
        $serial_number = sanitizeInput($_POST['serial_number']);
        $problem = sanitizeInput($_POST['problem']);
        $action_d = sanitizeInput($_POST['action_d']);
        $diag_data_logs = sanitizeInput($_POST['diag_data_logs']);
        $location = sanitizeInput($_POST['location']);
        $stat = sanitizeInput($_POST['stat']);
        $submitter = sanitizeInput($_POST['submitter']);
   
        
        
		$query = "UPDATE tester_defective_reports SET tester = '$tester', platform = '$platform', part_name = '$part_name',part_number = '$part_number', serial_number='$serial_number', problem='$problem', action_d='$action_d', diag_data_logs = '$diag_data_logs' , location='$location', stat='$stat', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateCurrentData_LBPM($dr_id){
	global $connection;
    global $userconnect;
    $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
    $result = $userconnect-> query($sql);
    $user = get_data_array($result);
	if (isset($_POST['submit_p'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
        
        $tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = 1;
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = sanitizeInput($_POST['submitter']);
        $updater = $user['firstName']. " " . $user['lastName'];
        $pm_date = sanitizeInput($_POST['pm_date']);
        $pm_due = sanitizeInput($_POST['pm_due']);
        if ($stat == 1){
            
        $name_update = ",updater = '$updater'";
        $updater_ffId = ", updater_ffId = '". $_SESSION['rs_username'] ."'";
        }
         if ($stat == 2){
            
        $name_update = ",finalizer = '$updater'";
        $updater_ffId = ",finalizer_ffId = '". $_SESSION['rs_username'] ."'";
            
        }
        $ftf = sanitizeInput($_POST['ftf']);
        $prob_des = sanitizeInput($_POST['prob_des']);
        $ad = sanitizeInput($_POST['ad']);
        $rc = sanitizeInput($_POST['rc']);
        
        
		$query = "UPDATE lbpm_reports SET tester = '$tester', handler = '$handler',fam_name = '$fam_name', lb_name = '$lb_name', pfd = '$pfd', action_d='$action_d', pre_vac='$pre_vac', dt='$dt', stat='$stat', LB_id='$lb_id', submitter ='$submitter' $name_update $updater_ffId, ftf = '$ftf', prob_des = '$prob_des', ad = '$ad', rc = '$rc', pm_date = '$pm_date', pm_due = '$pm_due' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	    if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
            
        /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM lbpm_reports WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                        
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
            
                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/lbpm_uploads/";


                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_update.php?id=". $dr_id ."';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_update.php?id=". $dr_id ."';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";
                        

                        }
                    }
                $iteminsert = "INSERT INTO lbpm_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
                $itemeun = $connection->query($iteminsert);
            }

        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (isset($_POST['submit_f'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
        
        $tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = 2;
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = sanitizeInput($_POST['submitter']);
        $updater = $user['firstName']. " " . $user['lastName']; 
        $pm_date = sanitizeInput($_POST['pm_date']);
        $pm_due = sanitizeInput($_POST['pm_due']);
        if ($stat == 2){
            
        $name_update = ",updater = '$updater'";
        $updater_ffId = ", updater_ffId = '". $_SESSION['rs_username'] ."'";
        }
        
        $ftf = sanitizeInput($_POST['ftf']);
        $prob_des = sanitizeInput($_POST['prob_des']);
        $ad = sanitizeInput($_POST['ad']);
        $rc = sanitizeInput($_POST['rc']);
        
        
		$query = "UPDATE lbpm_reports SET tester = '$tester', handler = '$handler',fam_name = '$fam_name', lb_name = '$lb_name', pfd = '$pfd', action_d='$action_d', pre_vac='$pre_vac', dt='$dt', stat='$stat', LB_id='$lb_id', submitter ='$submitter' $name_update $updater_ffId, ftf = '$ftf', prob_des = '$prob_des', ad = '$ad', rc = '$rc', pm_date = '$pm_date', pm_due = '$pm_due' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
    
    
    
     /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM lbpm_reports WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                        
        $total = count($_FILES["fileToUpload"]["name"]);
        
        
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
            
                $itemName = ($_FILES["fileToUpload"]["name"][$i]);
                $itemNo = $ir['id'];


                $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


                $target_dir = "uploads/lbpm_uploads/";


                $target_file = $target_dir . $newfilename;

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
                if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File is too large, Returning to Create Form');
                            window.location.href='dr_update.php?id=". $dr_id ."';
                            </script>");
                    $uploadOk = 0;
                }

                $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

                // Allow certain file formats
                if(!in_array($imageFileType."", $validExtensions)) {

                    echo ("<script LANGUAGE='JavaScript'>
                            window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                            window.location.href='dr_update.php?id=". $dr_id ."';
                            </script>");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {




                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

    //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {

                        echo $_FILES['fileToUpload']['error'][$i];
                        echo "Sorry, there was an error uploading your file.";
                        

                        }
                    }
                $iteminsert = "INSERT INTO lbpm_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
                $itemeun = $connection->query($iteminsert);
            }

        }
    }
}
function updateCurrentData_LBIM($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = sanitizeInput($_POST['submitter']);
        
        
		$query = "UPDATE lbim SET tester = '$tester', handler = '$handler',fam_name = '$fam_name', lb_name = '$lb_name', pfd = '$pfd', fwa='$fwa', action_d='$action_d', pre_vac='$pre_vac', dt='$dt', stat='$stat', LB_id='$lb_id', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}
function updateCurrentData_SL($dr_id){
	global $connection;
    global $userconnect;
	if (isset($_POST['submit'])){
        
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $tester_pf = sanitizeInput($_POST['tester_pf']);
        $handler = sanitizeInput($_POST['handler']);
        $handler_pf = sanitizeInput($_POST['handler_pf']); 
        $device = sanitizeInput($_POST['device']);
        $sl_status_owner = sanitizeInput($_POST['sl_status_owner']);
        $status_owner = sanitizeInput($_POST['status_owner']);
        $duration = sanitizeInput($_POST['duration']);
        $problem = sanitizeInput($_POST['problem']);
        $act_done = sanitizeInput($_POST['act_done']);
        $sl_commit = sanitizeInput($_POST['sl_commit']);
        $sl_status = sanitizeInput($_POST['sl_status']);
        $remarks = sanitizeInput($_POST['remarks']);
        $who_2 = $s['firstName']. " " .$s['lastName'];
        
		echo $query = "UPDATE speedloss SET tester_id = '$tester', tester_pf = '$tester_pf',handler = '$handler', handler_pf = '$handler_pf', device = '$device', sl_status_owner='$sl_status_owner', status_owner='$status_owner', duration='$duration', problem='$problem', act_done='$act_done', sl_commit='$sl_commit', sl_status='$sl_status', sl_remarks='$remarks', who_2='$who_2' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateCurrentBib($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $burn_in_no = sanitizeInput($_POST['burn_in_no']);
        $family_name = sanitizeInput($_POST['family_name']);
        $bib_id = sanitizeInput($_POST['bib_id']);
        $bib_name = sanitizeInput($_POST['bib_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $act_done = sanitizeInput($_POST['act_done']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $br_status = sanitizeInput($_POST['br_status']);
        $who = sanitizeInput($_POST['who']);
        $qty_replaced = sanitizeInput($_POST['qty']);
        
                
		$query = "UPDATE burnin_report SET burn_in_no = '$burn_in_no', family_name = '$family_name',bib_id = '$bib_id', bib_name = '$bib_name', pfd = '$pfd', fwa='$fwa', act_done='$act_done', pre_vac='$pre_vac', dt='$dt', br_status='$br_status', who='$who', qty_replaced = '$qty_replaced' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateCurrentExt($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $item_desc = sanitizeInput($_POST['item_desc']);
        $serial_id = sanitizeInput($_POST['serial_id']);
        $req_per = sanitizeInput($_POST['req_per']);
        $req_dept = sanitizeInput($_POST['req_dept']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $act_done = sanitizeInput($_POST['act_done']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dtr = sanitizeInput($_POST['dtr']);
        $dte = sanitizeInput($_POST['dte']);
        $dt = sanitizeInput($_POST['dt']);
        $ex_status = sanitizeInput($_POST['ex_status']);
         $who = sanitizeInput($_POST['who']);
                
		$query = "UPDATE ext_report SET item_desc = '$item_desc', serial_id = '$serial_id',req_per = '$req_per',req_dept = '$req_dept', pfd = '$pfd', fwa='$fwa', act_done='$act_done', pre_vac='$pre_vac', dtr='$dtr', dte='$dte', dt='$dt', ex_status='$ex_status', who='$who' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateCurrentWMAT($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        $category = sanitizeInput($_POST['category']);
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 
        $act_date = sanitizeInput($_POST['act_date']);
        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
                    
		$query = "UPDATE wmat SET desc_act_item = '$desc_act_item',responsible = '$responsible', commit_closure = '$commit_closure', act_date = '$act_date', stat='$stat', rem='$rem', duration='$duration', update_date = CURRENT_TIMESTAMP
         WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
    	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
      /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM wmat WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                     
        $total = count($_FILES["fileToUpload"]["name"]);
     
     
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
         
             $itemName = ($_FILES["fileToUpload"]["name"][$i]);
             $itemNo = $ir['id'];


             $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


             $target_dir = "uploads/wmat_uploads/";


             $target_file = $target_dir . $newfilename;

             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File is too large, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }

             $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

             // Allow certain file formats
             if(!in_array($imageFileType."", $validExtensions)) {

                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }
             // Check if $uploadOk is set to 0 by an error
             if ($uploadOk == 0) {
                 echo "Sorry, your file was not uploaded.";
             // if everything is ok, try to upload file
             } else {




                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

 //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                 } else {

                     echo $_FILES['fileToUpload']['error'][$i];
                     echo "Sorry, there was an error uploading your file.";
                     

                     }
                 }
             $iteminsert = "INSERT INTO wmat_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
             $itemeun = $connection->query($iteminsert);
         }

     }
     echo ("<script LANGUAGE='JavaScript'>
        window.alert('RECORD UPDATED');
        window.location.href='wmat-index.php';
        </script>");
    }
}

function updateCurrentHCAT($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        $category = sanitizeInput($_POST['category']);
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']); 
        $act_date = sanitizeInput($_POST['act_date']);
        $stat = sanitizeInput($_POST['stat']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
                    
		$query = "UPDATE hcat SET desc_act_item = '$desc_act_item',responsible = '$responsible', commit_closure = '$commit_closure', act_date = '$act_date', stat='$stat', rem='$rem', duration='$duration', update_date = CURRENT_TIMESTAMP
         WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
    	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
      /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM hcat WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                     
        $total = count($_FILES["fileToUpload"]["name"]);
     
     
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
         
             $itemName = ($_FILES["fileToUpload"]["name"][$i]);
             $itemNo = $ir['id'];


             $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


             $target_dir = "uploads/hcat_uploads/";


             $target_file = $target_dir . $newfilename;

             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File is too large, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }

             $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

             // Allow certain file formats
             if(!in_array($imageFileType."", $validExtensions)) {

                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }
             // Check if $uploadOk is set to 0 by an error
             if ($uploadOk == 0) {
                 echo "Sorry, your file was not uploaded.";
             // if everything is ok, try to upload file
             } else {




                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

 //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                 } else {

                     echo $_FILES['fileToUpload']['error'][$i];
                     echo "Sorry, there was an error uploading your file.";
                     

                     }
                 }
             $iteminsert = "INSERT INTO hcat_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
             $itemeun = $connection->query($iteminsert);
         }

     }
     echo ("<script LANGUAGE='JavaScript'>
        window.alert('RECORD UPDATED');
        window.location.href='hcat-index.php';
        </script>");
    }
}

function updateCurrentER($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        $activity_done = sanitizeInput($_POST['activity_done']);
        $stat = sanitizeInput($_POST['stat']);
        $sub_ffId = $_SESSION['rs_username'];
          
		$query = "UPDATE ee_reports SET activity_done = '$activity_done', stat='$stat', update_date = CURRENT_TIMESTAMP, updater = '$sub_ffId' WHERE id = $dr_id ";

		$result = mysqli_query($connection, $query);
    	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
      /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM ee_reports WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                     
        $total = count($_FILES["fileToUpload"]["name"]);
     
     
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
         
             $itemName = ($_FILES["fileToUpload"]["name"][$i]);
             $itemNo = $ir['id'];


             $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


             $target_dir = "uploads/er_uploads/";


             $target_file = $target_dir . $newfilename;

             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File is too large, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }

             $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

             // Allow certain file formats
             if(!in_array($imageFileType."", $validExtensions)) {

                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }
             // Check if $uploadOk is set to 0 by an error
             if ($uploadOk == 0) {
                 echo "Sorry, your file was not uploaded.";
             // if everything is ok, try to upload file
             } else {




                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

 //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                 } else {

                     echo $_FILES['fileToUpload']['error'][$i];
                     echo "Sorry, there was an error uploading your file.";
                     

                     }
                 }
             $iteminsert = "INSERT INTO er_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
             $itemeun = $connection->query($iteminsert);
         }

     }
     echo ("<script LANGUAGE='JavaScript'>
        window.alert('RECORD UPDATED');
        window.location.href='ee-index.php';
        </script>");
    }
}

function updateCurrentDMAT($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        $category = sanitizeInput($_POST['category']);
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']);
        $stat = sanitizeInput($_POST['stat']);
        if ($stat == "CLOSED"){
            $closedDate = 'CURRENT_TIMESTAMP'; 
        }
        else {
            $closedDate = 'null';
        }
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
                    
		$query = "UPDATE dmat SET desc_act_item = '$desc_act_item',responsible = '$responsible', commit_closure = '$commit_closure', act_date =  $closedDate, stat='$stat', rem='$rem', duration='$duration', update_date = CURRENT_TIMESTAMP
         WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
    	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
      /////////////////////////////////////////////UPLOAD FUNCTION/////////////////////////////////////////////////////////////////////////////////////////////            
        $itemquery = "SELECT * FROM dmat WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                     
        $total = count($_FILES["fileToUpload"]["name"]);
     
     
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
         
             $itemName = ($_FILES["fileToUpload"]["name"][$i]);
             $itemNo = $ir['id'];


             $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


             $target_dir = "uploads/dmat_uploads/";


             $target_file = $target_dir . $newfilename;

             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File is too large, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }

             $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

             // Allow certain file formats
             if(!in_array($imageFileType."", $validExtensions)) {

                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }
             // Check if $uploadOk is set to 0 by an error
             if ($uploadOk == 0) {
                 echo "Sorry, your file was not uploaded.";
             // if everything is ok, try to upload file
             } else {




                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

 //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                 } else {

                     echo $_FILES['fileToUpload']['error'][$i];
                     echo "Sorry, there was an error uploading your file.";
                     

                     }
                 }
             $iteminsert = "INSERT INTO dmat_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
             $itemeun = $connection->query($iteminsert);
         }

     }
     echo ("<script LANGUAGE='JavaScript'>
        window.alert('RECORD UPDATED');
        window.location.href='dmat-index.php';
        </script>");
    }
}

function updateCurrentEMAT($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        $category = sanitizeInput($_POST['category']);
        $desc_act_item = sanitizeInput($_POST['desc_act_item']);
        $responsible = sanitizeInput($_POST['responsible']);
        $commit_closure = sanitizeInput($_POST['commit_closure']);
        $stat = sanitizeInput($_POST['stat']);
        if ($stat == "CLOSED"){
            $closedDate = 'CURRENT_TIMESTAMP'; 
        }
        else {
            $closedDate = 'null';
        }
        $action_done = sanitizeInput($_POST['action_done']);
        $rem = sanitizeInput($_POST['rem']);
        $duration = sanitizeInput($_POST['duration']);
                    
		$query = "UPDATE emat SET desc_act_item = '$desc_act_item',responsible = '$responsible', commit_closure = '$commit_closure', act_date =  $closedDate, stat='$stat', action_done = '$action_done', rem='$rem', duration='$duration', update_date = CURRENT_TIMESTAMP
         WHERE id = $dr_id ";
        
		$result = mysqli_query($connection, $query);
    	    if(!$result){
		        die("QUERY FAILED" . mysqli_error($connection));
            }
        //UPLOAD FUNCTION     
        $itemquery = "SELECT * FROM emat WHERE id=". $dr_id;
        $itemresult = $connection-> query($itemquery);
        $ir = get_data_array($itemresult);
                     
        $total = count($_FILES["fileToUpload"]["name"]);
     
     
        if ($_FILES["fileToUpload"]["name"][0] != ""){
        for ($i=0; $i<$total; $i++){
         
             $itemName = ($_FILES["fileToUpload"]["name"][$i]);
             $itemNo = $ir['id'];


             $newfilename = date('dmYHis')."_".str_replace("", "", basename($_FILES["fileToUpload"]["name"][$i]));


             $target_dir = "uploads/emat_uploads/";


             $target_file = $target_dir . $newfilename;

             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

             if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File is too large, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }

             $validExtensions = array('jpg' , 'png' , 'jpeg' , 'gif' , 'xlsx', 'docx', 'pdf', 'pptx', 'txt', 'xls', 'msg');

             // Allow certain file formats
             if(!in_array($imageFileType."", $validExtensions)) {

                 echo ("<script LANGUAGE='JavaScript'>
                         window.alert('File Upload Failed / Invalid File, Returning to Create Form');
                         window.location.href='dr_update.php?id=". $dr_id ."';
                         </script>");
                 $uploadOk = 0;
             }
             // Check if $uploadOk is set to 0 by an error
             if ($uploadOk == 0) {
                 echo "Sorry, your file was not uploaded.";
             // if everything is ok, try to upload file
             } else {




                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {

 //                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                 } else {

                     echo $_FILES['fileToUpload']['error'][$i];
                     echo "Sorry, there was an error uploading your file.";
                     

                     }
                 }
             $iteminsert = "INSERT INTO emat_uploads (item_name,itemId) VALUES ('$newfilename','$itemNo')";
             $itemeun = $connection->query($iteminsert);
         }

     }
     echo ("<script LANGUAGE='JavaScript'>
        window.alert('RECORD UPDATED');
        window.location.href='emat-index.php';
        </script>");
    }
}


function updateM3($dr_id){
	global $connection;
    global $userconnect;
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        
    if (isset($_POST['submit']))
    {
		//POST is used when sending information from a form//
		
        $handler_CS = sanitizeInput($_POST['handler-cs']);
        $handler_platform_CS = sanitizeInput($_POST['handler-platform-cs']);
        $tester_CS = sanitizeInput($_POST['tester-cs']);
        $tester_platform_CS = sanitizeInput($_POST['tester-platform-cs']); 
        $family_CS = sanitizeInput($_POST['family-name-cs']);
        $lb_name_CS = sanitizeInput($_POST['loadboard-name-cs']);
        $lb_ID_CS = sanitizeInput($_POST['loadboard-id-cs']);
        $package_CS = sanitizeInput($_POST['package-cs']);
        $change_program_TS = sanitizeInput($_POST['change-program-ts']);
        $change_center_board_TS = sanitizeInput($_POST['change-center-board-ts']);
        $change_load_board_TS = sanitizeInput($_POST['change-load-board-ts']);
        $change_package_TS = sanitizeInput($_POST['change-package-ts']);
        $change_kit_TS = sanitizeInput($_POST['change-kit-ts']);
        $tester_transfer_TS = sanitizeInput($_POST['tester-transfer-ts']);
        $handler_tester_TS = sanitizeInput($_POST['handler-tester-ts']);
        $change_handler_TS = sanitizeInput($_POST['change-handler-ts']);
        $change_tester_TS = sanitizeInput($_POST['change-tester-ts']);
        $handler_PS = sanitizeInput($_POST['handler-PS']);
        $handler_platform_PS = sanitizeInput($_POST['handler-platform-PS']);
        $tester_PS = sanitizeInput($_POST['tester-PS']);
        $tester_platform_PS = sanitizeInput($_POST['tester-platform-PS']);
        $family_PS = sanitizeInput($_POST['family-name-PS']);
        $lb_name_PS = sanitizeInput($_POST['loadboard-name-PS']);
        $lb_ID_PS = sanitizeInput($_POST['loadboard-ID-PS']);
        $package_PS = sanitizeInput($_POST['package-PS']);
        $EDTM_PS = sanitizeInput($_POST['edtm-PS']);
        $requested_by_PS = sanitizeInput($_POST['requested-by-PS']);
        $group_PS = sanitizeInput($_POST['group-PS']);
        $shift_PS = sanitizeInput($_POST['shift-PS']);
        $requested_date_PS = sanitizeInput($_POST['requested-date-PS']);
        $expected_date_of_setup_PS = sanitizeInput($_POST['expected-date-of-setup-PS']);
        $unscheduled_setup_PS = sanitizeInput($_POST['unscheduled-setup-PS']);
        $reason_for_unscheduled_setup_PS = sanitizeInput($_POST['reason-for-unscheduled-setup-PS']);
        $lsg_approver_PS = sanitizeInput($_POST['lsg-approver-PS']);
        $remarks_PS = sanitizeInput($_POST['remarks-PS']);
        $change_kit_SM = sanitizeInput($_POST['change-kit-sm']);
        $separator_plate_SM = sanitizeInput($_POST['separator-plate-sm']);
        $unloader_kit_SM = sanitizeInput($_POST['unloader-kit-sm']);
        $work_press_SM = sanitizeInput($_POST['work-press-sm']);
        $baseplate_SM = sanitizeInput($_POST['baseplate-sm']);
        $socket_jig_SM = sanitizeInput($_POST['socket-jig-sm']);
        $power_supply_SM = sanitizeInput($_POST['power-supply-sm']);
        $oscilloscope_SM = sanitizeInput($_POST['oscilloscope-sm']);
        $socket_SM = sanitizeInput($_POST['socket-sm']);
        $others_SM = sanitizeInput($_POST['others-sm']);
        $status = sanitizeInput($_POST['status']);
        $submitter_remarks = sanitizeInput($_POST['submitter-remarks']);
        $submitter = $s['firstName']. " " .$s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];
       
        if ($status == "FOR PREPARATION")
        {
            $query_submitter_remarks = "for_preparation_remarks";
            $query_submitter = "for_preparation_updater";
            $query_date_update ="for_preparation_date";
        }
        else if ($status == "ON GOING PREPARATION")
        {
            $query_submitter_remarks = "ongoing_preparation_remarks";
            $query_submitter = "ongoing_preparation_updater";
            $query_date_update ="ongoing_preparation_date";
        }
        else if ($status == "FOR PICK UP FROM CENTRAL SHOP")
        {
            $query_submitter_remarks = "for_pickup_cshop_remarks";
            $query_submitter = "for_pickup_cshop_updater";
            $query_date_update ="for_pickup_cshop_date";
            
        }
        else if ($status == "READY FOR BUY OFF")
        {
            $query_submitter_remarks = "ready_for_buyoff_remarks";
            $query_submitter = "ready_for_buyoff_updater";
            $query_date_update ="ready_for_buyoff_date";
        }
        else if ($status == "READY FOR PICK UP")
        {
            $query_submitter_remarks = "ready_for_pickup_remarks";
            $query_submitter = "ready_for_pickup_updater";
            $query_date_update ="ready_for_pickup_date";
        }
        else if ($status == "RELEASED")
        {
            $query_submitter_remarks = "released_remarks";
            $query_submitter = "released_updater";
            $query_date_update ="released_date";
        }

        
        
        $query = "UPDATE m3_reports SET handler_CS='$handler_CS',handler_platform_CS='$handler_platform_CS',tester_CS='$tester_CS',tester_platform_CS='$tester_platform_CS',family_CS='$family_CS',lb_name_CS='$lb_name_CS',lb_ID_CS='$lb_ID_CS',package_CS='$package_CS',".
        "change_program_TS ='$change_program_TS',change_center_board_TS='$change_center_board_TS',change_load_board_TS='$change_load_board_TS',change_package_TS='$change_package_TS',change_kit_TS='$change_kit_TS',tester_transfer_TS='$tester_transfer_TS',handler_tester_TS='$handler_tester_TS',".
        "change_handler_TS='$change_handler_TS',change_tester_TS='$change_tester_TS',handler_PS='$handler_PS',handler_platform_PS='$handler_platform_PS',tester_PS='$tester_PS',tester_platform_PS='$tester_platform_PS',family_PS='$family_PS',lb_name_PS='$lb_name_PS',lb_ID_PS='$lb_ID_PS',".
        "package_PS='$package_PS',EDTM_PS='$EDTM_PS',requested_by_PS='$requested_by_PS',group_PS='$group_PS',shift_PS='$shift_PS',requested_date_PS='$requested_date_PS',expected_date_of_setup_PS='$expected_date_of_setup_PS',unscheduled_setup_PS='$unscheduled_setup_PS',".
        "reason_for_unscheduled_setup_PS='$reason_for_unscheduled_setup_PS',lsg_approver_PS='$lsg_approver_PS',remarks_PS='$remarks_PS',change_kit_SM='$change_kit_SM',separator_plate_SM='$separator_plate_SM',unloader_kit_SM='$unloader_kit_SM',work_press_SM='$work_press_SM',".
        "baseplate_SM='$baseplate_SM',socket_jig_SM='$socket_jig_SM',power_supply_SM='$power_supply_SM',oscilloscope_SM='$oscilloscope_SM',socket_SM='$socket_SM',others_SM='$others_SM',status='$status',$query_submitter_remarks='$submitter_remarks',$query_submitter='$submitter',sub_ffId='$sub_ffId',$query_date_update = CURRENT_TIMESTAMP WHERE id = $dr_id";

        $result = mysqli_query($connection, $query);
	       if(!$result){
		      die(mysqli_error($connection));
			
                }
                
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Update Succesfully');
        window.location.href='m3-index.php';
        </script>");
	}
}

function updateLSGRR($dr_id){
	global $connection;
	if (isset($_POST['submit'])){
        
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
    
        $tester = sanitizeInput($_POST['tester']);
        $handler = sanitizeInput($_POST['handler']);
        $fam_name = sanitizeInput($_POST['fam_name']);
        $lb_name = sanitizeInput($_POST['lb_name']); 
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $repair_s = sanitizeInput($_POST['repair_s']);
        $pre_vac = sanitizeInput($_POST['pre_vac']);
        $dt = sanitizeInput($_POST['dt']);
        $stat = sanitizeInput($_POST['stat']);
        $lb_id = sanitizeInput($_POST['lb_id']);
        $submitter = sanitizeInput($_POST['submitter']);
        
        
		$query = "UPDATE lsg_reports SET tester = '$tester', handler = '$handler',fam_name = '$fam_name', lb_name = '$lb_name', pfd = '$pfd', fwa='$fwa', action_d='$action_d', repair_s='$repair_s' , pre_vac='$pre_vac', dt='$dt', stat='$stat', LB_id='$lb_id', submitter ='$submitter' WHERE id = $dr_id ";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

function updateSR($dr_id){
	global $connection;
    global $userconnect;
	if (isset($_POST['submit'])){
        $sql ="SELECT * from employeeinfos WHERE isDeleted=0 AND ffId ='". $_SESSION['rs_username'] ."'";
        $result = $userconnect-> query($sql);
        $s = get_data_array($result);
        ?><script>

    alert("RECORD UPDATED");
        </script>
   <?php
        
        $tester = sanitizeInput($_POST['tester']);//
        $handler = sanitizeInput($_POST['handler']);//
        $package = sanitizeInput($_POST['package']);
        $product_name = sanitizeInput($_POST['product-name']);
        $setup_code = sanitizeInput($_POST['setup-code']);
        $ie_time = sanitizeInput($_POST['ie-time']);
        $actual_setup_time = sanitizeInput($_POST['actual-setup-time']);
        $gap = sanitizeInput($_POST['gap']);
        $pfd = sanitizeInput($_POST['pfd']);
        $fwa = sanitizeInput($_POST['fwa']);
        $action_d = sanitizeInput($_POST['action_d']);
        $category = sanitizeInput($_POST['category']);
        $stat = sanitizeInput($_POST['stat']);
        $remarks = sanitizeInput($_POST['remarks']);
        $submitter = $s['firstName'] ." ". $s['lastName'];
        $sub_ffId = $_SESSION['rs_username'];

         $query = "update setup_reports SET tester = '$tester',handler = '$handler',package = '$package',fam_name = '$product_name',setup_code = '$setup_code',ie_time = '$ie_time',actual_setup_time = '$actual_setup_time',gap = '$gap',pfd = '$pfd',fwa = '$fwa',action_d = '$action_d',category = '$category',stat ='$stat',remarks ='$remarks',submitter = '$submitter',sub_ffId = '$sub_ffId' WHERE id = $dr_id";
        
//        echo $query;
		$result = mysqli_query($connection, $query);
	   if(!$result){
		  die("QUERY FAILED" . mysqli_error($connection));
                    }
        
    }
}

//function deleteCurrentDR(){
//    global $connection;
//	if(isset($_POST['submit'], $_POST['dr_id'])){
//        $dr_id = $_POST['dr_id'];
////		global $connection;
//		$query = "DELETE FROM dailyreports WHERE id = $dr_id";
//		$result = mysqli_query($connection, $query);
//	if(!$result){
//		die("QUERY FAILED" . mysqli_error($connection));
//				}
//	echo ("<script LANGUAGE='JavaScript'>
//    window.alert('Record Succesfully Deleted');
//    window.location.href='index.php';
//    </script>");
//	}
//}

function deleteLB($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE dailyreports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='index.php';
        </script>");                        
                            }
    
}

function deleteLBPM($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE lbpm_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='lbpm-index.php';
        </script>");                        
                            }
    
}

function deleteLBIM($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE lbim SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='lbim-index.php';
        </script>");                        
                            }
    
}

 
function deleteSL($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE speedloss SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='sl-index.php';
        </script>");
    
                            } 
    
    
    
} 

function deleteBib($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE burnin_report SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='bib-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteExt($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE ext_report SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='ext-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteWMAT($dr_id){
    global $connection;
    
    
if (isset($_POST['del_wmat'])){
    $sql = "UPDATE wmat SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='wmat-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteHCAT($dr_id){
    global $connection;
    
    
if (isset($_POST['del_hcat'])){
    $sql = "UPDATE hcat SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='hcat-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteER($dr_id){
    global $connection;
    
    
if (isset($_POST['del_er'])){
    $sql = "UPDATE ee_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='ee-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteDMAT($dr_id){
    global $connection;
    
    
if (isset($_POST['del_dmat'])){
    $sql = "UPDATE dmat SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='dmat-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteEMAT($dr_id){
    global $connection;
    
    
if (isset($_POST['del_emat'])){
    $sql = "UPDATE emat SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='emat-index.php';
        </script>");
    
                            } 
    
    
    
}

function deleteTRR($dr_id){
    global $connection;
    
    
if (isset($_POST['del_trr'])){
    $sql = "UPDATE tester_repair_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='tester-repair-report-index.php';
        </script>");                        
                            }
    
}

function deleteTPM($dr_id){
    global $connection;
    
    
if (isset($_POST['del_tpm'])){
    $sql = "UPDATE tester_preventive_maintenance_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='tester-preventive-maintenance-index.php';
        </script>");                        
                            }
    
}

function deleteTIHM($dr_id){
    global $connection;
    
    
if (isset($_POST['del_tihm'])){
    $sql = "UPDATE tester_in_house_module_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='tester-in-house-module-repair-index.php';
        </script>");                        
                            }
    
}

function deleteTDR($dr_id){
    global $connection;
    
    
if (isset($_POST['del_tdr'])){
    $sql = "UPDATE tester_defective_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='tester-defective-index.php';
        </script>");                        
                            }
    
}

function deleteLSGRR($dr_id){
    global $connection;
    
    
if (isset($_POST['del_lb'])){
    $sql = "UPDATE lsg_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='lsg-index.php';
        </script>");                        
                            }
    
}

function deleteSR($dr_id){
    global $connection;
    
    
if (isset($_POST['del_sr'])){
    $sql = "UPDATE setup_reports SET isDeleted = 1 WHERE id = $dr_id";
    $result = $connection->query($sql);
    
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('Record Succesfully Deleted');
        window.location.href='setup-index.php';
        </script>");                        
                            }
    
}




 
    
?>









