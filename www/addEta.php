<?php
include "header.php";
include "connection.php";
$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
$Eta_ID = isset($_POST["Eta_ID"]) ? $_POST["Eta_ID"] : null;
$AdRue = isset($_POST["AdRue"]) ? $_POST["AdRue"] : null;
$AdNumero = isset($_POST["AdNumero"]) ? intval($_POST["AdNumero"]) : null;
$AdCodePostal = isset($_POST["AdCodePostal"]) ? intval($_POST["AdCodePostal"]) : null;
$AdCity = isset($_POST["AdCity"]) ? $_POST["AdCity"] : null;
$Longitude = isset($_POST["Longitude"]) ? intval($_POST["Longitude"]) : null;
$Latitude = isset($_POST["Latitude"]) ? intval($_POST["Latitude"]) : null;
$Tel = isset($_POST["Tel"]) ? intval($_POST["Tel"]) : null;
$Site = isset($_POST["Site"]) ? $_POST["Site"] : null;
$Prix = isset($_POST["Prix"]) ? intval($_POST["Prix"]) : null;
$Couverts = isset($_POST["Couverts"]) ? intval($_POST["Couverts"]) : null;
$Emporter = isset($_POST["Emporter"]) ? intval($_POST["Emporter"]) : null;
$Livraison = isset($_POST["Livraison"]) ? intval($_POST["Livraison"]) : null;
$Fumeur = isset($_POST["Fumeur"]) ? intval($_POST["Fumeur"]) : null;
$Restauration = isset($_POST["Restauration"]) ? intval($_POST["Restauration"]) : null;
$Chambres = isset($_POST["Chambres"]) ? intval($_POST["Chambres"]) : null;
$Etoiles = isset($_POST["Etoiles"]) ? intval($_POST["Etoiles"]) : null;


if ($Eta_ID){
    // insert DB
    header('location: index.php');
}

$errorMsg = null;
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
?>
<body>

<div class="jumbotron col-md-12">
    <div class="row">
        <form action="addEta.php" method="post">
            <?php
            // entry(varName,placeHolder,var,entryType,entryLength)
            //entry('Eta_ID','Nom',$Eta_ID,'text','50');
            entry('AdRue','Rue',$AdRue,'text','50');
            entry('AdNumero','N&deg;',$AdNumero,'number','5');
            entry('AdCodePostal','Code postal',$AdCodePostal,'number','5');
            entry('AdCity','Ville',$AdCity,'text','50');
            entry('Longitude','Longitude en d&eacute;cimal',$Longitude,'number','20');
            entry('Latitude','Latitude en d&eacute;cimal',$Latitude,'number','20');
            entry('Tel','T&eacute;l&eacute;phone',$Tel,'tel','20');
            entry('Site internet','Site',$Site,'url','50');
            if ($actual === 'restaurant'){
                entry('Prix','Prix moyen',$Prix,'money','5');
                entry('Couverts','Couverts maximum',$Couverts,'number','5');
                yesOrNo('Emporter','Peut-on emporter?');
                yesOrNo('Livraison','Livrez-vous?');
                // demi jours de fermeture radio
            }
            elseif ($actual === 'hotel'){
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

