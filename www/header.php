<?php
session_start();
$search = isset($_POST['search']) ? $_POST['search'] : null;
if ($search){
    header("location: search.php?actual=".$search);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horeca</title>
    <link rel="stylesheet" href="style/boostrap.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<nav class="navbar navbar-default">
    <?-- en-tête --?>
    <div class="row">
        <div class="col-md-2"></div> <?-- décalage --?>
        <div class="col-md-3">
            <a href="/Horeca">
            <img src="Images/logo.png">
            </a> <?-- permet de revenir à l accueil en cliquant sur l img --?>
        </div>
        <div class="col-md-3">
            <h3>Recherche:</h3>
            <form action="#" method="post" class="form-horizontal">
                <input class="form-control" name="search" placeholder="Recherche" value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary">Chercher</button>
            </form>
        </div>
        <div class="col-md-3">
            <?php if(!isset($_SESSION["User_ID"])){ ?>
                <br><br>
                <a href="signIn.php" class="btn btn-info">sign in</a>
                <a href="signUp.php" class="btn btn-info">sign up</a>
            <?php }
            else { ?>
                <br> vous &ecirc;tes connect&eacute;s au compte: &nbsp; <?php echo  '<a class="users" href="user.php?actual='.$_SESSION["User_ID"].'">'.$_SESSION["User_ID"].'</a><br>';?>
                <a href="signOut.php" class="btn btn-info">sign out</a>
                <?php } ?>
        </div>
    </div>
</nav>
<div class="container">

