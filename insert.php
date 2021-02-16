
<html>
<meta charset="utf8">
<head>
  <title>Spiele Verleih</title>
</head>
<body>
Inserts:

<?php               
	
	
	//$Spielname  	= $_POST['spielname'];
	
	//die IDs in Variable speichern
	$neuSpielname['spielname']  	= $_POST['spielname'];
	$neuSpielname['preis']  		= $_POST['preis'];
	
	
	// 2. Datenbank Verbindung aufbauen
	$connection = new PDO("mysql:host=127.0.0.1:3308;dbname=spieleverleih", "root", "");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//Spielname einfügen und preis
    $insert =
        "INSERT INTO spiele(spielname,preis) VALUES(:spielname, :preis);";
    
	//Spielname ausgeben 
	$getValue = "SELECT * FROM spiele WHERE spielname = ? ORDER BY spieleID DESC LIMIT 1;";
	
    $stmt = $connection->prepare($insert);
	$stmt->execute($neuSpielname);


    $stmt = $connection->prepare($getValue);
	$stmt->execute([$_POST['spielname']]);		//nicht die Variable neuSpielname verwenden
    $result = $stmt->fetchAll();
	
	//Ausgabe
	echo "Der Spielname " . $result[0]['spielname'] . " wurde mit der ID " . $result[0]['spieleID'] .  " und dem Preis von " . $result[0]['preis'] . "€ eingefügt";
	 

?>
</body>
</html>
