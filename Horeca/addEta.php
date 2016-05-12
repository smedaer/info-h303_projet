<?php
include "header.php";
include "connection.php";
$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$Eta_ID = isset($_POST["Eta_ID"]) ? $_POST["Eta_ID"] : null;
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

if ($Eta_ID){
    $statement = $db->prepare("INSERT INTO Etablissements (Eta_ID,AdRue,AdNumero,AdCodePostal,AdCity,Longitude,Latitude,Tel,Site,Creation_date,Admin) VALUES (:Eta_ID,:AdRue,:AdNumero,:AdCodePostal,:AdCity,:Longitude,:Latitude,:Tel,:Site,:Creation_date,:Admin)");
    $statement->execute(array("Eta_ID" => $Eta_ID, "AdRue" => $AdRue, "AdNumero" => $AdNumero, "AdCodePostal" => $AdCodePostal, "AdCity" => $AdCity, "Longitude" => $Longitude, "Latitude" => $Latitude, "Tel" => $Tel, "Site" => $Site, "Creation_date" => (new Datetime())->format('Y-m-d H:i:s'), "Admin" => $_SESSION["User_ID"]));
    if ($actual === 'restaurant'){
        $statement = $db->prepare("INSERT INTO Restaurants (Rest_ID,Prix,Couverts,Emporter,Livraison,Fermeture) VALUES (:Rest_ID,:Prix,:Couverts,:Emporter,:Livraison,:Fermeture)");
        $statement->execute(array("Rest_ID" => $Eta_ID,"Prix" => $Prix, "Couverts" => $Couverts, "Emporter" => $Emporter, "Livraison" => $Livraison, "Fermeture" => $Fermeture));
        // manque demi jours de fermeture
    }
    elseif ($actual === 'coffee'){
        $statement = $db->prepare("INSERT INTO Cafes (Cafe_ID,Fumeur,Restauration) VALUES (:Cafe_ID,:Fumeur,:Restauration)");
        $statement->execute(array("Cafe_ID" => $Eta_ID,"Fumeur" => $Fumeur, "Restauration" => $Restauration));
    }
    else{
        $statement = $db->prepare("INSERT INTO Hotels (Hot_ID,Prix,Chambres,Etoiles) VALUES (:Hot_ID,:Prix,:Chambres,:Etoiles)");
        $statement->execute(array("Hot_ID" => $Eta_ID,"Prix" => $Prix, "Chambres" => $Chambres, "Etoiles" => $Etoiles));
    }
    header('location: index.php');
}

$errorMsg = null;
function entry($varName,$placeHolder,$var,$type,$size,$required=1){
    echo '<div class="col-md-12 form-group col-md-offset-1">';
        echo '<label for="'.$varName.'" class="control-label col-md-4 required">';
            echo '<font style="font-size:130%;"><strong>'.$placeHolder.'</strong></font>';
        echo '</label>';
        echo '<div class="col-md-5">';
            echo '<input size="'.$size.'" type="'.$type.'class="form-control" name="'.$varName.'" placeholder="'.$placeHolder.'" value="'.$var.'"'. ($required ? "required " : null). 'autofocus>';
        echo '</div>';
    echo '</div>';
}
function yesOrNo($varName,$placeHolder){?>
    <div class="radio form-group col-md-12 col-md-offset-1 required">
        <div class="col-md-4">
            <font style="font-size:130%;"><strong><?php echo $placeHolder;?></strong></font>
        </div>
        <div class="col-md-8">
            <label>
                <input type="radio" name=<?php echo $varName;?> id="1" value="0" checked="">
                Non
            </label>
            <label>
                <input type="radio" name=<?php echo $varName;?> id="2" value="1">
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
                }
                echo "<div class='col-md-4'>".$day."</div>";
                echo "<div class='col-md-3 col-md-offset-1'><input type='checkbox' name='openings_" . $i*2 . "' value='on'> matin</div>";
                echo "<div class='col-md-3 col-md-offset-1'><input type='checkbox' name='openings_" . (($i*2)+1)."' value='on'> aprem</div>";
            echo '</label>';
        echo '</div>';
    }
}

?>
<body>

<div class="jumbotron col-md-12">
    <div class="row">
        <form action=<?php echo '"addEta.php?actual='.$actual.'"';?> method="post">
            <?php
            // entry(varName,placeHolder,var,entryType,entryLength)
            entry('Eta_ID','Nom',$Eta_ID,'text','50');
            entry('AdRue','Rue',$AdRue,'text','50');
            entry('AdNumero','N&deg;',$AdNumero,'number','5');
            entry('AdCodePostal','Code postal',$AdCodePostal,'number','5');
            entry('AdCity','Ville',$AdCity,'text','50');
            entry('Longitude','Longitude en d&eacute;cimal',$Longitude,'number','20');
            entry('Latitude','Latitude en d&eacute;cimal',$Latitude,'number','20');
            entry('Tel','T&eacute;l&eacute;phone',$Tel,'tel','20');
            entry('Site','Site internet',$Site,'text','50',0);
            if ($actual === 'restaurant'){
                entry('Prix','Prix moyen',$Prix,'money','5');
                entry('Couverts','Couverts maximum',$Couverts,'number','5');
                yesOrNo('Emporter','Peut-on emporter?');
                yesOrNo('Livraison','Livrez-vous?');
                entryClosedDays($openings);
            }
            elseif ($actual === 'coffee'){
                yesOrNo('Fumeur','Espace fumeur?');
                yesOrNo('Restauration','Server-vous &agrave; manger?');
            }
            else{
                entry('Prix','Prix moyen',$Prix,'money','5');
                entry('Chambres','Nombre de chambre(s)',$Chambres,'number','5');
                entry('Etoiles',"Nombre d'&eacute;toiles?",$Etoiles,'number','3');
            }
            ?>
            <div class="col-md-12">
                <div class="col-md-3 col-md-offset-5">
                    <input type="submit" class="btn btn-success" value="Ajouter">
                </div>
                <font color="red"><br><br><?php echo $errorMsg; ?></font>
            </div>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

