
<html>
<meta charset="utf8">
<head>
  <title>Spiele Verleih</title>
</head>
<body>
Aktuelle Verleihvorgänge

<?php               
	// 1. Werte aus Formular abfragen  
	
	$Suche  	= $_POST['suche'];
	
	
	// 2. Datenbank Verbindung aufbauen
	
	$connection = new PDO("mysql:host=127.0.0.1:3308;dbname=spieleverleih", "root", "");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$selectAllUsersWithAttribute =
        "SELECT * FROM spiele WHERE spielname LIKE ?;";
    $stmt = $connection->prepare($selectAllUsersWithAttribute);
	
    //$stmt->execute(['%' . $_POST['suche'] . '%']);
	$stmt->execute(['%' . $Suche . '%']);

    $result = $stmt->fetchAll();

	foreach ($result as $row) {
        echo '<br/>';
        echo $row['spieleID'] . ":" . $row['spielname'];
	}
?>
</body>
</html>
