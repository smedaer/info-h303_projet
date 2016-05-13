<?php include "header.php";
include "connection.php";?>

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
    <?php } ?>
</div>
<?php include "footer.php"; ?>
