<!DOCTYPE html>
<html>
<head>
    <title>Google Search Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php


function giveHost($host_with_subdomain) {

    $array = explode(".", $host_with_subdomain);
    return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];

}

require('assets.php');
if(isset($_GET['input']) && $_GET['input'] != "")
{   
    //GET vars
    $query = urlencode($_GET['input']);
    $numero=$_GET['numero'];
    
    $dec=floor($numero/10);
    $uni=$numero%10;

    echo '<center>
                <h1>Google Search Results</h1>
                <h2>'.date("F j, Y").'</h2>
                <p>Keywords: <strong>'.$_GET["input"].'</strong> - First '.$_GET["numero"].' results on Google.com</p>
          </center><br /><hr width="50%" />
             ';


    function stampa_risultati($q, $start, $limite) {
        $url =  "https://www.googleapis.com/customsearch/v1?q=$q&cx=".$GLOBALS['cx']."&key=".$GLOBALS['gapikey']."&start=$start";
        $json1 = file_get_contents("$url"); //uncomment
        $array1 = json_decode($json1, TRUE);
        $z=0;
        if (!empty($array1)){
           
            foreach($array1['items'] as $item) {
                $m=0;
                if ($z != $limite) {
                    print '<center>';
                    print  '<h2>'.$item["displayLink"].'</h2>';
                    if (($_GET['emails']=='emails')) {
                        echo '
                                <table class="resultstable" width="50%" border="1">
                                <tr>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <th>Send?</th>
                                </tr>';

                        /*$json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".preg_replace('#^www\.(.+\.)#i', '$1', $item['displayLink'])."&api_key=".$GLOBALS['mhapikey']);   function getHost will not work with site.co.uk, will return co.uk as host*/

                        $json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".giveHost($item['displayLink'])."&api_key=".$GLOBALS['mhapikey']);
                        $array2 = json_decode($json2, TRUE);
                        foreach($array2['emails'] as $email) {
                            if ($m!=$GLOBALS['nremail']) {
                                print '<tr><td align="center" id="'.$email["value"].'">'.$email["value"].'</td>';
                                print  '<td align="center">'.$email["type"].'</td>';
                                $json3 = file_get_contents("https://api.emailhunter.co/v1/verify?email=".$email['value']."&api_key=".$GLOBALS['mhapikey']);
                                $array3 = json_decode($json3, TRUE);
                                print  '<td align="center">' .$array3["result"]. '</td>';
                                print '<td align="center">'.$array3["score"].'</td>';
                                print '<td align="center"><input type="checkbox" id="CHK'.$email["value"].'" onchange="activate(this)"></td>';
                                $m++;
                            }
                        }       
                     print ' </table></center>';
                    }
                    print '</div><br /><br />';
                    $z++;
                }  
            } 
        }
    }

   for ($x=0; $x < $dec; $x++) {
        if ($x>0) {
            stampa_risultati($query, 10*$x, 10);
        } else {
            stampa_risultati($query, 1, 10);
        }
    }

    if ($uni!=0) {
        if ($dec!=0)
            stampa_risultati($query, 10*$dec, $uni);
        else 
            stampa_risultati($query, 1, $uni);
    }
}
?>
<center>

 <form>
    <input type="email" id="testEmailTXT" placeholder="test@email.com" />
    <input type="button" id="testEmailBTN" value="Send" />
    <p id="testResult"><p>
 </form>


<form method ="post" action="emails.php">
<?php echo '<input type="hidden" name="keywords" value="'.$_GET["input"].'" />' ?>
    <input type="hidden" name="emails" id="emails" value="" />
    <input type="submit" class="btnSubmit" id="sendTestBtn" value="Send Emails!" />
</form>

</center>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js" ></script>
<script src="js/main.js"></script>

</body>
</html>

