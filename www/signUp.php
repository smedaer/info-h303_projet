<?php

$error = false;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$password_repeated = isset($_POST['password_repeated']) ? $_POST['password_repeated'] : null;

if ($password !== $password_repeated) {
    $password = null;
    $password_repeated = null;
    $error = true;
}

if ($email === null) {
    $error = true;
} else {
    $statement = $db->prepare("SELECT count(*) AS NbEmail FROM user WHERE email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    if ($res['NbEmail'] > 0) {
        $error = true;
    }
}


if (!$error) {
    $statement = $db->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
    $statement->execute(array("email" => $email, "password" => $password));
    header("Location: index.php");
}
?>

<?php include "header.php"; ?>
<div class="row">
    <form action="signUp.php" method="post">

        <div class="col-md-12 form-group">
            <label for="email" class="control-label col-md-3 required">
                Email
            </label>
            <div class="col-md-9">
                <input type="email" class="form-control" name="email" placeholder="Adresse email" value="<?php echo $email ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="password" class="control-label col-md-3 required">
                Mot de passe
            </label>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php echo $password ?>" required>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="password_repeated" class="control-label col-md-3 required">
                verification du mot de passe
            </label>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password_repeated" placeholder="Mot de passe" value="<?php echo $password_repeated ?>" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-3 col-md-offset-6">
                <input type="submit" class="btn btn-success" value="Sauver">
            </div>
        </div>
    </form>
</div>
<?php include "footer.php"; ?>