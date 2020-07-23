

<!doctype html>
<html>
<head>
<title>Weather forecast with PHP</title>

<style>
body {
    font-family: Arial;
    font-size: 0.95em;
    color: #929292;
   
}

.weather-container {
    border: #E0E0E0 1px solid;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 550px;
    margin: 0 auto;
}
.weather-icon {
    vertical-align: middle;
}

</style>
<body>
<?php    


$url = "http://api.ipstack.com/check?access_key=7184746f9d7ae7a116f11f634fbdb157&format=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$response = json_decode($response);
$city  = $response->city;
?>

<?php
$apiKey = "fbf652243dd227d900588132132aafbc";
   if (isset($_GET["cityname"]))
            {
       
                $cityName = $_GET["cityname"]; 
                $city = $cityName;
            }else
            {
                $cityName = $city;
            }

$url = "http://api.openweathermap.org/data/2.5/weather?q=" . $cityName . "&lang=en&units=metric&APPID=" . $apiKey;


$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response);

$currentDate = time();
?>
    <div class="weather-container">
        <h2>Weather Forecast Widget</h2>
        <?php 
            if($data->cod != 200){
                echo 'Plese enter a valid city';
            }
        ?>
        <div class="date">
         
            <div><?php if(isset($data->name)){echo $data->name;}else{ echo $city ;} ?></div>
            <div><?php echo date("jS F, Y",$currentDate); ?></div>
        </div>
        <div class="weather-forecast">
            <?php if($data->cod == 200){ ?>
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                class="weather-icon" /> <?php echo $data->main->temp_max; ?>&deg;C / <span
                class="min-temperature"><?php echo $data->main->temp_min; ?>&deg;C</span>
                
        </div>
        <div class="time">
            <div>Humidity: <?php echo $data->main->humidity; ?> %</div>
            <div>Wind: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
            <?php } ?>
         <h3>Enter a city to search</h3>
         <form action ="index.php" method="get">
         <input type="text" pattern="[A-Za-z]+" name="cityname" title="City name may only contain letters" />
         <input type="submit" value="Go" /> </form>
        </div>

</body>
</html>