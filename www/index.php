<?php include "header.php";
$delete = isset($_POST['delete']) ? $_POST['delete'] : null;
if ($delete){
    // delete etablissement
    // echo msg (error or success)
}
?>

<body>
    <div class="jumbotron col-md-12">
        <p align="center"><strong>Cliquez sur ce que vous recherchez</strong></p>
        <div class="col-md-4"><button class="restaurants" onclick="location.href='restaurants.php'">Restaurants</button></div>
        <div class="col-md-4"><button class="hotels" onclick="location.href='hotels.php'">Hotels</button></div>
        <div class="col-md-4"><button class="cafes" onclick="location.href='cafes.php'">Cafes</button></div>
        <?php if (isset($_SESSION["Is_Admin"]) and $_SESSION["Is_Admin"]){ ?>
            <br></br><br></br><br></br><br></br><br></br><br></br>
            <p align="center"><strong>Ajouter un &eacute;tablissement</strong></p>
            <div class="col-md-4"><button class="restaurants" onclick="location.href='addEta.php?actual=restaurant'">Restaurants</button></div>
            <div class="col-md-4"><button class="hotels" onclick="location.href='addEta.php?actual=hotel'">Hotels</button></div>
            <div class="col-md-4"><button class="cafes" onclick="location.href='addEta.php?actual=coffee'">Cafes</button></div>
            <br></br><br></br><br></br><br></br><br></br><br></br>
            <p align="center"><strong>Supprimer un &eacute;tablissement</strong></p>
            <form action="#" method="post" class="form-horizontal">
                <div class="col-md-6 col-md-offset-2">
                    <input class="form-control" name="delete" placeholder="&Eacute;tablissement" value="<?php echo $delete; ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                </div>
            </form>
        <?php } ?>
    </div>
<?php include "footer.php"; ?>
