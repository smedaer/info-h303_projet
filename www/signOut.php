<?php
include "header.php";
unset($_SESSION["User_ID"]);
unset($_SESSION["Email"]);
session_destroy();
header("Location: index.php");

include "footer.php"
?>
<body>
