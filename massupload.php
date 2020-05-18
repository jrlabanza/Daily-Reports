<?php 
session_start();
include "database/db.php";
include "functions/functions.php";

$sql = "SELECT * FROM employeeinfos WHERE ffId ='". $_SESSION['rs_username'] . "'";
$result = $userconnect-> query($sql);
$user = get_data_array($result); 

if ($_SESSION['report_type'] == 1){
    
        
    if (isset($_POST['sub_mass'])){
        
        if($_FILES['massUpload']['name']){
            
            $filename = explode(".", $_FILES['massUpload']['name']);
            if(end($filename) == "csv"){
                
               $handle= fopen($_FILES['massUpload']['tmp_name'], "r");
                while ($data = fgetcsv($handle)){
                    $dr_date = sanitizeInput(isset($data[0]) ? $data[0] : "");
                    $dateTmp = strtotime($dr_date); 
                    $date = date("Y-m-d H:i:s", $dateTmp);
                    $tester = sanitizeInput(isset($data[1]) ? $data[1] : "");
                    $handler = sanitizeInput(isset($data[2])? $data[2] : "");
                    $fam_name = sanitizeInput(isset($data[3]) ? $data[3] : "");
                    $LB_id = sanitizeInput(isset($data[4]) ? $data[4] : "");
                    $lb_name = sanitizeInput(isset($data[5]) ? $data[5] : ""); 
                    $pfd = sanitizeInput(isset($data[6]) ? $data[6] : "");
                    $fwa = sanitizeInput(isset($data[7]) ? $data[7] : "");
                    $action_d = sanitizeInput(isset($data[8]) ? $data[8] : "");
                    $pre_vac = sanitizeInput(isset($data[9]) ? $data[9] : "");
                    $dt = sanitizeInput(isset($data[10]) ? $data[10] : "");
                    $stat = sanitizeInput(isset($data[11]) ? $data[11] : "");
                    
                    $submitter = $user['firstName'] . " " . $user['lastName'];
                    $sub_ffId = $_SESSION['rs_username'];
                    
                    $query = "INSERT INTO dailyreports(dr_date,tester,handler,fam_name,lb_name,pfd,fwa,action_d,pre_vac,dt,stat,submitter,LB_id,sub_ffId) VALUES ('$date', '$tester' ,'$handler' ,'$fam_name', '$lb_name' , '$pfd' , '$fwa' , '$action_d' , '$pre_vac' , '$dt' , '$stat', '$submitter', '$LB_id', '$sub_ffId')";
                    
                    $post_result = $connection->query($query);
                    
                    
                }
                fclose($handle);
                echo ("<script LANGUAGE='JavaScript'>
                window.alert('Record Succesfully Created');
                window.location.href='index.php';
                </script>");
                
            }
            else{
                
                
            }
            
        } 
        
        
        


 }   
    
    
}

    if ($_SESSION['report_type'] == 2){

        if (isset($_POST['sub_mass'])){

            if($_FILES['massUpload']['name']){

                $filename = explode(".", $_FILES['massUpload']['name']);
                if(end($filename) == "csv"){

                   $handle= fopen($_FILES['massUpload']['tmp_name'], "r");
                    while ($data = fgetcsv($handle)){

                        $sl_date = sanitizeInput(isset($data[0]) ? $data[0] : "");
                        $dateTmp = strtotime($sl_date); 
                        $date = date("Y-m-d H:i:s", $dateTmp);
                        $tester_id = sanitizeInput(isset($data[1]) ? $data[1] : "");
                        $tester_pf = sanitizeInput(isset($data[2]) ? $data[2] : "");
                        $handler = sanitizeInput(isset($data[3]) ? $data[3] : "");
                        $handler_pf = sanitizeInput(isset($data[4]) ? $data[4] : "");
                        $device = sanitizeInput(isset($data[5]) ? $data[5] : "");
                        $sl_status_owner = sanitizeInput(isset($data[6]) ? $data[6] : "");
                        $status_owner = sanitizeInput(isset($data[7]) ? $data[7] : "");
                        $duration = sanitizeInput(isset($data[8]) ? $data[8] : "");
                        $who_1 = sanitizeInput(isset($data[9]) ? $data[9] : "");
                        $problem = sanitizeInput(isset($data[10]) ? $data[10] : "");
                        $act_done = sanitizeInput(isset($data[11]) ? $data[11] : "");
                        $who_2 = sanitizeInput(isset($data[12]) ? $data[12] : "");
                        $sl_commit = sanitizeInput(isset($data[13]) ? $data[13] : "");
                        $sl_status = sanitizeInput(isset($data[14]) ? $data[14] : "");
                        $sl_remarks = sanitizeInput(isset($data[15]) ? $data[15] : "");

                        $submitter = $user['firstName'] . " " . $user['lastName'];
                        $sub_ffId = $_SESSION['rs_username'];

                        $query = "INSERT INTO speedloss(sl_date,tester_id,tester_pf,handler,handler_pf,device,sl_status_owner,status_owner,duration,who_1,problem,who_2,act_done,sl_commit,sl_status,sl_remarks,submitter,sub_ffId) VALUES ('$date' ,'$tester_id' ,'$tester_pf', '$handler' , '$handler_pf' , '$device' , '$sl_status_owner' , '$status_owner', '$duration' , '$who_1' , '$problem', '$who_2', '$act_done', '$sl_commit', '$sl_status', '$sl_remarks', '$submitter', '$sub_ffId')";

                        $post_result = $connection->query($query);


                    }
                    fclose($handle);
                    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Succesfully Created');
                    window.location.href='sl-index.php';
                    </script>");

                }
                else{


                }

            } 





     } 

    }

    if ($_SESSION['report_type'] == 3){

        if (isset($_POST['sub_mass'])){

            if($_FILES['massUpload']['name']){

                $filename = explode(".", $_FILES['massUpload']['name']);
                if(end($filename) == "csv"){

                  $handle= fopen($_FILES['massUpload']['tmp_name'], "r");
                    while ($data = fgetcsv($handle)){
                    $br_date = sanitizeInput(isset($data[0]) ? $data[0] : "");
                    $dateTmp = strtotime($br_date); 
                    $date = date("Y-m-d H:i:s", $dateTmp);
                    $burn_in_no = sanitizeInput(isset($data[1]) ? $data[1] : "");
                    $family_name = sanitizeInput(isset($data[2]) ? $data[2] : "");
                    $bib_id = sanitizeInput(isset($data[3])? $data[3] : "");
                    $bib_name = sanitizeInput(isset($data[4]) ? $data[4] : "");
                    $pfd = sanitizeInput(isset($data[5]) ? $data[5] : "");
                    $fwa = sanitizeInput(isset($data[6]) ? $data[6] : "");
                    $act_done = sanitizeInput(isset($data[7]) ? $data[7] : "");
                    $pre_vac = sanitizeInput(isset($data[8]) ? $data[8] : "");
                    $dt = sanitizeInput(isset($data[9]) ? $data[9] : "");
                    $br_status = sanitizeInput(isset($data[10]) ? $data[10] : "");
                    
                    $submitter = $user['firstName'] . " " . $user['lastName'];
                    $sub_ffId = $_SESSION['rs_username'];
                    
                    $query = "INSERT INTO burnin_report(br_date,burn_in_no,family_name,bib_id,bib_name,pfd,fwa,act_done,pre_vac,dt,br_status,who,sub_ffId) VALUES ('$date', '$burn_in_no' ,'$family_name' ,'$bib_id', '$bib_name' , '$pfd' , '$fwa' , '$act_done' , '$pre_vac' , '$dt' , '$br_status', '$submitter', '$sub_ffId')";
                    
                    $post_result = $connection->query($query);


                    }
                    fclose($handle);
                    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Succesfully Created');
                    window.location.href='bib-index.php';
                    </script>");


                }
                else{


                }

            } 





     } 

    }

    if ($_SESSION['report_type'] == 4){

        if (isset($_POST['sub_mass'])){

            if($_FILES['massUpload']['name']){

                $filename = explode(".", $_FILES['massUpload']['name']);
                if(end($filename) == "csv"){

                   $handle= fopen($_FILES['massUpload']['tmp_name'], "r");
                    while ($data = fgetcsv($handle)){
                    $ex_date = sanitizeInput(isset($data[0]) ? $data[0] : "");
                    $dateTmp = strtotime($ex_date); 
                    $date = date("Y-m-d H:i:s", $dateTmp);
                    $item_desc = sanitizeInput(isset($data[1]) ? $data[1] : "");
                    $serial_id = sanitizeInput(isset($data[2]) ? $data[2] : "");
                    $req_per = sanitizeInput(isset($data[3])? $data[3] : "");
                    $req_dept = sanitizeInput(isset($data[4]) ? $data[4] : "");
                    $pfd = sanitizeInput(isset($data[5]) ? $data[5] : "");
                    $fwa = sanitizeInput(isset($data[6]) ? $data[6] : "");
                    $act_done = sanitizeInput(isset($data[7]) ? $data[7] : "");
                    $pre_vac = sanitizeInput(isset($data[8]) ? $data[8] : "");
                    $dtr = sanitizeInput(isset($data[9]) ? $data[9] : "");
                    $dte = sanitizeInput(isset($data[9]) ? $data[9] : "");
                    $dt = sanitizeInput(isset($data[9]) ? $data[9] : "");
                    $ex_status = sanitizeInput(isset($data[10]) ? $data[10] : "");
                    
                    $submitter = $user['firstName'] . " " . $user['lastName'];
                    $sub_ffId = $_SESSION['rs_username'];
                    
                    $query = "INSERT INTO ext_report(ex_date,item_desc,serial_id,req_per,req_dept,pfd,fwa,act_done,pre_vac,dtr,dte,dt,ex_status,who,sub_ffId) VALUES ('$date', '$item_desc' ,'$serial_id' ,'$req_per', '$req_dept' , '$pfd' , '$fwa' , '$act_done' , '$pre_vac' ,'$dtr', '$dte', '$dt' , '$ex_status', '$submitter', '$sub_ffId')";
                    
                    $post_result = $connection->query($query);


                    }
                    fclose($handle);
                    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Succesfully Created');
                    window.location.href='ext-index.php';
                    </script>");

                }
                else{


                }

            } 





     } 

    }
    
    if ($_SESSION['report_type'] == 6){

        if (isset($_POST['sub_mass'])){

            if($_FILES['massUpload']['name']){

                $filename = explode(".", $_FILES['massUpload']['name']);
                if(end($filename) == "csv"){

                   $handle= fopen($_FILES['massUpload']['tmp_name'], "r");
                    while ($data = fgetcsv($handle)){
                   
                    $desc_act_item = sanitizeInput(isset($data[0]) ? $data[0] : "");
                    $responsible = sanitizeInput(isset($data[1])? $data[1] : "");
                    
                    $rem = sanitizeInput(isset($data[2]) ? $data[2] : "");
                    
                    
                    
                    $submitter = $user['firstName'] . " " . $user['lastName'];
                    $sub_ffId = $_SESSION['rs_username'];
                    $stat = "OPEN";
                    
                    $query = "INSERT INTO wmat(entry_date,desc_act_item,responsible,stat,rem,submitter,sub_ffId) VALUES (CURRENT_TIMESTAMP,'$desc_act_item' ,'$responsible', '$stat' , '$rem' , '$submitter', '$sub_ffId')";
                    
                    $post_result = $connection->query($query);


                    }
                    fclose($handle);
                    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Succesfully Created');
                    window.location.href='wmat-index.php';
                    </script>");

                }
                else{


                }

            } 





     } 

    }








?>





