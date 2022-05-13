<?php
ob_start();
include('../admin/includes/db.php');


$query = $conn->prepare(
    "SELECT cert_number from cards"
);
$query->execute();

$result=array();
while($row = $query->fetch(PDO::FETCH_ASSOC)){

    extract($row);

    // $result_item=array(
    //     "cert_number"=>$cert_number
    // );

    array_push($result, $cert_number);
}

echo json_encode($result);
