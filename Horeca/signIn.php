<?php
include "header.php";
include "connection.php";

$error = false;
$errorMsg = null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if ($email === null) {
    $error = true;
} else {
    $statement = $db->prepare("SELECT User_ID,PSWD,Is_Admin FROM Users WHERE Email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) != 1) {
        $error = true;
        $errorMsg = "Error: Cet email n'appartient a aucun compte!";
    }
    else {
        if ($password != $res[0]["PSWD"]){
            $error = true;
            $errorMsg = "Error: Mot de passe incorrect!";
        }
    }
    if (!$error) {
        // connection
        $_SESSION["User_ID"] = $res[0]["User_ID"];
        $_SESSION["Email"] = $email;
        $_SESSION["Is_Admin"] = $res[0]["Is_Admin"];
        header("Location: index.php");
}
}


?>
<body class="signInPage">
<br><br><br><br><br>
<div class="row">
    <form action="signIn.php" method="post">
        <div class="col-md-9 col-md-offset-3 form-group">
            <label for="email" class="control-label col-md-3">
                <p style="color:white">Email</p>
            </label>
            <div class="col-md-5">
                <input type="email" class="form-control" size="5" name="email" placeholder="Adresse email" value="<?php echo $email ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-9 col-md-offset-3 form-group">
            <label for="password" class="control-label col-md-3">
                <p style="color:white">Mot de passe</p>
            </label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php echo $password ?>" required>
            </div>
        </div>
        <div class="col-md-2 col-md-offset-5">
            <div class="col-md-3 col-md-offset-5">
                <input type="submit" class="btn btn-success" value="Sauver">
            </div>
            <font color="red"><br><?php echo $errorMsg; ?></font>
        </div>
    </form>
</div>
<?php include "footer.php"; ?>
