<?php
include "header.php";
unset($_SESSION["ID"]);
unset($_SESSION["Name"]);
unset($_SESSION["Email"]);
session_destroy();
header("Location: index.php");

include "footer.php"
?>
<body>
