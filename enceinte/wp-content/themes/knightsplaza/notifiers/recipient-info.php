<?php

// Unit Information
		$CSMail = "subscribe@knightsplaza.com"; // Main reply-to
		$CSWeb = '<a href="http://www.knightsplaza.com" title="Knights Plaza" alt="Knights Plaza">http://www.knightsplaza.com</a>';

// Message Recipients

// Copier Services recipients
		
		$mgrEmail 					= "brian.compton@ucf.edu"; // Brian Compton
		$mgrSMS 						= "4073411352@txt.att.net"; // Brian Compton
		
		$recipientEmail  	= "brian.compton@ucf.edu" . ",";
		$recipientEmail  	= rtrim($csRecipientEmail, ',');
		
		$mgr = $mgrEmail; // Knights Plaza Manager


// Developers Email
		$devEmail 					= "brian.compton@ucf.edu" . ",";//"4072567721@txt.att.net"; // Brian Compton
		$devEmail 				 .= "" . ","; // Copy and paste entire line for additional devs
		$devEmail 					= rtrim($devEmail, ',');

// Developers SMS
		$devSMS 						= "brian.compton@ucf.edu" . ",";//"4072567721@txt.att.net"; // Brian Compton
		$devSMS 					 .= "" . ","; // Copy and paste entire line for additional devs
		$devSMS 						= rtrim($devSMS, ',');

?>