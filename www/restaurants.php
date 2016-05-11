<body>
<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$newCom = isset($_POST['newCom']) ? $_POST['newCom'] : null;
$newScore = isset($_POST['newScore']) ? $_POST['newScore'] : null;
$newLabel = isset($_POST['newLabel']) ? $_POST['newLabel'] : null;
if ($newCom){
    $newScore = intval($newScore);
    $statement = $db->prepare("INSERT INTO Descriptions(User_ID,Eta_ID) VALUES(:User_ID,:Eta_ID)");
    $statement->execute(array("User_ID" => $_SESSION["User_ID"],"Eta_ID" => $actual));
    $statement = $db->prepare("SELECT Des_ID FROM Descriptions ORDER BY Des_ID DESC LIMIT 1");
    $statement->execute(array());
    $Des_ID = intval($statement->fetch(PDO::FETCH_ASSOC)["Des_ID"]);
    $statement = $db->prepare("INSERT INTO Commentaires(Com_ID,Com,Creation_date,Score) VALUES(:Des_ID,:newCom,:Creation_date,:newScore)");
    $statement->execute(array("Des_ID" => $Des_ID,"newCom" => $newCom,"Creation_date" => ((new Datetime())->format('Y-m-d H:i:s')),"newScore" => $newScore));
}

if ($newLabel){
    $statement = $db->prepare("INSERT INTO Descriptions(User_ID,Eta_ID) VALUES(:User_ID,:Eta_ID)");
    $statement->execute(array("User_ID" => $_SESSION["User_ID"],"Eta_ID" => $actual));
    $statement = $db->prepare("SELECT Des_ID FROM Descriptions ORDER BY Des_ID DESC LIMIT 1");
    $statement->execute(array());
    $Des_ID = intval($statement->fetch(PDO::FETCH_ASSOC)["Des_ID"]);
    $statement = $db->prepare("INSERT INTO Labels(Lab_ID,Label) VALUES(:Des_ID,:Label)");
    $statement->execute(array("Des_ID" => $Des_ID,"Label" => $newLabel));
}

