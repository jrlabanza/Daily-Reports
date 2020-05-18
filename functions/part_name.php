<?php
    include "../database/db.php";
//////////////////////Get Data Array ///////////////////////    
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
///////////////////////////Get Associative Array////////////////////////
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

$part_name = isset($_POST['part_name']) ? $_POST['part_name'] : 0;

$sql = "SELECT * FROM parts WHERE part_name = '". $part_name ."'";
$results = mysqli_query($connection, $sql);
$d = get_data_array($results);

echo json_encode($d)


?>