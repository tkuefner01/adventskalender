<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th, img {
    border: none;
    padding: 0px;
	margin: 0px;
}

th {text-align: left;}
</style>
</head>
<body>
<? include("config.php");?>	
<?php
$q = intval($_GET['q']);

$con = mysqli_connect($db['host'],$db['user'],$db['password'],$db['database']);
if (!$con) {
    die('keine Verbindung zur Datenbank: ' . mysqli_error($con));
}

mysqli_select_db($con,$db['database']);
$sql="SELECT * FROM kalender WHERE tag = '".$q."'";
$result = mysqli_query($con,$sql);

echo "<table>";
echo "<tr>
<td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneText.jpg\" width=\"190\" height=\"190\"></td><td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneSponsoren.jpg\" width=\"190\" height=\"190\"></td>";
/** while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['Tag'] . "</td>";
    echo "<td>" . $row['Gewinn'] . "</td>";
    echo "<td>" . $row['ID'] . "</td>";
    echo "<td>" . $row['Link'] . "</td>";
	echo "<td>" . $row['Nummer'] . "</td>";
	echo "<td>" . $row['Sponsor'] . "</td>";
    echo "</tr>";
} +*/
echo "</table>";
mysqli_close($con);
?>
</body>
</html>