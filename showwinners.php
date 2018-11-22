<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2248235-7', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<? include("config.php");?>	
<?php
$q = intval($_GET['q']);
$con = mysqli_connect($db['host'],$db['user'],$db['password'],$db['database']);
if (!$con) {
    die('keine Verbindung zur Datenbank: ' . mysqli_error($con));
}

mysqli_set_charset($con, "utf8");
mysqli_select_db($con,$db['database']);

if ($q==1919) {$sql="SELECT Datum, Nummer,Gewinn, Sponsor FROM kalender ORDER BY Tag";
$result = mysqli_query($con,$sql);

	echo "<table width=\"450\">";
	echo "<th>Datum</th><th>Losnummer</th><th>Gewinn</th><th>Sponsor</th>";
	while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row['Datum'] . "</td>";
			echo "<td>" . $row['Nummer'] . "</td>";
			echo "<td>" . $row['Gewinn'] . "</td>";
			echo "<td>" . $row['Sponsor'] . "</td>";
			echo "</tr>";
		}
	echo "</table>";

}

if (mysqli_real_escape_string ($con,$q )==0) {
echo "<table width=\"450\">";
echo "<tr><td>Für dieses Datum liegt keine Ziehung vor</td></tr>";
echo "</table>";
}
else
{

$sql="SELECT Nummer,Gewinn, Sponsor FROM kalender WHERE (datum='2017-12-".mysqli_real_escape_string ($con,$q )."') AND (datum <=curdate()) ORDER BY Nummer";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result)==0 ) {
	echo "<table width=\"450\">";
	echo "<tr><td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneText.jpg\" width=\"200\" height=\"190\"></td><td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneSponsoren.jpg\" width=\"200\" height=\"200\"></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<table width=\"450\">";
	echo "<tr><td><div id=\"meldung\">Für diesen Tag liegen noch keine Ziehungsdaten vor!</div></td></tr>";
	echo "</table>";
}
else
{
	echo "<table width=\"450\">";
	echo "<tr><td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneText.jpg\" width=\"200\" height=\"190\"></td><td><img src=\"/gewinne/".sprintf ("%02d", $q)."_GewinneSponsoren.jpg\" width=\"200\" height=\"200\"></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<table width=\"450\">";
	echo "<th>Losnummer</th><th>Gewinn</th><th>Sponsor</th>";
	while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row['Nummer'] . "</td>";
			echo "<td>" . $row['Gewinn'] . "</td>";
			echo "<td>" . $row['Sponsor'] . "</td>";
			echo "</tr>";
		}
	echo "</table>";
}
}

mysqli_close($con);
?>
</body>
</html>