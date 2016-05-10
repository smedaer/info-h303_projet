<?php
include "header.php";
include "connection.php"
?>
<body>
<select name="id">
<option value="">--- Select ---</option>
<?php
$statement = $db->prepare("SELECT Eta_ID FROM Etablissements WHERE Exists (SELECT * FROM Cafes WHERE Cafe_ID = Eta_ID)");
$statement->execute(array());
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
    echo "<option value=\"name1\">".$row["Eta_ID"]."</option>";
} ?>
</select>
<?php include "footer.php"; ?>
