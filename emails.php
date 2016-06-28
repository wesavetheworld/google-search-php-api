<?php

require('email-config.php');
	
	if ($_POST['test']=="true") {
		
		if ($_POST['emails'] == "") {
			echo "There is a problem, email address empty.";
		}
		else {

			$emailArray = explode("%20", $_POST['emails']);
			$testEmail=$emailArray[0];

			$domain = substr(strrchr($testEmail, "@"), 1);

			$message = str_replace("####1####",date("F j, Y"),$messageTemplate);
			$message = str_replace("####2####","http://$domain",$message);

			if (mail($testEmail, $subject, $message, $headers))
            	echo "Mail successfully sent to $testEmail";
            else
            	echo "Something went wrong.";
            

		}
	}
	else {

		$_POST['emails']=""; //togliere 
		if ($_POST['emails'] == "") {
			echo "There is a problem, no email address selected. Go back and reset all the checkboxes or reload the page. ";
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
                             


			//$emailArray = explode("%20", $_POST['emails']);
            $emailArray = array("eugen.saraci@gmail.com", "eugen.saraci@studenti.unipd.it", "hello");
			array_pop($emailArray);
			$i = 1;
			foreach ($emailArray as $value) {
				
				echo "<tr><td>$i</td><td>$value</td><td>";
				
				$domain = substr(strrchr($value, "@"), 1);
				$message = str_replace("####1####",date("F j, Y"),$messageTemplate);
				$message = str_replace("####2####","http://$domain",$message);

				if (mail($value, $subject, $message, $headers))
        			echo "Sent!";
        		else
        			echo "Error!";
				echo "</td></tr>";

				$i++;
			}

			echo '</table></body></html>';

		}
		
	}
	

?>