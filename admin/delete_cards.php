<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['admin_id'])) {

        header('location:login.php');
    }
}

if (isset($_GET["id"])) {

    $card_id = $_GET['id'];
} else {
    header('location:index.php');
}



$query = $conn->prepare(
    "SELECT * from card_images where card_id='$card_id'"
);
$query->execute();

while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    unlink("../images/" . $result["card_image"]);
}



$del = $conn->prepare("DELETE FROM card_images WHERE card_id='$card_id'");
$del->execute();



$del = $conn->prepare("DELETE FROM cards WHERE id='$card_id'");

if ($del->execute()) {
    header("location:cards.php?status=del_succ");
} else {
    header("location:cards.php?status=del_fai;");
}
