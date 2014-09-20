<?php
// This send emails to internal stakeholders specified in recipient-info.php

require_once( 'recipient-info.php' );

// Put the recipients together into a string
$toEmailI = $mgrEmail . ',' . $recipientEmail;
$toEmailI = rtrim($toEmailI, ',');

$customerEmailI= $customerEmail;

$ccEmailI = $devEmail;
//$bccEmailI = "brian.compton@ucf.edu";

// Set the appropriate subject line

if( $formName == 'contact') {
	$subjectEmailI = "Knights Plaza Contact Us Form"; 
	}
	
	$subjectEmailI = "Knights Plaza Contact Us Form"; 

$headersEmailI = "From: Knights Plaza<" . $CSMail . ">\r\n";
$headersEmailI.= "Reply-To: " . $mgrEmail . "\r\n";
$headersEmailI.= "CC: " . $ccEmailI . "\r\n";
$headersEmailI.= "BCC: " . $bccEmailI . "\r\n";
$headersEmailI.= "MIME-Version: 1.0\r\n";
$headersEmailI.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

// Build the message, starting with the style sheet
$messageEmailI= "<style>

body {
background-color: #fff;
margin: 0 auto;
text-align: center;
}

table {
background: none repeat scroll 0 0 #FFFFFF;
border: 1px solid #CCCCCC;
font-family: Arial,Helvetica,sans-serif;
font-size: 13px;
margin: 30px auto 20px;
padding: 0 20px;
text-align: left;
width: 650px;
}

td {
padding: 5px 15px 5px 20px;
vertical-align: top;
}

td.label {
font-weight: 600;
text-align: right;
}

a:link, a:visited {
color: #333;
}

a:hover, a:active {
color: blue;
}

h2 {
border-bottom: 1px dotted #666;
padding: 15px;	
text-align: center;
}

.subtle-emphasis {
	color: #666;
	font-size: .9em;
	font-style: italic;
	text-align: center;
}

.bordered {
	border-top: 1px dotted #666;
	height: 5px;
}

.footer {
	color: #666;
	font-size: .9em;
	font-weight: 600;
	margin-bottom: 20px;
	text-align: center;
}

.footer a:link, .footer visited {
	color: #666;
	text-decoration: none;
}

</style>";

$messageEmailI.= '<body>';
$messageEmailI.= '<table>';
$messageEmailI.= '<p>&nbsp;</p>';
$messageEmailI.= '<tr><td colspan="2"><h2>Knights Plaza</h2></td></tr>';

/* $messageEmailI.= '<tr><td colspan="2"><p>This is an internal notification that a ' . strtolower($row_rsService['RequestType']) . ' request has been submitted to UCF Copier Services.</p><p>&nbsp;</p></td></tr>'; */
$messageEmailI.= '<tr><td colspan="2"><p>This is an internal notification that a "' . $formName . '" form has been submitted to Knights Plaza.</p><p>&nbsp;</p></td></tr>';

$formID = randomID();
$name =  $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$intent = $_POST['intent'];
$message = $_POST['message'];

$messageEmailI.= '<tr><td class="label" width="200">Contact ID</td><td>' . $formID . '</td></tr>';
$messageEmailI.= '<tr><td class="label">Name</td><td>' . $name . '</td></tr>';
$messageEmailI.= '<tr><td class="label">Email</td><td>' . $email . '</td></tr>';
$messageEmailI.= '<tr><td class="label">Phone</td><td>' . $phone . '</td></tr>';
$messageEmailI.= '<tr><td class="label">I would like to:</td><td>' . $intent . '</td></tr>';
$messageEmailI.= '<tr><td class="label">Message</td><td>' . $message . '</td></tr>';

$messageEmailI.= '<tr><td colspan="2"><p>&nbsp;</p><p class="bordered">&nbsp;</p></td></tr>';
$messageEmailI.= '<tr><td colspan="2"><p class="footer"><a href="http://www.knightsplaza.com">Knights Plaza</a> &middot &copy ' . date('Y') . '</p></td></tr>';
$messageEmailI.= '</table>';
$messageEmailI.= '</body>';


// Send the message if the Request ID (aka SessionID) isn't blank
if(!empty( $formID )) {
	mail($toEmailI, $subjectEmailI, $messageEmailI, $headersEmailI) or die ("Crud!  Something has gone awry.  Please try re-sending your form or calling Knights Plaza at (407) 882-8600.");
	} else {
	die;
}

// Test only
//	echo $toEmailI, $subjectEmailI, $messageEmailI, $headersEmailI;


/*** NOTE TO FUTURE SELF ***

30Nov12 - Create a form on website for unit set and clear the temporary manager notifications // BWC

*** end NOTE TO FUTURE SELF ***/

/*** LOG ***

// 20131009 - Revised for Knights Plaza (bwc)
// 20130820 - Refactored (bwc)
// 20130820 - Cleaned out unused code (bwc)
// 20121130 - Reorganized and clean-up (bwc)
// 20120215 - Corrected date issue (bwc)
// 20110711 - Added Copier Services generic EmailIaddress; cleaned up recipient code; removed duplicate messages to Cissy Glowth (bwc)
// 20110511 - Changed 'from' to include display name; added header image; set table width (bwc)

*** end LOG ***/		 

?>