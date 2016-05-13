<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$Eta_ID = isset($_GET["Eta_ID"]) ? $_GET["Eta_ID"] : null;

$statement = $db->prepare("DELETE FROM Etablissements WHERE Eta_ID=:Eta_ID");
$statement->execute(array("Eta_ID"=>$Eta_ID));
if ($actual === "restaurant"){
    $statement = $db->prepare("DELETE FROM Restaurants WHERE Rest_ID=:Eta_ID");
    $statement->execute(array("Eta_ID"=>$Eta_ID));
} elseif ($actual === "coffee"){
    $statement = $db->prepare("DELETE FROM Cafes WHERE Cafe_ID=:Eta_ID");
    $statement->execute(array("Eta_ID"=>$Eta_ID));
} else {
    $statement = $db->prepare("DELETE FROM Hotels WHERE Hot_ID=:Eta_ID");
    $statement->execute(array("Eta_ID"=>$Eta_ID));
}
 header("location: index.php");
include "footer.php"; ?>
