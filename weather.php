<?php 

    // $curl = curl_init();
    // $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-D620E1A7-8835-4C4D-928A-268DDFA7BA2E";
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($curl, CURLOPT_HEADER, 0);
    // $data = curl_exec($curl);
    // echo ($data);
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
    <?php foreach($temp->records->locations[0]->location as $locationArr){?>
            <option value="<?= $locationArr->geocode;?>">
                <?= $locationArr->locationName;?>
            </option>   
        <?php }?>
    </select>
</body>
<?php
    echo "<br><pre>";
    foreach($temp->records->locations[0]->location as $bycity){
        echo $bycity->locationName." ";
        foreach($bycity->weatherElement as $weatherArr){
            echo $weatherArr->description."<br>";
            foreach ($weatherArr->time as $bytime) {
                echo
                 $bytime->startTime
                 ." ".
                 $bytime->elementValue[0]->value.
                 $bytime->elementValue[0]->measures."<br>";
            }
            
        }
    }
    
    echo "<br>";
    var_dump($temp->records->locations[0]->location[0]->weatherElement);
?>
</html>