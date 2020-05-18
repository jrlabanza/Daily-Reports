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


$sql ="SELECT fam_name, COUNT(fam_name) As countFam FROM  ftdr.lsg_reports WHERE isDeleted=0 AND dr_date >= '2019-01-01 00:00:00' GROUP BY fam_name ORDER BY countFam DESC LIMIT 10";
$result = $connection->query($sql);
$machineCount = get_assocArray($result);



$labels = array();
$data = array();

$machineCountSize = sizeof($machineCount);

for($i=0; $i<$machineCountSize; $i++){
    array_push($labels, $machineCount[$i]['fam_name']);
    array_push($data, $machineCount[$i]['countFam']);
}


$machineCountArr = array("labels" => $labels, "data" => $data);

echo json_encode($machineCountArr);


?>