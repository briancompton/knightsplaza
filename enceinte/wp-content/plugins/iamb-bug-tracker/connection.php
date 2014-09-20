<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbBugger = "localhost";
$database_dbBugger = "kp_forms";
$username_dbBugger = "kp_forms";
$password_dbBugger = "R_sIM7tz;yw5WQu,";

$dbBugger = mysqli_connect($hostname_dbBugger, $username_dbBugger, $password_dbBugger,$database_dbBugger); 

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>