if ($actual){
    $statement = $db->prepare("SELECT AdRue,AdNumero,AdCodePostal,AdCity,Longitude,Latitude,Tel,Site,Admin FROM Etablissements WHERE Eta_ID = :Eta_ID");
    $statement->execute(array("Eta_ID" => $actual));
    $resEta = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement = $db->prepare("SELECT Prix,Couverts,Emporter,Livraison,Fermeture FROM Restaurants WHERE Rest_ID = :Eta_ID");
    $statement->execute(array("Eta_ID" => $actual));
    $resRest = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $actual ?></h3>
        </div>
        <div class="panel-body">
            <div class="col-md-7">
                <div class="panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Informations sur le restaurant </h2>
                    </div>
                    <div class="panel-body">
                        Prix moyen:&nbsp; <?php echo $resRest[0]["Prix"] ?> <br>
                        Nombre maximum de couverts:&nbsp; <?php echo $resRest[0]["Couverts"] ?> <br>
                        Emporter:&nbsp; <?php echo($resRest[0]["Emporter"]? "oui" : "non") ?> <br>
                        Livraison:&nbsp; <?php echo($resRest[0]["Livraison"]? "oui" : "non") ?> <br>
                        Jours de fermeture:&nbsp; <br>
                    </div>
                </div>
                <div class="panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Nous contacter </h2>
                    </div>
                    <div class="panel-body">
                        T&eacutel&eacutephone:&nbsp; <?php echo $resEta[0]["Tel"] ?> <br>
                        Site:&nbsp; <?php echo ($resEta[0]["Site"]? '<a href="https://'.$resEta[0]["Site"].'">'.$resEta[0]["Site"].'</a>' : "Nous n'avons pas de site") ?> <br>
                        Admin sur le site: &nbsp; <?php echo $resEta[0]["Admin"] ?> <br>
                    </div>
                </div>
                <div class="panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Labels </h2>
                    </div>
                    <div class="panel-body">
                        <?php
                        $statement = $db->prepare("SELECT DISTINCT Label FROM Labels WHERE EXISTS(SELECT * FROM Descriptions WHERE Des_ID = Lab_ID AND Eta_ID = :actual)");
                        $statement->execute(array("actual" => $actual));
                        while($label = $statement->fetch(PDO::FETCH_ASSOC)["Label"]){echo "#".$label."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";}
                        if(isset($_SESSION["User_ID"])){?>
                            <br><br>
                            <form action="<?php echo "?actual=".$actual; ?>" method="post" class="form-horizontal">
                                <input class="form-control" name="newLabel" placeholder="Ajouter un label" value="<?php echo $newLabel ?>">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Nous situer </h2>
                    </div>
                    <div class="panel-body">
                        Adresse:&nbsp; <?php echo $resEta[0]["AdNumero"]."  ".$resEta[0]["AdRue"]."  ".$resEta[0]["AdCodePostal"]."  ".$resEta[0]["AdCity"] ?> <br>
                        latitude / longitude: &nbsp; <?php echo $resEta[0]["Latitude"]." / ".$resEta[0]["Longitude"]?> <br>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d800.7861924332165!2d<?php echo $resEta[0]["Longitude"] ?>!3d<?php echo $resEta[0]["Latitude"] ?>!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sus!4v1462888317175" width="430" height="320" frameborder="1" style="border:1" allowfullscreen></iframe>
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                <div class="panel-success">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Commentaires </h2>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($_SESSION["User_ID"])){?>
                            <form action="<?php echo "?actual=".$actual; ?>" method="post" class="form-horizontal">
                                <fieldset>
                                    <legend>Ajouter un commentaire</legend>
                                    <div class="form-group">
                                        <label for="textArea" class="col-lg-2 control-label">Commentaire</label>
                                        <div class="col-lg-10">
                                            <textarea style="width:700px; height:100px;" name="newCom" class="form-control" placeholder="Nouveau commentaire" value="<?php echo $newCom ?>" rows="3" id="textArea"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="select" class="col-lg-2 control-label">Score</label>
                                        <div class="col-lg-1">
                                            <select class="form-control" name="newScore" id="select">
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        <?php }
                        $statement = $db->prepare("SELECT User_ID FROM Descriptions WHERE Eta_ID = :Eta_ID AND EXISTS(SELECT * FROM Commentaires WHERE Des_ID = Com_ID)");
                        $statement->execute(array("Eta_ID" => $actual));
                        $statement1 = $db->prepare("SELECT Com,Creation_date,Score FROM Commentaires WHERE EXISTS(SELECT * FROM Descriptions WHERE Des_ID = Com_ID AND Eta_ID = :Eta_ID)");
                        $statement1->execute(array("Eta_ID" => $actual));
                        while(($author = $statement->fetch(PDO::FETCH_ASSOC)) && ($com = $statement1->fetch(PDO::FETCH_ASSOC))){?>
                            <div class='panel-default'>
                                <div class='panel-heading'>
                                    <div class='panel-title'><?php echo $author['User_ID']; ?> <span class='pull-right'> Note donn&eacutee:&nbsp; <?php echo $com['Score'];?></span></div>
                                </div>
                                <div class='panel-body'>
                                    <?php echo $com['Com']; ?> <br>
                                    &eacutecrit le <?php echo $com['Creation_date']; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<div class="jumbotron col-md-12">
<table class="table table-hover">
    <thead>
        <tr class="success">
            <th>#</th>
            <th>Name</th>
            <th>Note</th>
            <th>Code postal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $statement = $db->prepare("SELECT Eta_ID,AdCodePostal FROM Etablissements WHERE Exists (SELECT * FROM Restaurants WHERE Rest_ID = Eta_ID)");
        $statement->execute(array());
        $index = 1;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
                echo "<td>".$index++."</td>";
                echo '<td> <a href="?actual='.$row["Eta_ID"].'">'.$row["Eta_ID"].'</a></td>';
                // note moyenne
                $statement1 = $db->prepare("SELECT AVG(Score) AS Note FROM Commentaires WHERE EXISTS(SELECT * FROM Descriptions WHERE Des_ID = Com_ID AND Eta_ID = :Eta_ID)");
                $statement1->execute(array("Eta_ID" => $row["Eta_ID"]));
                $note = $statement1->fetch(PDO::FETCH_ASSOC);
                echo "<td>".round($note["Note"],1)."</td>";
                echo "<td>".$row["AdCodePostal"]."</td>";
            echo "</tr>";
        } ?>
    </tbody>
</table>
</div>



<?php include "footer.php"; ?>
