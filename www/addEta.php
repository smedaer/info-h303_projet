<?php
include "header.php";
include "connection.php"
$actual = isset($_GET["actual"]) ? $_GET["actual"] : null;
?>
<body>
<?php // fonction add etablissement ?>
<?php if ($actual = "restaurant"){}//<form> add eta + add resto </form>
else if ($actual = "hotel"){}//<form> add eta + add hotel </form>
else {} //<form> add eta + add bar </form>?>

<?php include "footer.php"; ?>

