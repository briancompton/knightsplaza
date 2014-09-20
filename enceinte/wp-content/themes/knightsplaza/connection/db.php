<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbBugger = "localhost";
$database_dbBugger = "kp_forms";
$username_dbBugger = "kp_forms";
$password_dbBugger = "?XR>paYu01p9E";
//$dbBugger = mysql_pconnect($hostname_dbBugger, $username_dbBugger, $password_dbBugger) or trigger_error(mysql_error(),E_USER_ERROR); 
$dbBugger = mysqli_connect($hostname_dbBugger, $username_dbBugger, $password_dbBugger,$database_dbBugger); //"localhost", "cookarts_root", "password", "cookarts_database");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>