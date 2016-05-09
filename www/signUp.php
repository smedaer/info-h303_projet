<?php

include "header.php";
include "connection.php";

$date = isset($_POST['date']) ? $_POST['password'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$password_repeated = isset($_POST['password_repeated']) ? $_POST['password_repeated'] : null;
$error = false;

if ($password !== $password_repeated) {
    $password = null;
    $password_repeated = null;
    $error = true;
}

if ($email === null) {
    $error = true;
} else {
    $statement = $db->prepare("SELECT count(*) AS NbEmail FROM Users WHERE Email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    if ($res['NbEmail'] > 0) {
        $error = true;
        echo "Error: Cet email est deja utilise!"; // met le msg en haut de la page ...
    }
}

if (!$error) {
    //sign up
    $statement = $db->prepare("INSERT INTO Users (Email, PSWD, Creation_Date, Admin, Name) VALUES (:email, :password, :Creation_Date, :Admin, :Name)");
    $statement->execute(array("email" => $email, "password" => $password, "Creation_Date" => (new Datetime())->format('Y-m-d H:i:s'), "Admin" => false, "Name" => $name));

    //connection
    $statement = $db->prepare("SELECT User_ID FROM Users WHERE Email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION["ID"] = $res["User_ID"];
    $_SESSION["Name"] = $name;
    $_SESSION["Email"] = $email;
    header("Location: index.php");
}
?>
<body class="signUpPage">
<br><br><br><br><br>
<div class="row">
    <form action="signUp.php" method="post">

        <div class="col-md-12 form-group">
            <label for="email" class="control-label col-md-3 required">
                Email
            </label>
            <div class="col-md-5">
                <input type="email" class="form-control" name="email" placeholder="Adresse email" value="<?php echo $email ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="name" class="control-label col-md-3 required">
                Nom
            </label>
            <div class="col-md-5">
                <input type="name" class="form-control" name="name" placeholder="Nom" value="<?php echo $name ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="password" class="control-label col-md-3 required">
                Mot de passe
            </label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php echo $password ?>" required>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="password_repeated" class="control-label col-md-3 required">
                verification du mot de passe
            </label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password_repeated" placeholder="Mot de passe" value="<?php echo $password_repeated ?>" required>
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
