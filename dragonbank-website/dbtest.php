<?php
//$username = "dragonbank_live";
//$password = "samo123";
$hostname = "103.15.67.74"; 
$username = "pro1";

$password = "123";
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("dragonbank_live",$dbhandle)
  or die("Could not select examples");

//execute the SQL query and return recor
$result = mysql_query("SELECT * FROM codes order by date DESC LIMIT 0,1");
//print_r($result);
//fetch tha data from the database

while ($row = mysql_fetch_array($result)) {
   echo "ID:".$row{'id'}." Name:".$row{'codename'}."Date: ". //display the results
   $row{'date'}."<br>";
}

//close the connection
mysql_close($dbhandle);
?>
