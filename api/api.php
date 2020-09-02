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
        $geoCode = $_POST["geocode"];
        if($result = $db->query("select * from weather where geoCode = $geoCode")){
            $data = ["success"];
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }return json_encode($data, JSON_UNESCAPED_UNICODE);
        }else {
            return 0;
        }
    }