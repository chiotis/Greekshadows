<?php 
// Replace this MYSQL server variables with actual configuration 
$mysql_server = "localhost"; 
$mysql_user_name = "c0vagskou"; 
$mysql_user_pass = "pks55nh!!!"; 

// Retrieve visitor IP address from server variable REMOTE_ADDR 
$ipaddress = getenv(REMOTE_ADDR); 

// Convert IP address to IP number for querying database
$ipno = Dot2LongIP($ipaddress); 

// Connect to the database server 
$link = mysql_connect($mysql_server, $mysql_user_name, $mysql_user_pass) or die("Could not connect to MySQL database"); 

// Connect to the IP2Location database 
mysql_select_db("c0ip2country") or die("Could not select database"); 

// SQL query string to match the recordset that the IP number fall between the valid range 
$query = "SELECT * FROM ipcountry WHERE $ipno <= ipTO AND $ipno>=ipFROM"; 

// Execute SQL query 
$result = mysql_query($query) or die("ipcountry Query Failed"); 

// Retrieve the recordset (only one) 
$row = mysql_fetch_object($result); 

// Keep the country information into two different variables 
$countrySHORT = $row->countrySHORT; 
$countryLONG = $row->countryLONG; 

// Free recordset and close database connection 
mysql_free_result($result); mysql_close($link); 

// If the visitors are from JP, redirect them to JP site 
if ($countrySHORT == "GR") 
{
  Header("Location: http://www.greekshadows.com/gr"); 
} else { 
// Otherwise, redirect them to US site 
  Header("Location: http://www.greekshadows.com/en");
}
exit;

// Function to convert IP address (xxx.xxx.xxx.xxx) to IP number (0 to 256^4-1) 
function Dot2LongIP ($IPaddr) { 
 if ($IPaddr == "") 
 {
   return 0;
 } else { 
   $ips = split ("\.", "$IPaddr"); 
   return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256); 
 }
} 
?> 

