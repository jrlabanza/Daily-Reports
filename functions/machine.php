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

$machine = isset($_POST['machine']) ? $_POST['machine'] : 0;

$sql = "SELECT * FROM machine WHERE machine_number = '". $machine ."'";
$results = mysqli_query($connection, $sql);
$d = get_data_array($results);

echo json_encode($d)


?>