<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horeca</title>
    <link rel="stylesheet" href="style/boostrap.min.css">
    <link rel="stylesheet" href="style/custom.css">
</head>
<body>
<nav class="navbar navbar-default">
    <?-- en-tête -->
    <div class="row">
        <div class="col-md-2"></div> <?-- décalage -->
        <div class="col-md-6">
            <a href="/Horeca">
            <img src="Images\logo.png" alt="Horeca"><br>
            </a> <?-- permet de revenir à l accueil en cliquant sur l img -->
        </div>
        <div class="col-md-3">
            <?php if(!isset($_SESSION["ID"])){ ?>
                <br><br>
                <a href="signIn.php" class="btn btn-info">sign in</a>
                <a href="signUp.php" class="btn btn-info">sign up</a>
            <?php }
            else {
                ?> <br>
                <?php
                echo "vous etes connectes au compte: " . $_SESSION["Name"];
                ?>
                <br>
                <a href="signOut.php" class="btn btn-info">sign out</a>
                <?php } ?>
        </div>
    </div>
</nav>
<div class="container">
