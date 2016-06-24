<?php
if(isset($_GET['input']) && $_GET['input'] != "")
{
    echo "<br />Your Search Results Google:<br /><br />";
    $query = urlencode($_GET['input']);
    $cx = "001186922872885026417:9ptvru9qau8"; //aggiunto dall'utente
    $key = "AIzaSyB8iJub21LJvWSQcMNLLzkyS92XxD9lheQ"; //aggiunto dall'utente

    $numero=7; //ottengo dall'utente
    $decine=floor($numero/10);
    $unita=$numero%10;


    function stampa_risultati($q, $chiave, $idse, $start, $limite) {
        
        $url =  "https://www.googleapis.com/customsearch/v1?q=$q&cx=$idse&key=$chiave&start=$start";
        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        $z=0;
        
        foreach($data['items'] as $item) {
            if ($z != $limite) {
                print $item['displayLink'];
                print '<br>';  
                $z++;
            }  
        }      
    }

   for ($x=1; $x <= $decine; $x++) {
        stampa_risultati($query, $key, $cx, 10*$x, 10);
    }

    stampa_risultati($query, $key, $cx, 10*$x, $unita);
}
?>
