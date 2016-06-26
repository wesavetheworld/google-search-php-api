<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<?php
if(isset($_GET['input']) && $_GET['input'] != "")
{   

    //GET vars
    $query = urlencode($_GET['input']);
    $cx = $_GET['sekey']; //"001186922872885026417:9ptvru9qau8";
    $key = $_GET['gapikey']; //"AIzaSyB8iJub21LJvWSQcMNLLzkyS92XxD9lheQ"; 
    $mhapikey = $_GET['mhapikey']; //4b7444747fde2d24acaa34daf62cf1d1c53161fa:
    $numero=$_GET['numero'];
    $howmanyemailaddresses = 5;
    
    $decine=floor($numero/10);
    $unita=$numero%10;

    echo '<h1> Results </h1>
            <strong>Keyword: </strong> '.$_GET["input"].' <br />
            <strong>Results: </strong> '.$_GET["numero"].' <br />
            <strong>Keyword: </strong> '.date("F j, Y").' <br /> <br />';


    function stampa_risultati($q, $start, $limite) {
        
        $url =  "https://www.googleapis.com/customsearch/v1?q=$q&cx=".$_GET['sekey']."&key=".$_GET['gapikey']."&start=$start";
        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        $z=0;
        if (!empty($data)){
           
            foreach($data['items'] as $item) {
                $m=0;
                if ($z != $limite) {
                    print '<center>';
                    print  '<h2>'.$item["displayLink"].'</h2>';
                    echo '
                            <table width="50%" border="1">
                            <tr>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Send?</th>
                            </tr>';

                    $json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".preg_replace('#^www\.(.+\.)#i', '$1', $item['displayLink'])."&api_key=".$_GET['mhapikey']);
                    $array2 = json_decode($json2, TRUE);
                    foreach($array2['emails'] as $email) {
                        if ($m!=5) {
                            print '<tr><td align="center" id="'.$email["value"].'">'.$email["value"].'</td>';
                            print  '<td align="center">'.$email["type"].'</td>';
                            $json3 = file_get_contents("https://api.emailhunter.co/v1/verify?email=".$email['value']."&api_key=".$_GET['mhapikey']);
                            $array3 = json_decode($json3, TRUE);
                            print  '<td align="center">' .$array3["result"]. '</td>';
                            print '<td align="center">'.$array3["score"].'</td>';
                            print '<td align="center"><input type="checkbox" id="CHK'.$email["value"].'" onchange="activate(this.id)"></td>';
                            $m++;
                        }
                    }

                            


                    print ' </table></center>';
                    print '</div><br /><br />';
                    $z++;
                }  
            } 
        }
    }

   for ($x=0; $x < $decine; $x++) {
        if ($x>0) {
            stampa_risultati($query, 10*$x, 10);
        } else {
            stampa_risultati($query, 1, 10);
        }
    }

    if ($unita!=0) {
        if ($decine!=0)
            stampa_risultati($query, 10*$decine, $unita);
        else 
            stampa_risultati($query, 1, $unita);
    }
}
?>

<script>
function activate(str) {
    eID = str.slice(3);
    alert(eID);
}
</script>
</body>
</html>

