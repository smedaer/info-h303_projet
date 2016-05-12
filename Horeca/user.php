<body>
<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $actual ?></h3>
    </div>
    <div class="panel-body">
        <div class="panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Informations </h2>
            </div>
            <div class="panel-body"> <?php
                $statement = $db->prepare("SELECT Email,Creation_date,Is_Admin FROM Users WHERE User_ID=:actual");
                $statement->execute(array("actual"=>$actual));
                $res = $statement->fetch(PDO::FETCH_ASSOC); ?>
                Email: &nbsp; <?php echo $res["Email"]; ?> <br>
                Cr&eacuteation du compte: &nbsp; <?php echo $res["Creation_date"]; ?> <br>
                Admin: &nbsp; <?php echo ($res["Is_Admin"]? "oui":"non"); ?> <br>
            </div>
        </div>
    </div>
    <!-- un deuxieme body permet un espacement -->
    <div class="panel-body">
        <div class="panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Commentaires </h2>
            </div>
            <div class="panel-body"> <?php
                $statement = $db->prepare("SELECT Eta_ID,Com,Creation_date,Score FROM Descriptions D, Commentaires C WHERE D.User_ID = :actual AND D.Des_ID = C.Com_ID");
                $statement->execute(array("actual"=>$actual));
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){?>
                    <div class='panel-default'>
                        <div class='panel-heading'>
                            <div class='panel-title'><?php echo $row['Eta_ID']; ?> <span class='pull-right'> Note donn&eacutee:&nbsp; <?php echo $row['Score'];?></span></div>
                        </div>
                        <div class='panel-body'>
                            <?php echo $row['Com']; ?> <br>
                            &eacutecrit le <?php echo $row['Creation_date']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
