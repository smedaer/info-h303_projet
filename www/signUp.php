<?php

include "header.php";
include "connection.php";

$User_ID = isset($_POST['User_ID']) ? $_POST['User_ID'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$password_repeated = isset($_POST['password_repeated']) ? $_POST['password_repeated'] : null;
$error = false;
$errorMsg = null;

if ($password !== $password_repeated) {
    $password = null;
    $password_repeated = null;
    $error = true;
    $errorMsg = "Les mots de passe ne correspondent pas";
}

if ($email === null) {
    $error = true;
} else {
    $statement = $db->prepare("SELECT count(*) AS NbEmail FROM Users WHERE Email = :email");
    $statement->execute(array("email" => $email));
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    if ($res['NbEmail'] > 0) {
        $error = true;
        $errorMsg = "Error: Cet email est deja utilise!";
    }
}

if (!$error) {
    //sign up
    $statement = $db->prepare("INSERT INTO Users (Email, PSWD, Creation_Date, Is_Admin, User_ID) VALUES (:email, :password, :Creation_Date, :Is_Admin, :User_ID)");
    $statement->execute(array("email" => $email, "password" => $password, "Creation_Date" => (new Datetime())->format('Y-m-d H:i:s'), "Is_Admin" => false, "User_ID" => $User_ID));

    //connection
    $_SESSION["User_ID"] = $User_ID;
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
                <input type="name" class="form-control" name="User_ID" placeholder="Nom" value="<?php echo $User_ID ?>" required autofocus>
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
            <font color="red"><br><br><?php echo $errorMsg; ?></font>
        </div>
    </form>
</div>
<?php include "footer.php"; ?>
