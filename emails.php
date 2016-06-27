<?php

require('email-config.php');
	
	if ($_POST['test']=="true") {
		
		if ($_POST['emails'] == "") {
			echo "There is a problem, email address empty.";
		}
		else {

			$emailArray = explode("%20", $_POST['emails']);
			$testEmail=$emailArray[0];

			//sendmail()
			echo "Email sent to $testEmail";

		}
	}
	else {

		if ($_POST['emails'] == "") {
			echo "There is a problem, no email address selected. Go back and reset all the checkboxes or reload the page.";
		} else {


			echo '<!DOCTYPE html><html><head>
				<title>Email Results</title>
				<link rel="stylesheet" type="text/css" href="styles.css">
				</head>

				<body>
				<center>
				<h1>Email Results</h1>
				<h2>'.date("F j, Y").'</h2>
				<p>Keywords: '.$_POST['keywords'].'</p>
				<br >
				<hr width="50%" /><br /><br />

			<table class="resultstable" width="80%" border="1">
                               	<tr>
                               		<th>#</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>';
                             


			$emailArray = explode("%20", $_POST['emails']);
			$i = 1;
			foreach ($emailArray as $value) {
				#if mail($value,$subject,$message,$headers)
					echo "<tr><td>$i</td><td>$value</td><td>Sent!</td></tr>";
				#else //problems
					//echo "<tr><td>$i</td><td>$value</td><td>Problems!!</td></tr>"; //remove last element from array ==> its empty
				

				$i++;
			}

			echo '</table></body></html>';

		}
		
	}
	

?>