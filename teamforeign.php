<?php
include('connectionData.txt');
$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>

<html>
  <center>
<head>
  <title>Team Players</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
$team = $_POST['team'];
$team = mysqli_real_escape_string($conn, $team);
// this is a small attempt to avoid SQL injection
// better to use prepared statements
$query = "SELECT 
    DISTINCT p.name as Players, p.nationality
FROM
    (Player p)
         LEFT JOIN
    City c ON (c.country = p.nationality)
  JOIN Team t ON (t.id = p.Team_id) CROSS JOIN (SELECT 
    c.country
FROM
    City c 
    JOIN  Team t ON (t.City_name = c.name)
WHERE
    t.name LIKE '%".$team."%') n
    WHERE t.name LIKE '%".$team."%' AND (n.country != p.nationality)";
?>




<hr>
<?php
print $team;
?>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));
 

echo "<table border='1'>
<tr>
<th>Players</th>
<th>Country</th>
</tr>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))  
  {

  echo "<tr>";
  echo "<td>" . $row[Players] ."</td>";
  echo "<td>" . $row[nationality] . "</td>";
  echo "</tr>";
  }
echo "</table>";
mysqli_free_result($result);
mysqli_close($conn);

?>

<p>
<hr>

<p>
<a href="teamforeign.txt" >Contents</a>
of the PHP program that created this page.   
 
</body>
  </center>
</html>
