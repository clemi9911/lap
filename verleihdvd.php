<html>
<head>
  <title>DVD Verleih</title>
</head>
<body>
Aktuelle Verleihvorgänge

<?php               // Die Schritte sind mit nummerierung makiert.
	// 1. Werte aus Formular abfragen  (nicht zwingend notwendig ist nur Prüfung sozusagen)
	// var_dump($_GET);
	// var_dump($_POST);
	
	$KundenID	= $_POST['kunde'];  // Das ist notwendig hier wird eine Variabel -> KundenID und DvdID erstellt und wichtig mit der ID vom
									// Formular angegebe wie man sieht 'kunde' und 'dvd' das ist die ID VOM FORMULAR.HTML
	$DvdID		= $_POST['dvd'];
	
	// Werte prüfen			kann man machen muss man nicht, wird unten geprüft
	// empty($KundenID)	=> true, wenn null, '', 0
	// is_numeric($KundenID) => true, wenn Zahl
	
	
	// 2. Datenbank Verbindung aufbauen
	$DB_Server = '127.0.0.1:3308';   //Wichtig du musst schauen wie dein Server heißt das steht bei MySQLWorkbench Connections unterm root
	$DB_User = 'root';
	$DB_Pass = '';
	$DB_Name = 'dvdverleih';			//Sehr wichtig name der DB!
	// 3. DB-Verbindung aufbauen
	$mysqli = new mysqli($DB_Server, $DB_User, $DB_Pass, $DB_Name);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} //Wenn es erfolgreich war ging es sonst kommt die Meldung vom Echo

	// 4. Datenbank abfragen
	$sql = 'SELECT dvds.*, verleih.*, kunde.* FROM verleih';
	$sql .= ' INNER JOIN kunde ON verleih.KUNDE_kundenID=kunde.kundenID';
	$sql .= ' INNER JOIN dvds ON verleih.DVDS_dvdID=dvds.dvdID';
	$sql .= ' WHERE 1';
	// 5. wenn Kundenid nicht LEER und einen Zahl (SQL-Injection) dann anfügen			Hier wird einfach geprüft ob etwas drin steht und es eine Zahl ist
	if (!empty($KundenID) && is_numeric($KundenID)) $sql .= ' AND kunde.KundenID='.$KundenID;
	// 6. wenn DvdID nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	if (!empty($DvdID) && is_numeric($DvdID)) $sql .= ' AND dvds.dvdID='.$DvdID;

	// SELECT * FROM dvds INNER JOIN verleih ON verleih.DVDS_dvdID=dvds.dvdID 
	// WHERE verleih.Retourdatum is NULL 			Das wäre ein Select für alle Dvds die noch nicht Retour gekommen sind also noch ausgeliehen
													//Den Join oben bei Punkt 4. brauchst du aber immer damit du auf verleih zugfreifen kannst und kunde und dvds
	
	// 7. Query an DB senden
	$res = $mysqli->query($sql);

	// 8. Ergebnis als Tabelle formatiert ausgeben
	echo '<table border="1">';
	echo '<tr><td>Kunde</td><td>Dvd</td><td>Verleihdatum</td><td>Retourdatum</td></tr>';  		//Das sind die Spalten der Tabelle: Kunde - Dvd - Verleihdatum - Retourdatum
	while ($row = $res->fetch_assoc()) 
	{
		echo "<tr><td>" . $row['Nachname'] .' '. $row['Vorname']. '</td><td>'.$row['Titel']. '</td><td>'.$row['Verleihdatum'].'</td><td>'.$row['Retourdatum'].'</td></tr>';
		//Hier hab ich mich gespielt wie du siehst, ich habe zusätzlich das Verleih und Retourdatum ausgegeben, 
		//was ausgegeben werden muss, steht wsl in den Angaben
		
		//Unter dem Kommentar wären nur Nachname - Vorname und Titel, dann musst du aber oben die Spalten Verleihdatum und Retourdatum löschen
		//echo "<tr><td>" . $row['Nachname'] .' '. $row['Vorname']. '</td><td>'.$row['Titel'].'</td></tr>';
	}
	echo '</table>';
	// 9. Datenbank schliessen
	$mysqli->close();
?>
</body>
</html>