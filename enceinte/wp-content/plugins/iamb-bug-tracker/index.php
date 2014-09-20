<?php
/*
Plugin Name: Bug Reporter / Tracker
Plugin URI: http://iambriancompton.com/wordpress/plugins/bug-reporter-tracker
Description: Bug reporting and tracking plugin.
Author: Brian W. Compton
Author URI: http://iambriancompton.com
Version: 1.0.0
*/
?>
<?php
/** Step 2 (from text above). */
add_action( 'admin_menu', 'iamb_bug_tracker_plugin_menu' );

/** Step 1. */
function iamb_bug_tracker_plugin_menu() {
	add_menu_page( 'Bug Tracker Options', 'Bug Tracker', 'manage_options', 'iamb-bug-tracker', 'iamb_bug_tracker_plugin_options' );
}

/** Step 3. */
function iamb_bug_tracker_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	
	<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*
$hostname_dbBugger = "localhost";
$database_dbBugger = "kp_forms";
$username_dbBugger = "kp_forms";
$password_dbBugger = "R_sIM7tz;yw5WQu,";

$dbBugger = mysqli_connect($hostname_dbBugger, $username_dbBugger, $password_dbBugger,$database_dbBugger); 
*/

// Check connection
/*
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
*/

?>

<?php
$mysqli = new mysqli("localhost", "kp_forms", "R_sIM7tz;yw5WQu,", "kp_forms");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$query = "SELECT * FROM `bugTracker` ORDER BY postDate DESC";
$result = $mysqli->query($query) or die($mysqli->error);

$queryOpen = "SELECT * FROM `bugTracker` WHERE status=0 ORDER BY postDate DESC";
$resultOpen = $mysqli->query($queryOpen) or die($mysqli->error);


$pending = $resultOpen->num_rows;
?>

<style>
	.bug-counter {
		background-color: #B20000;
		color: #FFF;
		text-align: center;
		font-size: 14px;
		width: 30px;
		height: 30px;
		float: left;
		margin-right: 6px;
		border-radius: 15px;
	}
</style>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/bootstrap/css/bootstrap.min.css">
	
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>Bug Tracker <span class="bug-counter"><?php echo $pending; ?></span></h2>
		<p>Submitted Bug Reports.</p>
		
		<div class="row">
			<button type="button" class="btn btn-success">Open</button>	
			<button type="button" class="btn btn-danger">Closed</button>
		</div>
		
		
		<table class="table table-bordered table-striped table-responsive">
			<tr>
				<th width="100">Date</th>
				<th>Bug ID</th>
				<th width="170">Name</th>
				<th>Email</th>
				<th>Page</th>
				<!--
<th>Browser</th>
				<th>IP</th>
-->
				<th width="400">Bug Description</th>
				<th>Status</th>
			</tr>			
		
	<?php
	
	if($result->num_rows > 0) {
	while( $row = $result->fetch_assoc()) {
	if( stripslashes($row['status']) == "0" ) { $status = "Open"; } else { $status = "Closed"; }
	//	echo '<tr>' .
	echo'<tr><td>' . stripslashes($row['postDate']) . '</td><td>' . stripslashes($row['bugID']) . '</td><td>' . stripslashes($row['name']) . '</td>';
	echo'<td>' . stripslashes($row['email']) . '</td><td>' . stripslashes($row['pageName']) . '</td><td>' . stripslashes($row['bugDesc']) . '</td>';
	echo '<td align="center">' . $status . '</td></tr>';
	
	//	'</tr>';
	}
} else {
	echo 'NO RESULTS';
}

mysql_close($mysqli);


/* close connection */
$mysqli->close();

?>
			</table>
		
	</div>
	
	
<?php } ?>