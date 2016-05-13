<body>
<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$statement = isset($statement)? $statement : null;
if ($actual==3){
    $request = "(SELECT Eta_ID
                FROM Descriptions, Commentaires
                WHERE com_id = des_id
                GROUP BY eta_id
                HAVING COUNT(com_id) < 2)
                UNION
                (SELECT eta_id
                FROM etablissements E
                WHERE NOT EXISTS (SELECT *
                    FROM Descriptions D, Commentaires
                    WHERE com_id = des_id AND E.eta_id = D.eta_id))";
    $statement = $db->prepare($request);
    $statement->execute();
}

if ($actual==5){
    $request = "SELECT Eta_ID, AVG(score) AS note
                FROM Descriptions D, Commentaires C
                WHERE D.des_id = C.com_id
                GROUP BY eta_id
                HAVING COUNT(eta_id) > 2
                ORDER BY note DESC";
    $statement = $db->prepare($request);
    $statement->execute();
}
?>
<div class="col-md-4"><button onclick="location.href='requests.php?actual=3'"><strong>Requ&ecirc;te 3</strong></button></div><br></br>
<div class="col-md-4"><button onclick="location.href='requests.php?actual=5'"><strong>Requ&ecirc;te 5</strong></button></div><br></br>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title">R&eacute;sultats</h1>
    </div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <tr class="success">
                    <th>#</th>
                    <th>Name</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($actual){
                    $index = 1;
                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i<count($rows);$i++){
                        echo "<tr>";
                            echo "<td>".$index++."</td>";
                            echo '<td> <a href="?actual='.$rows[$i]["Eta_ID"].'">'.$rows[$i]["Eta_ID"].'</a></td>';
                            // note moyenne
                            $statement = $db->prepare("SELECT AVG(Score) AS Note FROM Commentaires WHERE EXISTS(SELECT * FROM Descriptions WHERE Des_ID = Com_ID AND Eta_ID = :Eta_ID)");
                            $statement->execute(array("Eta_ID" => $rows[$i]["Eta_ID"]));
                            $note = $statement->fetch(PDO::FETCH_ASSOC);
                            echo "<td>".round($note["Note"],1)."</td>";
                        echo "</tr>";
                    }
                } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "footer.php"; ?>
