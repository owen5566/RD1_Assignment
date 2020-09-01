<?php
     $method = $_SERVER['REQUEST_METHOD'];
    // rtrim($_GET["url"], "/")."<hr>";
     $url = explode("/", rtrim($_GET["url"], "/") );
    // echo $method." ".$url[0];
    switch($method." ".$url[0]){
        case "POST getCity":
            echo getJSON();
            // echo __DIR__."/temp.json";
        break;
    }

    // var_dump($temp = json_decode($temp));
    // echo getCity();
    function getJSON(){
        $temp = file_get_contents("../temp.json");
           
        return $temp;
    }