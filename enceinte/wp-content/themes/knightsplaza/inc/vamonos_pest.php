

<div class="bug-tracker">
	
	<form action="#" id="bug" role="form">
	
		<div class="form-group">
	    <label for="name">Name</label>
	    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" autofocus>
	  </div>
	  
	  <div class="form-group">
	    <label for="email">Email address</label>
	    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
	  </div>
	  
	  <div class="form-group">
	    <label for="bugDesc">Bug Description</label>
	    <textarea id="bugDesc" name="bugDesc" cols="30" rows="10"></textarea>
	  </div>
	  
	  <h4>Session Information <span class="whats-this info-session"><a href="#info-sessionModal" data-toggle="modal">What's This?</a></span>
</h4>	 
		<div class="form-group">
	    <label for="bugID">Bug Submission ID</label>
	    <input type="text" class="form-control" id="bugID" name="bugID" value="<?php echo randomID(); ?>" readonly="readonly">
	  </div>
	  
	  <div class="form-group">
	    <label for="pageName">Page</label>
	    <input type="text" class="form-control" id="pageName" name="pageName" value="<?php echo $_SERVER['REQUEST_URI']; ?>" readonly="readonly">
	  </div>
	  
	  <div class="form-group">
	    <label for="browser">Browser Information</label>
	    <input type="text" class="form-control" id="browser" name="browser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" readonly="readonly">
	  </div>
	  
	  <div class="form-group">
	    <label for="location">Location</label>
	    <input type="text" class="form-control" id="location" name="location" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" readonly="readonly">
	  </div>
	  
	  <input type="hidden" id="thePath" name="thePath" value="<?php echo get_template_directory_uri();?>">
	  		
	</form>
	
</div>

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

//This returns the True IP of the client calling the requested page
// Checks to see if HTTP_X_FORWARDED_FOR
// has a value then the client is operating via a proxy


$userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
if($userIP == "") {
	$userIP = $_SERVER['REMOTE_ADDR'];
}

$id = $tempId;
$ip = $userIP; // IP Address
//$ip = str_replace(".","",$ip);
//$host = $_SERVER['REMOTE_HOST']; // User Host
$queryString = $_SERVER['QUERY_STRING'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$useragent = $_SERVER['HTTP_USER_AGENT']; // User browser & os version information
$time = $_SERVER['REQUEST_TIME']; // Time entered page
$uri = $_SERVER['REQUEST_URI'];

// return the IP we've figured out:
$results = array($id,$ip,$host,$useragent,$time,$queryString,$uri);
if(!empty($id)){
return $results;
}

?>

<script>

	 
</script>