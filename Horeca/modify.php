<?php
include "header.php";
include "connection.php";

$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$Eta_ID = isset($_GET["Eta_ID"]) ? $_GET["Eta_ID"] : null;
$modified = isset($_GET["modified"]) ? $_GET["modified"] : false;
$AdRue = isset($_POST["AdRue"]) ? $_POST["AdRue"] : null;
$AdNumero = isset($_POST["AdNumero"]) ? intval($_POST["AdNumero"]) : null;
$AdCodePostal = isset($_POST["AdCodePostal"]) ? intval($_POST["AdCodePostal"]) : null;
$AdCity = isset($_POST["AdCity"]) ? $_POST["AdCity"] : null;
$Longitude = isset($_POST["Longitude"]) ? floatval($_POST["Longitude"]) : null;
$Latitude = isset($_POST["Latitude"]) ? floatval($_POST["Latitude"]) : null;
$Tel = isset($_POST["Tel"]) ? $_POST["Tel"] : null;
$Site = isset($_POST["Site"]) ? $_POST["Site"] : null;
$Prix = isset($_POST["Prix"]) ? floatval($_POST["Prix"]) : null;
$Couverts = isset($_POST["Couverts"]) ? intval($_POST["Couverts"]) : null;
$Emporter = isset($_POST["Emporter"]) ? intval($_POST["Emporter"]) : null;
$Livraison = isset($_POST["Livraison"]) ? intval($_POST["Livraison"]) : null;
$Fermeture = isset($_POST["Fermeture"]) ? $_POST["Fermeture"] : null;
$Fumeur = isset($_POST["Fumeur"]) ? intval($_POST["Fumeur"]) : null;
$Restauration = isset($_POST["Restauration"]) ? intval($_POST["Restauration"]) : null;
$Chambres = isset($_POST["Chambres"]) ? intval($_POST["Chambres"]) : null;
$Etoiles = isset($_POST["Etoiles"]) ? intval($_POST["Etoiles"]) : null;
$openings = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$Fermeture = "";
for ($i=0;$i<14;$i++){
    if (isset($_POST["openings_".$i])){
        $openings[$i] = $_POST['openings_' . $i];
        $Fermeture.=($openings[$i]==='on'? '1' : '0').'/';
    } else {$Fermeture.="0/";}
}
$Fermeture = substr($Fermeture,0,-1);
$errorMsg = null;

