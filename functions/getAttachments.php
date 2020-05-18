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

$dr_id = isset($_POST['dr_id']) ? $_POST['dr_id'] : 0;

$query ="SELECT * FROM lsg_uploads WHERE itemId=". $dr_id ;
$result = $connection->query($query);
$d = get_assocArray($result);

echo json_encode($d);
?>    
    
