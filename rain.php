<?php
    $db = new PDO("mysql:host=localhost;dbname=RD1_db;port=8889", "root", "root");
    $db->exec("set names utf8");
    date_default_timezone_set("Asia/Taipei");
    $result = $db->query("SELECT obsTime FROM `rain` LIMIT 1");
    $row = $result->fetch();
    $curl = curl_init();
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-D620E1A7-8835-4C4D-928A-268DDFA7BA2E&elementName=ELEV,RAIN,HOUR_24";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    $data = curl_exec($curl);    
    curl_close($curl);

    $data = json_decode($data);
        if($data->records->location[0]->time->obsTime!=$row[0]){
            echo "update";
        }else{
            echo "lastest";
            die();
        }
    // die();
    $curl = curl_init();
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-D620E1A7-8835-4C4D-928A-268DDFA7BA2E&elementName=ELEV,RAIN,HOUR_24";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    $data = curl_exec($curl);    
    curl_close($curl);
    
    // $data= file_get_contents("rain.json");
    $temp = json_decode($data);
    // echo "<pre>";
    $sqlDelete = "TRUNCATE `RD1_db`.`rain`";
    $db->query($sqlDelete);
    foreach ($temp->records->location as $arr) {
        $city = $arr->parameter[0]->parameterValue;
        $town = $arr->parameter[2]->parameterValue;
        $locationName = $arr->locationName;
        $stationId = $arr->stationId;
        $obsTime = $arr->time->obsTime;
        $rain1h = $arr->weatherElement[1]->elementValue;
        $rain24h = $arr->weatherElement[2]->elementValue;
        // echo "<br>";
        $sqlInsert = "insert into rain values('$stationId','$locationName','$city','$town','$obsTime','$rain1h','$rain24h')";
        $db->query($sqlInsert);
        // echo "<br>";
    }
    echo "updated";

    // echo "<br>";
    // print_r(($temp->records));