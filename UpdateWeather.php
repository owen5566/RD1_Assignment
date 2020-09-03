<?php 
    $db = new PDO("mysql:host=localhost;dbname=RD1_db;port=8889", "root", "root");
    $db->exec("set names utf8");
    date_default_timezone_set("Asia/Taipei");
    $now = date('Y-m-d H:i:s');
    if(compareTimeForUpdate($now)){
        die("不更新");
    }
    function compareTimeForUpdate($time){
        global $db;
        $result = $db->query("SELECT lastUpdateTime FROM `record` ORDER BY lastUpdateTime DESC LIMIT 1");
        if($row = $result->fetch()){
            if(date("Y-m-d",strtotime($row[0]))==date("Y-m-d",strtotime($time))){
                return false;
            }
        }
        return true;
    }
   
    
    $curl = curl_init();
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-D620E1A7-8835-4C4D-928A-268DDFA7BA2E";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    $data = curl_exec($curl);    
    curl_close($curl);
    // $temp= file_get_contents("temp.json");
    
    $temp = (json_decode($data));
    // 地區路徑：$temp->records->locations[0]->location[num]
    // 資訊類型：$temp->records->locations[0]->location[1]->weatherElement[]
   
    echo "<br><pre>";
   
    $record = Array();
    $countCity=0;
    foreach($temp->records->locations[0]->location as $bycity){
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
                    
                }$count++;
            }$countCity++;
    }
    
    // var_dump(array_keys($record[0]["info"][0]));
    for($i = 0 ;$i<count($record);$i++){
             $geo = $record[$i]["geocode"];
            foreach($record[$i]["info"] as $arrInfo){
                $start = $arrInfo["startTime"];
                $end = $arrInfo["endTime"];
                $PoP12h = (($arrInfo["PoP12h"][0])!=" ")?$arrInfo["PoP12h"][0]:"null";
                $perTemp = $arrInfo["T"][0];
                $perWet = $arrInfo["RH"][0];
                $minComfortIdx = $arrInfo["MinCI"][0];
                $maxComfortIdx = $arrInfo["MaxCI"][0];
                $maxATemp = $arrInfo["MaxAT"][0];
                $minATemp = $arrInfo["MinAT"][0];
                $minTemp = $arrInfo["MinT"][0];
                $maxTemp = $arrInfo["MaxT"][0];
                $uvi = (isset($arrInfo["UVI"][0]))?$arrInfo["UVI"][0]:"null";
                $td = $arrInfo["Td"][0];
                $windSpeed = $arrInfo["WS"][0];
                $windDir = $arrInfo["WD"][0];
                $wx = $arrInfo["Wx"][0];
                $wDescript = $arrInfo["WeatherDescription"][0];

                $sql = <<<sql
                insert into weather values
                (
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
                )ON DUPLICATE KEY UPDATE
                Pop12h = $PoP12h,
                perTemp = $perTemp,
                perWet = $perWet,
                minTemp = $minTemp,
                maxTemp = $maxTemp,
                minATemp = $minATemp,
                maxATemp = $maxATemp,
                minCI = $minComfortIdx,
                maxCI = $maxComfortIdx,
                UVI = $uvi,
                td = $td,
                ws = "$windSpeed",
                wd = "$windDir",
                wx =    "$wx";
                sql;
                echo $sql;
                // if($db->query($sql))
                    
                 
                // print_r($db->errorInfo());
            }
    }
    $time = date('Y-m-d H:i:s');
    // $db->query("insert into record values(null,'$time')");
    // var_dump($record);
    // var_dump($temp->records->locations[0]->location[0]->weatherElement);
?>
