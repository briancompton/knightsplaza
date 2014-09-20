<?php require_once( '../connection/db.php' ); ?>

<?php
$name =  $_POST['name'];
$email = $_POST['email'];
$pageName = $_POST['pageName'];
$browser = $_POST['browser'];
$location = $_POST['location'];
$bugDesc = $_POST['bugDesc'];
$bugID = $_POST['bugID'];
  
$sql = "INSERT INTO bugTracker (name, email, pageName, browser, location, bugDesc, bugID) 
				VALUES ('$name','$email','$pageName','$browser','$location','$bugDesc','$bugID')";
  											
if ($dbBugger->query($sql) === TRUE) {
      echo 'Report successfully submitted. Thank you.';
}   
else {
  echo 'Error: '. $dbBugger->error;
}

mysqli_close($dbBugger);

?>