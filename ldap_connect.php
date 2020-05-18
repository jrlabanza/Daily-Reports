<?php session_start();
include "database/db.php";
include "functions/functions.php";
/**
 * Created by Joe of ExchangeCore.com
 */

if(isset($_POST['username']) && isset($_POST['password'])){
    
        
    
    if (!empty($_POST['username']) && !empty($_POST['password'])){
                $adServer = "ldap://ad.onsemi.com";

        $ldap = ldap_connect($adServer);

        $username = $_POST['username']; // FF ID
        $password = $_POST['password'];
        
    //    $task = $_POST['task'];

        $ldaprdn = 'onsemi' . "\\" . $username;
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($ldap, $ldaprdn, $password);

        if ($bind) {

            // if (ldap_get_option($ldap, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
            //     echo "Error Binding to LDAP: $extended_error";
            // } else {
            //     echo "Error Binding to LDAP: No additional information is available.";
            // }

            $filter="(sAMAccountName=$username)";
            $result = ldap_search($ldap,"dc=MYDOMAIN,dc=COM",$filter);
            ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);
            $_SESSION['rs_username'] = $username;
            
              
            // $sql ="SELECT * FROM employeeinfos WHERE ffId = "ffzfqg" OR ffId = "zbh4bc" OR ffId = "fg8fzh"";
            
            $usersql = "SELECT * FROM usertype WHERE ffId ='$username'";
            $userres = $connection-> query($usersql);
            $u = get_data_array($userres);
            
            
            
                if ($username == $u['ffId']){
                    $userPriv = 2;
                    $_SESSION['userPriv'] = $userPriv;
                    
                    }
                else{
                   $userPriv = 1;
                    $_SESSION['userPriv'] = $userPriv; 
                    
                }
                
             
            
            

    //        $_SESSION['ess_logged_in'] = true;
    //        $_SESSION['ess_userEmail'] = strtolower($username); // FFID
    //
    //        require_once("model/User.php");
    //        $userObj = new User();
    //
    //        $empIDArr = $userObj->getUserEmployeeTbID(strtolower($username));
    //
    //        $empID = $empIDArr['id'];
    //        $_SESSION['employee_ID'] = $empID;
    //
    //        $empAreas = $userObj->getEmployeeAreas($empID);
    //        $_SESSION['empAreas'] = $empAreas;
    //
    //        if ($task === "1"){
    //            $_SESSION['user_type'] = 3;
    //        }else{
    //            // EHS personnel and Head only
    //            $userData = $userObj->getUserType($username);
    //
    //            if (sizeof($userData) === 1){
    //                $_SESSION['user_type'] = $userData['userType'];
    //
    //                if ($task === "2"){
    //                    if ($_SESSION['user_type'] == "1"){
    //                        $_SESSION['user_type'] = 2;
    //                    }
    //                }
    //
    //            }else{
    //                $_SESSION['user_type'] = 3;
    //            }
    //        }
    //
    //        $userObj->setTrackingUserInActivity();

            @ldap_close($ldap);
            switch($_SESSION['report_type']){
                case "1":
                    header("Location: index.php");
                    break;
                case "2":
                    header("Location: sl-index.php");
                    break;
                case "3":
                    header("Location: bib-index.php");
                    break;
                case "4":
                    header("Location: ext-index.php");
                    break;
                case "5":
                    header("Location: lbpm-index.php");
                    break;
                case "6":
                    header("Location: wmat-index.php");
                    break;
                case "7":
                    header("Location: lbim-index.php");
                    break;
                case "8":
                    header("Location: ee-index.php");
                    break;
                case "9":
                    header("Location: dmat-index.php");
                    break;
                case "10":
                    header("Location: m3-index.php");
                    break;
                case "11":
                    header("Location: emat-index.php");
                    break;
                case "12":
                    header("Location: tester-repair-report-index.php");
                    break;
                case "13":
                    header("Location: tester-preventive-maintenance-index.php");
                    break;
                case "14":
                    header("Location: tester-in-house-module-repair-index.php");
                    break;
                case "15":
                    header("Location: tester-defective-index-index.php");
                    break;    
                case "16":
                    header("Location: lsg-index.php");
                    break;
                case "17":
                    header("Location: setup-index.php");
                    break;
                default:
                    header("Location: index.php");      

            }
            
            // header("Location: index.php");
            exit();
    }
    }


}

$_SESSION['retry'] = 1;
//echo "FALSE";
header("Location: login_page.php");
exit();
?>
