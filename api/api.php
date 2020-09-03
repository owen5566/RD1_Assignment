<?php
    $method = $_SERVER['REQUEST_METHOD'];
    // rtrim($_GET["url"], "/")."<hr>";
    $url = explode("/", rtrim($_GET["url"], "/") );
    $db = new PDO("mysql:host=localhost;dbname=RD1_db;port=8889", "root", "root");
    $db->exec("set names utf8");

    switch($method." ".$url[0]){
        case "POST getCity":
            echo getCity();
        break;
        case "POST getWeather":
            echo getWeather();
            
        break;
    }

    function getCity(){
        global $db;
        if($result = $db->query("select * from cityCode")){
            $data = ["success"];
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }return json_encode($data, JSON_UNESCAPED_UNICODE);
        }else {
            return 0;
        }
    }
    function getWeather(){
        global $db;
        date_default_timezone_set("Asia/Taipei");
        $now = date('Y-m-d H:i:s');
        $geoCode = $_POST["geocode"];
        if($result = $db->query("select geocode,startTime,endTime,PoP12h,minTemp,maxTemp,UVI,wx from weather where geoCode = $geoCode and endTime>'$now' order by startTime")){
            $data = ["success"];
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }return json_encode($data, JSON_UNESCAPED_UNICODE);
        }else {
            return 0;
        }
    }