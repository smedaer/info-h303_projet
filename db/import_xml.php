
<html>
<body>

<?php

//Data connection to server
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "horeca";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

//data xml files to import
$files = array("Restaurants.xml", "Cafes.xml");

//prepare statement to insert into Users table
$user_stmt = $conn->prepare("INSERT INTO Users (User_ID, Email, PSWD, Creation_date, Is_Admin) VALUES (?, ?, ?, ?, ?)");
$user_stmt->bind_param("ssssi", $nickname, $user_email, $user_pswd, $user_date, $admin);

//prepare statement to insert into Etablissements table
$eta_stmt = $conn->prepare("INSERT INTO Etablissements (Eta_ID, AdRue, AdNumero, AdCodePostal, AdCity, Longitude, Latitude, Tel, Site, Creation_date, Admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$eta_stmt->bind_param("ssiisddssss", $eta_name, $eta_street, $eta_num, $eta_zip, $eta_city, $eta_long, $eta_lat, $eta_tel, $eta_site, $eta_date, $nickname);

//prepare statement to insert into Restaurants table
$resto_stmt = $conn->prepare("INSERT INTO Restaurants (Rest_ID, Prix, Couverts, Emporter, Livraison, Fermeture) VALUES (?, ?, ?, ?, ?, ?)");
$resto_stmt->bind_param("siiiis", $eta_name, $resto_price, $resto_banquet, $resto_deli, $resto_ta, $resto_closed);

//prepare statement to insert into Cafes table
$cafe_stmt = $conn->prepare("INSERT INTO Cafes (Cafe_ID, Fumeur, Restauration) VALUES (?, ?, ?)");
$cafe_stmt->bind_param("sii", $eta_name, $cafe_smocking, $cafe_snack);

//prepare statement to insert into Descriptions table
$desc_stmt = $conn->prepare("INSERT INTO Descriptions (User_ID, Eta_ID) VALUES (?, ?)");
$desc_stmt->bind_param("ss", $nickname, $eta_name);

//prepare statement to insert into Labels table
$tag_stmt = $conn->prepare("INSERT INTO Labels (Lab_ID, Label) VALUES (?, ?)");
$tag_stmt->bind_param("is", $last_id, $tag_name);

//prepare statement to insert into Commentaires table
$com_stmt = $conn->prepare("INSERT INTO Commentaires (Com_ID, Com, Creation_date, Score) VALUES (?, ?, ?, ?)");
$com_stmt->bind_param("issi", $last_id, $com, $com_date, $com_score);

$admins = array();

foreach ($files as $file_name) {

	$xml=simplexml_load_file($file_name) or die("Error: Cannot create object");
	$user_date = "2000-01-01";

	foreach($xml->children() as $etab) {
		$nickname = $etab['nickname'];
		$user_email = $nickname . "@gmail.com";
		$user_pswd = $nickname . "pswd";
		$admin = TRUE;
		$user_stmt->execute();

		$eta_date = $etab['creationDate'];
		//conversion DATE data type sql format
		$temp_eta_date = str_replace('/', '-', $eta_date);
		$eta_date = date('Y-m-d', strtotime($temp_eta_date));

		if ($etab->Informations) {

			$eta_name = $etab->Informations->Name;

			$eta_street = $etab->Informations->Address->Street;
			$eta_num = $etab->Informations->Address->Num;
			$eta_zip = $etab->Informations->Address->Zip;
			$eta_city = $etab->Informations->Address->City;
			$eta_long = $etab->Informations->Address->Longitude;
			$eta_lat = $etab->Informations->Address->Latitude;

			if ($etab->Informations->Site) {
				$eta_site = $etab->Informations->Site['link'];
			}

			$eta_tel = $etab->Informations->Tel;
			$eta_stmt->execute();

			if ($etab->Informations->Closed) {
				$temp_resto_closed = Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
				foreach($etab->Informations->Closed->children() as $closed) {
					$day = $closed['day'];
					//store closed half day in an array
					if ($closed['hour']) {
						$hour = $closed['hour'];
						if ($hour=="am") {
							$temp_resto_closed[2*$day] = '1';
						} else {
							$temp_resto_closed[2*$day+1] = '1';
						}
					} else {
						$temp_resto_closed[2*$day] = '1';
						$temp_resto_closed[2*$day+1] = '1';
					}
				}
				//convert array to string
				$resto_closed = implode('/', $temp_resto_closed);
			}
			if ($etab->Informations->Smoking) {
				$cafe_smocking = TRUE;
			} else {
				$cafe_smocking = FALSE;
			}
			if ($etab->Informations->Snack) {
				$cafe_snack = TRUE;
			} else {
				$cafe_snack = FALSE;
			}
			if ($etab->Informations->TakeAway) {
				$resto_ta = TRUE;
			} else {
				$resto_ta = FALSE;
			}
			if ($etab->Informations->Delivery) {
				$resto_deli = TRUE;
			} else {
				$resto_deli = FALSE;
			}
			if ($etab->Informations->PriceRange) {
				$resto_price = $etab->Informations->PriceRange;
			}
			if ($etab->Informations->Banquet) {
				$resto_banquet = $etab->Informations->Banquet['capacity'];
			}
		}	

		if ($file_name=="Restaurants.xml") {
			$resto_stmt->execute();
		} else {
			$cafe_stmt->execute();
		}

		if ($etab->Comments) {
			foreach($etab->Comments->children() as $com) {
				$nickname = $com['nickname'];
				//check if user is an admin
				if ($nickname=='Boris' or $nickname=='Fred') {
					$admin = TRUE;
				} else {
					$admin = FALSE;
				}
				$com_date = $com['date'];
				//conversion DATE data type sql format
				$temp_com_date = str_replace('/', '-', $com_date);
				$com_date = date('Y-m-d', strtotime($temp_com_date));
				$com_score = $com['score'];
				$user_email = $nickname . "@gmail.com";
				$user_pswd = $nickname . "pswd";
				//$user_stmt->execute();
				$desc_stmt->execute();
				$last_id = $conn->insert_id;
				$com_stmt->execute();			
			}
		}

		if ($etab->Tags) {
			foreach($etab->Tags->children() as $tag) {
				$tag_name = $tag['name'];
				foreach($tag->children() as $user) {
					$nickname = $user['nickname'];
					//check if user is an admin
					if ($nickname=='Boris' or $nickname=='Fred') {
						$admin = TRUE;
					} else {
						$admin = FALSE;
					}
					$user_email = $nickname . "@gmail.com";
					$user_pswd = $nickname . "pswd";
					$user_stmt->execute();
					$desc_stmt->execute();
					$last_id = $conn->insert_id;
					$tag_stmt->execute();
				}
			}
		}
	} 
}

//Closing prepare statement
$com_stmt->close();
$tag_stmt->close();
$desc_stmt->close();
$cafe_stmt->close();
$resto_stmt->close();
$eta_stmt->close();
$user_stmt->close();

//Closing server connection
$conn->close();
?>

</body>
</html>
