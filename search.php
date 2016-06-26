<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php
require('assets.php');
if(isset($_GET['input']) && $_GET['input'] != "")
{   

    //GET vars
    $query = urlencode($_GET['input']);
    $numero=$_GET['numero'];
    
    $dec=floor($numero/10);
    $uni=$numero%10;

    echo '<h1> Results </h1>
            <strong>Keyword: </strong> '.$_GET["input"].' <br />
            <strong>Results: </strong> '.$_GET["numero"].' <br />
            <strong>Keyword: </strong> '.date("F j, Y").' <br /> <br />';


    function stampa_risultati($q, $start, $limite) {
        $url =  "https://www.googleapis.com/customsearch/v1?q=$q&cx=".$GLOBALS['cx']."&key=".$GLOBALS['gapikey']."&start=$start";
        $json1 = file_get_contents($url);
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

                        $json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".preg_replace('#^www\.(.+\.)#i', '$1', $item['displayLink'])."&api_key=".$GLOBALS['mhapikey']);
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

<input type="button" onclick="raccogli()" value="Raccogli" />
<p id="listo">Gente a cui spedire:</p>
<input type="buttonjs" name="btnEmail" value="ButtonJS" />

<label for="emailtest">Insert your email</label>
<input id="emailtest" type="email" placeholder="your email" />
<input type="button" name="btnEmail" value="Send test email" />

<script src="js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js" ></script>
</body>
</html>

