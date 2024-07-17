<?php
//database connection
$hostser = "localhost";
$usern = "root"; //"sorasvie";
$passw = ""; //"aABic@''123de1?";
$dbname = "ussddev"; //"sorasvie_svap";

mysql_connect($hostser,$usern,$passw)or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host='.$hostser.';dbname='.$dbname, $usern, $passw);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

?>