
<html>
<meta charset="utf8">
<head>
  <title>Spiele Verleih</title>
</head>
<body>
Aktuelle Verleihvorgänge

<?php               
	// 1. Werte aus Formular abfragen  
	
	$KundenID	= $_POST['kunde'];  // Das ist notwendig hier wird eine Variabel -> KundenID und DvdID erstellt und wichtig mit der ID vom
									// Formular angegebe wie man sieht 'kunde' und 'dvd' das ist die ID VOM FORMULAR.HTML
	$SpieleID	= $_POST['spiel'];
	$Suche  	= $_POST['suche'];
	
	
	// 2. Datenbank Verbindung aufbauen
	$DB_Server = '127.0.0.1:3308';   //Wichtig du musst schauen wie dein Server heißt das steht bei MySQLWorkbench Connections unterm root
	$DB_User = 'root';
	$DB_Pass = '';
	$DB_Name = 'spieleverleih';			//Sehr wichtig name der DB!
	// 3. DB-Verbindung aufbauen
	$mysqli = new mysqli($DB_Server, $DB_User, $DB_Pass, $DB_Name);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} //Wenn es erfolgreich war ging es sonst kommt die Meldung vom Echo

	// 4. Datenbank abfragen
	// Abfrage 1 alle Verleihe von x KundenID und x SpieleID
	 $sql = 'SELECT spiele.*, verleih.*, kunde.* FROM verleih';
	$sql .= ' INNER JOIN kunde ON verleih.KUNDE_kundeID=kunde.kundeID';
	$sql .= ' INNER JOIN spiele ON verleih.SPIELE_spieleID=spiele.spieleID';
	$sql .= ' WHERE 1'; 
	
	 //5. wenn Kundenid nicht LEER und einen Zahl (SQL-Injection) dann anfügen			Hier wird einfach geprüft ob etwas drin steht und es eine Zahl ist
	if (!empty($KundenID) && is_numeric($KundenID)) $sql .= ' AND kunde.KundeID='.$KundenID;
	 //6. wenn DvdID nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	if (!empty($DvdID) && is_numeric($SpieleID)) $sql .= ' AND spiele.spieleID='.$SpieleID;

		//Prüfung halt unter dem jeweiligen select
		//Abfrage 2 alle angezeigt die noch verliehen sind nicht zurückgegeben
	/*$sql = 'SELECT spiele.*, verleih.*, kunde.* FROM verleih';
	$sql .= ' INNER JOIN kunde ON verleih.KUNDE_kundeID=kunde.kundeID';
	$sql .= ' INNER JOIN spiele ON verleih.SPIELE_spieleID=spiele.spieleID';
	$sql .= ' WHERE verleih.retourdatum is NULL';*/

	
	// 7. Query an DB senden
	$res = $mysqli->query($sql);

	// 8. Ergebnis als Tabelle formatiert ausgeben
	echo '<table border="1">';
	echo '<tr><td>Kunde</td><td>Spiel</td><td>Verleihdatum</td><td>Retourdatum</td></tr>';  		//Das sind die Spalten der Tabelle: Kunde - Dvd - Verleihdatum - Retourdatum
	while ($row = $res->fetch_assoc()) 
	{
		echo "<tr><td>" . $row['nachname'] .' '. $row['vorname']. '</td><td>'.$row['spielname']. '</td><td>'.$row['verleihdatum'].'</td><td>'.$row['retourdatum'].'</td></tr>';
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
