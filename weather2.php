<?php 

    // $curl = curl_init();
    // $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-D620E1A7-8835-4C4D-928A-268DDFA7BA2E";
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($curl, CURLOPT_HEADER, 0);
    // $data = curl_exec($curl);
    // // echo ($data);
    // curl_close($curl);

    //
    $temp= file_get_contents("temp.json");
    
    $temp = (json_decode($temp));
    // 地區路徑：$temp->records->locations[0]->location[num]
    // 資訊類型：$temp->records->locations[0]->location[1]->weatherElement[]
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <label for="citys">Choose a city:</label>

    <select name="city" id="city">
    <?php 
    $db = new PDO("mysql:host=localhost;dbname=RD1_db;port=8889", "root", "root");
    $db->exec("set names utf8");
    
    foreach($temp->records->locations[0]->location as $locationArr){
        // $db->query("insert into cityCode values($locationArr->geocode,'$locationArr->locationName')");

        ?>
        
        <option value="<?= $locationArr->geocode;?>">
                <?= $locationArr->locationName;?>
            </option>   
        <?php }?>
    </select>
</body>
<?php
    echo "<br><pre>";
   
    $record = Array();
    $countCity=0;
    foreach($temp->records->locations[0]->location as $bycity){
        echo $bycity->locationName." ";
        $geocode = $bycity->geocode;
        $record[$countCity]["geocode"]=$geocode;
        $count=0;
        foreach($bycity->weatherElement as $weatherArr){
            $script = $weatherArr->elementName;
            for($i = 0;$i< count($weatherArr->time);$i++) {
                if ($count==0) {
                    $record[$countCity]["info"][$i]["startTime"]=$weatherArr->time[$i]->startTime;
                    $record[$countCity]["info"][$i]["endTime"]=$weatherArr->time[$i]->endTime;
                }
                $record[$countCity]["info"][$i][$script]=
                    [$weatherArr->time[$i]->elementValue[0]->value,
                    (($weatherArr->time[$i]->elementValue[0]->measures)=="NA")?"":$weatherArr->time[$i]->elementValue[0]->measures];
                    // $record[$geocode][$count][]=$script;
    
                    //  echo
                    //  $bytime->startTime
                    //  ." ".
                    //  $bytime->elementValue[0]->value.
                    //  $bytime->elementValue[0]->measures."<br>";
                }$count++;
            }$countCity++;
    }
    
    echo "<br>";
    var_dump(array_keys($record[0]["info"][0]));
    for($i = 0 ;$i<count($record);$i++){
            echo $geo = $record[$i]["geocode"];
            echo "<br>";
            foreach($record[$i]["info"] as $arrInfo){
                echo $start = $arrInfo["startTime"];
                echo $end = $arrInfo["endTime"];
                echo $PoP12h = (($arrInfo["PoP12h"][0])!=" ")?$arrInfo["PoP12h"][0]:"null";
                echo " ";
                echo $perTemp = $arrInfo["T"][0];
                echo $perWet = $arrInfo["RH"][0];
                echo $minComfortIdx = $arrInfo["MinCI"][0];
                echo $maxComfortIdx = $arrInfo["MaxCI"][0];
                echo $maxATemp = $arrInfo["MaxAT"][0];
                echo $minATemp = $arrInfo["MinAT"][0];
                echo $minTemp = $arrInfo["MinT"][0];
                echo $maxTemp = $arrInfo["MaxT"][0];
                echo $uvi = (isset($arrInfo["UVI"][0]))?$arrInfo["UVI"][0]:"null";
                echo " ";
                echo $td = $arrInfo["Td"][0];
                echo $windSpeed = $arrInfo["WS"][0];
                echo $windDir = $arrInfo["WD"][0];
                echo $wx = $arrInfo["Wx"][0];
                echo $wDescript = $arrInfo["WeatherDescription"][0];

                echo "<br>";
                $sql = <<<sql
                insert into weather values
                (null,
                $geo,
                "$start",
                "$end",
                $PoP12h,
                $perTemp,
                $perWet,
                $minTemp,
                $maxTemp,
                $minATemp,
                $maxATemp,
                $minComfortIdx,
                $maxComfortIdx,
                $uvi,
                $td,
                $windSpeed,
                "$windDir",
                "$wx"
                )
                sql;
                echo $sql;
                // $db->query($sql);
                // print_r($db->errorInfo());
            }
    }
    var_dump($record);
    // var_dump($temp->records->locations[0]->location[0]->weatherElement);
?>
</html>