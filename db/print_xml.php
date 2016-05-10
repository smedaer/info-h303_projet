<html>
<body>

<?php
$files = array("Restaurants.xml", "Cafes.xml");
foreach ($files as $file_name) {
	$xml=simplexml_load_file($file_name) or die("Error: Cannot create object");
	foreach($xml->children() as $cafe) {
		echo "------------------------------------------------------<br>";
		echo "Admin: " . $cafe['nickname'];
		echo "<br>";
		echo "Date de création: " . $cafe['creationDate'];
		echo "<br>";
		if ($cafe->Informations) {
			echo "<br>";
			echo "Nom de l'établissement: " . $cafe->Informations->Name . "<br>";
			echo "<br>";
			echo "---Adresse---:<br>";
			echo "Rue: " . $cafe->Informations->Address->Street . "<br>";
			echo "Numéro: " . $cafe->Informations->Address->Num . "<br>";
			echo "Code Postal: " . $cafe->Informations->Address->Zip . "<br>";
			echo "Ville: " . $cafe->Informations->Address->City . "<br>";
			echo "Longitude: " . $cafe->Informations->Address->Longitude . "<br>";
			echo "Latitude: " . $cafe->Informations->Address->Latitude . "<br>";
			if ($cafe->Informations->Site) {
				echo "<br>";
				echo "site web: " . $cafe->Informations->Site['link'];
				echo "<br>";
			}
			echo "<br>";
			echo "Numéro de tel: " . $cafe->Informations->Tel . "<br>";
			if ($cafe->Informations->Closed) {
				echo "<br>";
				echo "Jours de fermeture: ";
				echo "<br>";
				foreach($cafe->Informations->Closed->children() as $closed) {
					echo $closed['day'];
					if ($closed['hour']) {
						echo ", " . $closed['hour'];
					}
					echo "<br>";
				}
				echo "<br>";
			}
			if ($cafe->Informations->Smoking) {
				echo "<br>";
				echo "FUMEUR AUTORISE";
				echo "<br>";
			}
			if ($cafe->Informations->Snack) {
				echo "<br>";
				echo "PETITE RESTAURATION";
				echo "<br>";
			}
			if ($cafe->Informations->TakeAway) {
				echo "<br>";
				echo "A EMPORTER";
				echo "<br>";
			}
			if ($cafe->Informations->Delivery) {
				echo "<br>";
				echo "LIVRAISON";
				echo "<br>";
			}
			if ($cafe->Informations->PriceRange) {
				echo "<br>";
				echo "Fourchette de prix: " . $cafe->Informations->PriceRange;
				echo "<br>";
			}
			if ($cafe->Informations->Banquet) {
				echo "<br>";
				echo "couverts: " . $cafe->Informations->Banquet['capacity'];
				echo "<br>";
			}
		}
		if ($cafe->Comments) {
			foreach($cafe->Comments->children() as $com) {
				echo "<br>";
				echo "Commentaire: ";
				print($com);
				echo "<br>";
				echo "Détails commentaires: ";
				echo $com['nickname'];
				echo ", ";
				echo $com['date'];
				echo ", ";
				echo $com['score'];
				echo "<br>";
			}
		}
		if ($cafe->Tags) {
			foreach($cafe->Tags->children() as $tag) {
				echo "<br>";
				echo "Tag: " . $tag['name'];
				echo "<br>";
				foreach($tag->children() as $user) {
					echo $user['nickname'];
					echo "<br>";
				}
			}
		}
	} 
}
?>

</body>
</html>
