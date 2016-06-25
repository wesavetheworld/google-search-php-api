<?php
if(isset($_GET['input']) && $_GET['input'] != "")
{
    echo "<br />Your Search Results Google:<br /><br />";
    $query = urlencode($_GET['input']);
    //$query = urlencode("read your future");
    $cx = $_GET['sekey']; //"001186922872885026417:9ptvru9qau8"; //aggiunto dall'utente
    $key = $_GET['gapikey']; //"AIzaSyB8iJub21LJvWSQcMNLLzkyS92XxD9lheQ"; //aggiunto dall'utente
    $mhapikey = $_GET['mhapikey'];
    $numero=$_GET['numero'];; //ottengo dall'utente
    
    $decine=floor($numero/10);
    $unita=$numero%10;


    function stampa_risultati($q, $start, $limite) {
        
        $url =  "https://www.googleapis.com/customsearch/v1?q=$q&cx=".$_GET['sekey']."&key=".$_GET['gapikey']."&start=$start";
        print '<br>';

        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        $z=0;
        
        foreach($data['items'] as $item) {
            $m=0;
            if ($z != $limite) {
                print $item['displayLink'];
                print '<br>';  
                print '<ul>';
                $json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".preg_replace('#^www\.(.+\.)#i', '$1', $item['displayLink'])."&api_key=".$_GET['mhapikey']);
                $array2 = json_decode($json2, TRUE);
                foreach($array2['emails'] as $email) {
                    if ($m!=5) {
                        print '<li>';
                        print $email['value'];
                        $json3 = file_get_contents("https://api.emailhunter.co/v1/verify?email=".$email['value']."&api_key=4b7444747fde2d24acaa34daf62cf1d1c53161fa");
                        $array3 = json_decode($json3, TRUE);
                        print ' - ';
                        print $array3['result'];
                        print ' - Score: ';
                        print $array3['score'];
                        print '</li>';
                        $m++;
                    }
                }
                print '</ul>';
                $z++;
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
