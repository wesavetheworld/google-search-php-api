<?php
 print '<ul>';
                    $json2 = file_get_contents("https://api.emailhunter.co/v1/search?domain=".preg_replace('#^www\.(.+\.)#i', '$1', $item['displayLink'])."&api_key=".$_GET['mhapikey']);
                    $array2 = json_decode($json2, TRUE);
                    if
                    foreach($array2['emails'] as $email) {
                        if ($m!=$howmanyemailaddresses) {
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

?>
