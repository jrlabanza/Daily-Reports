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


$sql ="SELECT submitter, COUNT(submitter) As countWho FROM  dailyreports WHERE isDeleted=0 AND dr_date >= '2019-01-01 00:00:00' GROUP BY submitter ORDER BY countWho DESC LIMIT 10";
$result = $connection->query($sql);
$testerCount = get_assocArray($result);



$labels = array();
$data = array();

$testerCountSize = sizeof($testerCount);

for($i=0; $i<$testerCountSize; $i++){
    array_push($labels, $testerCount[$i]['submitter']);
    array_push($data, $testerCount[$i]['countWho']);
}


$testerCountArr = array("labels" => $labels, "data" => $data);

echo json_encode($testerCountArr);


?>