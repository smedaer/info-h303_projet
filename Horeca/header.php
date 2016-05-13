<?php
session_start();
$search = isset($_POST['search']) ? $_POST['search'] : null;
if (isset($_GET["theme"])){$_SESSION["theme"] = $_GET["theme"];}
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';
if ($search){
    header("location: search.php?actual=".$search);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horeca</title>
    <link rel="stylesheet" href="style/<?php echo $theme; ?>.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<nav class="navbar navbar-default">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
            <a href="index.php">
            <img src="Images/logo.png">
            </a>
        </div>
        <div class="col-md-7">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="heardNavBar">
                        <div class="col-md-4">
                        <form action="#" method="post" class="navbar-form" role="search">
                            <div class="form-group">
                                <input class="form-control" name="search" placeholder="Recherche" value="<?php echo $search; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Chercher</button>
                        </form>
                        </div>
                        <div class="col-md-4">
                        <select select name="forma" onchange="location = this.value;" class="form-control" id="select">
                            <option> Theme couleur </option>
                            <option value="?theme=default"> default </option>
                            <option value="?theme=cereluan"> cereluan </option>
                            <option value="?theme=flatly"> flatly </option>
                            <option value="?theme=journal"> journal </option>
                            <option value="?theme=superhero"> superhero </option>
                        </select>
                        </div>
                        <div class="col-md-4">
                        <?php if(!isset($_SESSION["User_ID"])){ ?>
                            <br>
                            <a href="signIn.php" class="btn btn-info">sign in</a>
                            <a href="signUp.php" class="btn btn-info">sign up</a>
                        <?php }
                        else { ?>
                                <br>vous &ecirc;tes connect&eacute;s au compte: &nbsp; <?php echo  '<a class="users" href="user.php?actual='.$_SESSION["User_ID"].'">'.$_SESSION["User_ID"].'</a><br>';?>
                                <a href="signOut.php" class="btn btn-info">sign out</a>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</nav>
<div class="container">

