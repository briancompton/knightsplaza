<?php require_once( '../connection/db.php' ); ?>

<?php
$formID = randomID();
$name =  $_POST['name'];
$email = $_POST['email'];
$textNum = $_POST['textNum'];
$subType = $_POST['subType'];
  
$sql = "INSERT INTO kpConnect (formID, name, email, textNum, subType) 
				VALUES ('$formID', '$name','$email','$textNum','$subType')";
  											
if ($dbBugger->query($sql) === TRUE) {
      echo "Congratulations! You've successfully subscribed.";
}   
else {
  echo 'Error: '. $dbBugger->error;
}

echo $formID;

mysqli_close($dbBugger);

?>




<?php

function randomID() {
//To Pull 13 Unique Random Values Out Of AlphaNumeric

//removed number 0, capital o, number 1 and small L
//Total: keys = 32, elements = 33
$characters = array(
"A","B","C","D","E","F","G","H","J","K","L","M",
"N","P","Q","R","S","T","U","V","W","X","Y","Z",
"1","2","3","4","5","6","7","8","9");

//make an "empty container" or array for our keys
$keys = array();

//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
while(count($keys) < 13) {
    //"0" because we use this to FIND ARRAY KEYS which has a 0 value
    //"-1" because were only concerned of number of keys which is 32 not 33
    //count($characters) = 33
    $x = mt_rand(0, count($characters)-1);
    if(!in_array($x, $keys)) {
       $keys[] = $x;
    }
}

foreach($keys as $key){
   $randomID .= $characters[$key];
}

return $randomID;

}

;?>