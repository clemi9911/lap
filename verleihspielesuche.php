
<html>
<meta charset="utf8">
<head>
  <title>Spiele Verleih</title>
</head>
<body>
Die Suche ergibt:

<?php               
	// 1. Werte aus Formular abfragen  
	
	$Suche  	= $_POST['suche'];
	
	
	// 2. Datenbank Verbindung aufbauen
	
	$connection = new PDO("mysql:host=127.0.0.1:3308;dbname=spieleverleih", "root", "");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//Kunden suchen wie die Eingabe
	$selectAllUsersWithAttribute =
        "SELECT * FROM spiele WHERE spielname LIKE ?;";
    $stmt = $connection->prepare($selectAllUsersWithAttribute);
	
    //$stmt->execute(['%' . $_POST['suche'] . '%']);  so ginge es ohne der Variable Suche
	$stmt->execute(['%' . $Suche . '%']);

    $result = $stmt->fetchAll();

//Ausgabe in Form einer Tabelle
	foreach ($result as $row) {
		echo '<table border="1">';
		echo '<tr><td>SpieleID</td><td>Spielname</td></tr>';  
		echo "<tr><td>" . $row['spieleID'] .  '</td><td>' . $row['spielname'].'</td></tr>';
	}
	echo '</table>';
	
?>
</body>
</html>
