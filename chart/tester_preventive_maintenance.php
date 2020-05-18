<?php 
include "../database/db.php";

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


$sql ="SELECT platform, COUNT(platform) As countPlatform FROM  tester_preventive_maintenance_reports WHERE isDeleted=0 AND date >= '2019-01-01 00:00:00' GROUP BY platform ORDER BY countPlatform DESC LIMIT 10";
$result = $connection->query($sql);
$testerCount = get_assocArray($result);



$labels = array();
$data = array();

$testerCountSize = sizeof($testerCount);

for($i=0; $i<$testerCountSize; $i++){
    array_push($labels, $testerCount[$i]['platform']);
    array_push($data, $testerCount[$i]['countPlatform']);
}


$testerCountArr = array("labels" => $labels, "data" => $data);

echo json_encode($testerCountArr);


?>