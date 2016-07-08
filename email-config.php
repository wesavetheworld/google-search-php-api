<?php

$from ="custom@email.com";
$subject = "Custom Subject"; //edit this field
$messageTemplate = "
<html>
<head>
</head>
<body>
<p>Dear Website owner, </p> <br />

<p>This is a custom email</p><br />
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: Name Surname <'.$from.'>' . "\r\n"; //edit Name Surname



/*
$messageTemplate = "
<html>
<head>
</head>
<body>
<p>Dear Website owner, </p> <br />

<p>
On today ####1#### I have visit your website with URL ####2#### and I was positive surprised about your websites!</p>

<p>
I’m also owner of some similar website with URL <a href='http://whatismyfuture.net'>http://whatismyfuture.net</a>, and meaby we can cooperate together what can and must be a fruitful for us both.</p>

<p>
I hope that you can take in considering my proposal and if we think on the same way I’m sure that it will become a win-win operation!</p>

<p>
I’m looking forwards to receive your reaction, and in the mean time have a nice day.</p>

<b></b><br />
</body>
</html>
";
*/
