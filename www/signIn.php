<?php
include "header.php";
include "connection.php";

$error = false;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if ($email === null) {
    $error = true;
} else {
    $statement = $db->prepare("SELECT User_ID,Name,PSWD FROM Users WHERE Email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) != 1) {
        $error = true;
        echo "Error: Cet email n'appartient a aucun compte!";
    }
    else {
        if ($password != $res[0]["PSWD"]){
            $error = true;
            echo "Error: Mot de passe incorrect!";
        }
    }
    if (!$error) {
        // connection
        $_SESSION["ID"] = $res[0]["User_ID"];
        $_SESSION["Name"] = $res[0]["Name"];
        $_SESSION["Email"] = $email;
        header("Location: index.php");
}
}


?>

<div class="row">
    <form action="signIn.php" method="post">

        <div class="col-md-12 form-group">
            <label for="email" class="control-label col-md-3">
                Email
            </label>
            <div class="col-md-9">
                <input type="email" class="form-control" name="email" placeholder="Adresse email" value="<?php echo $email ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="password" class="control-label col-md-3">
                Mot de passe
            </label>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php echo $password ?>" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-3 col-md-offset-5">
                <input type="submit" class="btn btn-success" value="Sauver">
            </div>
        </div>
    </form>
</div>
<?php include "footer.php"; ?>
