<?php
//connects php to mysql//
$connection = mysqli_connect('phsm01ws012', 'fthrdr','fthrdr01','ftdr');
if(!$connection){
die ('DATABASE NOT CONNECTED');
}

//$connection = mysqli_connect('localhost', 'root','','ftdr');
//if(!$connection){
//die ('DATABASE NOT CONNECTED');
//}


$userconnect = mysqli_connect('phsm01ws012','usercheecker','usercheecker01','userlookup');
if(!$userconnect){
die ('DATABASE NOT CONNECTED');
}

$equipment = mysqli_connect('phsm01ws012','readonly','readonly01','cents');
if(!$equipment){
die ('DATABASE NOT CONNECTED');
}

$promis = mysqli_connect('10.153.239.120', 'web3', 'web3', 'p1_equipt_db');
if(!$promis){
    die('DATABASE NOT CONNECTED');
}
?>