if ($modified){
    var_dump($Fermeture);
    $statement = $db->prepare("UPDATE Etablissements SET AdRue=:AdRue, AdNumero=:AdNumero, AdCodePostal=:AdCodePostal, AdCity=:AdCity, Longitude=:Longitude, Latitude=:Latitude, Tel=:Tel, Site=:Site WHERE Eta_ID = :Eta_ID");
    $statement->execute(array("Eta_ID" => $Eta_ID, "AdRue" => $AdRue, "AdNumero" => $AdNumero, "AdCodePostal" => $AdCodePostal, "AdCity" => $AdCity, "Longitude" => $Longitude, "Latitude" => $Latitude, "Tel" => $Tel, "Site" => $Site));
    if ($actual === 'restaurant'){
        $statement = $db->prepare("UPDATE Restaurants SET Prix=:Prix, Couverts=:Couverts, Emporter=:Emporter, Livraison=:Livraison, Fermeture=:Fermeture WHERE Rest_ID=:Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID,"Prix" => $Prix, "Couverts" => $Couverts, "Emporter" => $Emporter, "Livraison" => $Livraison, "Fermeture" => $Fermeture));
        // manque demi jours de fermeture
    }
    elseif ($actual === 'coffee'){
        $statement = $db->prepare("UPDATE Cafes SET Fumeur=:Fumeur, Restauration=:Restauration WHERE Cafe_ID=:Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID,"Fumeur" => $Fumeur, "Restauration" => $Restauration));
    }
    else{
        $statement = $db->prepare("UPDATE Hotels SET Prix=:Prix, Chambres=:Chambres, Etoiles=:Etoiles WHERE Hot_ID=:Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID,"Prix" => $Prix, "Chambres" => $Chambres, "Etoiles" => $Etoiles));
    }
    header('location: ');
}

else{
    $modified = true;
    // on récupère les anciennes données
    if ($actual === 'restaurant'){
        $statement = $db->prepare("SELECT AdRue,AdNumero,AdCodePostal,AdCity,Longitude,Latitude,Tel,Site,Prix,Couverts,Emporter,Livraison,Fermeture FROM Etablissements E, Restaurants R WHERE E.Eta_ID = :Eta_ID AND R.Rest_ID = :Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID));
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        $Prix = $res["Prix"];
        $Emporter = $res["Emporter"];
        $Couverts = $res["Couverts"];
        $Livraison = $res["Livraison"];
        $Fermeture = $res["Fermeture"];
    } else if ($actual === 'coffee'){
        $statement = $db->prepare("SELECT AdRue,AdNumero,AdCodePostal,AdCity,Longitude,Latitude,Tel,Site,Fumeur,Restauration FROM Etablissements E, Cafes C WHERE E.Eta_ID = :Eta_ID AND C.Cafe_ID = :Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID));
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        $Fumeur = $res["Fumeur"];
        $Restauration = $res["Restauration"];
    } else {
        $statement = $db->prepare("SELECT AdRue,AdNumero,AdCodePostal,AdCity,Longitude,Latitude,Tel,Site,Prix,Chambres,Etoiles FROM Etablissements E, Hotels H WHERE E.Eta_ID = :Eta_ID AND H.Hot_ID = :Eta_ID");
        $statement->execute(array("Eta_ID" => $Eta_ID));
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        $Prix = $res["Prix"];
        $Chambres = $res["Chambres"];
        $Etoiles = $res["Etoiles"];
    }
    $AdRue = $res["AdRue"];
    $AdNumero = $res["AdNumero"];
    $AdCodePostal = $res["AdCodePostal"];
    $AdCity = $res["AdCity"];
    $Longitude = $res["Longitude"];
    $Latitude = $res["Latitude"];
    $Tel = $res["Tel"];
    $Site = $res["Site"];
}
function entry($varName,$placeHolder,$var,$type,$size){
    echo '<div class="col-md-12 form-group col-md-offset-1">';
        echo '<label for="'.$varName.'" class="control-label col-md-4 required">';
            echo '<font style="font-size:130%;"><strong>'.$placeHolder.'</strong></font>';
        echo '</label>';
        echo '<div class="col-md-5">';
            echo '<input size="'.$size.'" type="'.$type.'class="form-control" name="'.$varName.'" placeholder="'.$placeHolder.'" value="'.$var.'" required autofocus>';
        echo '</div>';
    echo '</div>';
}
function yesOrNo($varName,$var, $placeHolder){?>
    <div class="radio form-group col-md-12 col-md-offset-1 required">
        <div class="col-md-4">
            <font style="font-size:130%;"><strong><?php echo $placeHolder;?></strong></font>
        </div>
        <div class="col-md-8">
            <label>
                <input type="radio" name=<?php echo $varName;?> id="1" value="0" <?php echo (!$var ? "checked=''" : null);?>>
                Non
            </label>
            <label>
                <input type="radio" name=<?php echo $varName;?> id="2" value="1" <?php echo ($var ? "checked=''" : null);?>>
                Oui
            </label>
        </div>
    </div>
<?php }

function entryClosedDays($var){
    for ($i=0;$i<7;$i++) {
        echo '<div class="checkbox col-md-12 col-md-offset-3">';
            echo '<label>';
                $day = "";
                switch(intval($i)){
                    case 0:
                        $day.="lundi ";
                        break;
                    case 1:
                        $day.="mardi ";
                        break;
                    case 2:
                        $day.="mercredi ";
                        break;
                    case 3:
                        $day.="jeudi ";
                        break;
                    case 4:
                        $day.="vendredi ";
                        break;
                    case 5:
                        $day.="samedi ";
                        break;
                    case 6:
                        $day.="dimanche ";
                }?>
                <div class='col-md-4'><?php echo $day ?> </div>
                <div class='col-md-3 col-md-offset-1'><input type='checkbox' name='openings_<?php echo $i*2; ?>' value='on' <?php echo ($var[$i*4]? "checked":null)?>> matin</div>
                <div class='col-md-3 col-md-offset-1'><input type='checkbox' name='openings_<?php echo ($i*2)+1; ?>' value='on' <?php echo ($var[($i*4)+2]? "checked":null)?>> aprem</div>
            </label>
        </div><?php
    }
}

?>
<body>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $Eta_ID ?></h3>
    </div>
    <div class="panel-body">
        <form action=<?php echo '"modify.php?actual='.$actual.'&Eta_ID='.$Eta_ID.'&modified='.$modified.'"';?> method="post">
            <?php
            // entry(varName,placeHolder,var,entryType,entryLength)
            entry('AdRue','Rue',$AdRue,'text','50');
            entry('AdNumero','N&deg;',$AdNumero,'number','5');
            entry('AdCodePostal','Code postal',$AdCodePostal,'number','5');
            entry('AdCity','Ville',$AdCity,'text','50');
            entry('Longitude','Longitude en d&eacute;cimal',$Longitude,'number','20');
            entry('Latitude','Latitude en d&eacute;cimal',$Latitude,'number','20');
            entry('Tel','T&eacute;l&eacute;phone',$Tel,'tel','20');
            entry('Site','Site internet',$Site,'text','50');
            if ($actual === 'restaurant'){
                entry('Prix','Prix moyen',$Prix,'money','5');
                entry('Couverts','Couverts maximum',$Couverts,'number','5');
                yesOrNo('Emporter',$Emporter,'Peut-on emporter?');
                yesOrNo('Livraison',$Livraison,'Livrez-vous?');
                entryClosedDays($Fermeture);
            }
            elseif ($actual === 'coffee'){
                yesOrNo('Fumeur',$Fumeur,'Espace fumeur?');
                yesOrNo('Restauration',$Restauration,'Server-vous &agrave; manger?');
            }
            else{
                entry('Prix','Prix moyen',$Prix,'money','5');
                entry('Chambres','Nombre de chambre(s)',$Chambres,'number','5');
                entry('Etoiles',"Nombre d'&eacute;toiles?",$Etoiles,'number','3');
            }
            ?>
            <div class="col-md-12">
                <div class="col-md-3 col-md-offset-5">
                    <input type="submit" class="btn btn-success" value="Modifier">
                </div>
                <font color="red"><br><br><?php echo $errorMsg; ?></font>
            </div>
        </form>
    </div>
</div>
<?php include "footer.php"; ?>


