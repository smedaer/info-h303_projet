<body>
<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo "R&eacute;sultats pour le mot: &nbsp;".$actual; ?></h1>
    </div>
    <div class="panel-body">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">&Eacute;tablissements</h2>
            </div>
            <div class="panel-body">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Restaurants</h3>
                    </div>
                    <div class="panel-body">
                        <?php // Recherche Restaurants
                        $request = "SELECT Eta_ID FROM Etablissements WHERE (Eta_ID LIKE '%".$actual."%') AND (EXISTS(SELECT * FROM Restaurants WHERE Rest_ID = Eta_ID))";
                        $statement = $db->prepare($request);
                        $statement->execute();
                        while ($res = $statement->fetch(PDO::FETCH_ASSOC)){?>
                            <a class="users" href="restaurants.php?actual=<?php echo $res["Eta_ID"]; ?>"><?php echo $res["Eta_ID"]; ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">H&ocirc;tels</h3>
                    </div>
                    <div class="panel-body">
                        <?php // Recherche Hotels
                        $request = "SELECT Eta_ID FROM Etablissements WHERE (Eta_ID LIKE '%".$actual."%') AND (EXISTS(SELECT * FROM Hotels WHERE Hot_ID = Eta_ID))";
                        $statement = $db->prepare($request);
                        $statement->execute(array("actual"=>$actual));
                        while ($res = $statement->fetch(PDO::FETCH_ASSOC)){?>
                            <a class="users" href="hotels.php?actual=<?php echo $res["Eta_ID"]; ?>"><?php echo $res["Eta_ID"]; ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Caf&eacute;s</h3>
                    </div>
                    <div class="panel-body">
                        <?php // Recherche Cafes
                        $request = "SELECT Eta_ID FROM Etablissements WHERE (Eta_ID LIKE '%".$actual."%') AND (EXISTS(SELECT * FROM Cafes WHERE Cafe_ID = Eta_ID))";
                        $statement = $db->prepare($request);
                        $statement->execute(array("actual"=>$actual));
                        while ($res = $statement->fetch(PDO::FETCH_ASSOC)){?>
                            <a class="users" href="cafes.php?actual=<?php echo $res["Eta_ID"]; ?>"><?php echo $res["Eta_ID"]; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Membres sur le site</h2>
            </div>
            <div class="panel-body">
                <?php // Recherche Users
                $request = "SELECT User_ID FROM Users WHERE User_ID LIKE '%".$actual."%'";
                $statement = $db->prepare($request);
                $statement->execute(array("actual"=>$actual));
                while ($res = $statement->fetch(PDO::FETCH_ASSOC)){?>
                    <a class="users" href="user.php?actual=<?php echo $res["User_ID"]; ?>"><?php echo $res["User_ID"]; ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="panel-body">

    </div>
</div>

<?php include "footer.php"; ?>
