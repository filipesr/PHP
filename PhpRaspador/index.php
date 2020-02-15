<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="windows-1252">
        <title>PHP - Fernando Oliveira</title>
    </head>
    <body>
        <?php
        //debug var
        $DEBUG = true;
        if ($DEBUG) {
            echo "<p><font color='red'>MODE: DEBUG - " . date("Y-m-d H:i:s") . "</font></p>";
        }
        
        $url = 'https://www.gsmarena.com/samsung_galaxy_s8-8161.php#g950u'; // url
        $url = 'https://www.gsmarena.com/samsung_galaxy_s8-8161.php#'; // url

        $model = "g950u";
        // get name and model of phone
        if (isset($_REQUEST['modelo'])) {
            $model = $_REQUEST['modelo'];
        }
        // get model aternative
        //$model = explode('#', $url)[1];
        
        $url .- $model;

        $html = file_get_contents($url); //get the html

        $html_doc = new DOMDocument();

        libxml_use_internal_errors(TRUE); //disable libxml errors

        if (!empty($html)) { //if any html is actually returned
            $html_doc->loadHTML($html);
            
            libxml_clear_errors(); //remove errors for yucky html

            $html_xpath = new DOMXPath($html_doc);

            //get json object of script
            $var_script = explode("=", $html_xpath->query('//div[@id="body"]/div/script')->item(0)->nodeValue)[1];
            $var_script = str_replace(["\r\n", "\r", "\n"], "", $var_script);
            $var_script = str_replace([',]', ',}', '];'], [']', '}', ']'], $var_script);
            $json_array = json_decode($var_script, true);
            //variable with more information from phone
            $json_more_info = [];
            //search aditional information of phone
            echo "<pre>";
            print_r($json_array[0]);
            echo "</pre>";
            foreach ($json_array[0] as $json_row) {
                //echo "<p>$json_row[0] = $model? " . strcmp($json_row[0],$model) ."</p>";
                if($DEBUG){
                    echo "<pre>";
                    print_r($json_row[0]);
                    print_r($json_row[1]);
                    echo "</pre>";
                }
                if($json_row[0] == $model){
                    $json_more_info = $json_row[1];
                }
            }

            //get title/name of phone
            $phone = array_key_exists("modelname", $json_more_info)? $json_more_info["modelname"] : $html_xpath->query('//h1[contains(@class,"specs-phone-name-title")]')->item(0)->nodeValue;

            if ($DEBUG) {
                echo "<h1>$phone</h1><p>";
            }
            
            //get all the DIV's with specs
            $html_row = $html_xpath->query('//div[@id="specs-list"]/table');

            if ($html_row->length > 0) {
                foreach ($html_row as $row) {
                    //get the group of specification
                    $group = $row->getElementsByTagName('th')->item(0)->nodeValue;
                    if ($DEBUG) {
                        echo "<h2>" . $group . "</h2><p>";
                    }
                    
                    // get all specs
                    $spec_list = $html_xpath->query('tr', $row);
                    if ($spec_list->length > 0) {
                        foreach ($spec_list as $spec) {
                            if($html_xpath->query('td', $spec)->length > 1){
                                //get the name of specification
                                $name = $html_xpath->query('td[@class="ttl"]', $spec)->item(0)->nodeValue;
                                //get the value of specification
                                $value = $html_xpath->query('td[@class="nfo"]', $spec)->item(0)->nodeValue;
                                if ($DEBUG) {
                                    if ($name != "\xC2\xA0") {
                                        echo "<b>" . $name . "</b> = ";
                                    }
                                    echo $value . "</br>";
                                }
                            }
                        }
                    } else {
                        if ($DEBUG) {
                            echo "Sem SPECS";
                        }
                    }
                    if ($DEBUG) {
                        echo "</p>";
                    }
                }
            } else {
                if ($DEBUG) {
                    echo "Sem DIV com ID";
                }
            }
        } else {
            if ($DEBUG) {
                echo "HTML não carregado";
            }
        }
        ?>
    </body>
</html>
