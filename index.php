<?php

function sendRequst($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result,true);
}

$isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

$city = (isset($_GET['city']) && substr($_GET['city'], 0, 1) == ":") ? substr($_GET['city'], 1) : 'berlin';

$cityUrl = 'https://restcountries.eu/rest/v2/capital/'.$city;
$cityData = sendRequst($cityUrl);
$country = $cityData[0]['name'];
$currency = $cityData[0]['currencies'][0]['code'];

$weatherApiKey = '*****************************'; // you get yours after registration on https://openweathermap.org/api
$weatherUrl = 'http://api.openweathermap.org/data/2.5/weather?q='.ucfirst($city).'&APPID='.$weatherApiKey;
$weatherData = sendRequst($weatherUrl);
$weather = $weatherData['weather'][0]['icon'];

switch($weather) {
	case '01d':
	case '02d':
		$weatherIcon = 'cloud-sun';
		break;
	case '01n':
	case '02n':
		$weatherIcon = 'cloud-moon2';
		break;
	case '03d':
	case '03n':
		$weatherIcon = 'cloud';
		break;
	case '04d':
	case '04n':
		$weatherIcon = 'clouds';
		break;
	case '09d':
	case '09n':
		$weatherIcon = 'cloud-raindrops';
		break;
	case '10d':
		$weatherIcon = 'cloud-sun-raindrops';
		break;
	case '10n':
		$weatherIcon = 'cloud-moon-raindrops';
		break;
	case '11d':
		$weatherIcon = 'cloud-sun-lightning';
		break;
	case '11n':
		$weatherIcon = 'cloud-moon-lightning';
		break;
	case '13d':
		$weatherIcon = 'cloud-sun-snowflakes';
		break;
	case '13n':
		$weatherIcon = 'cloud-moon-snowflakes';
		break;
	case '50d':
		$weatherIcon = '-cloud-sun-fog';
		break;
	case '50n':
		$weatherIcon = 'cloud-moon-fog';
		break;
	default:
		$weatherIcon = 'cloud2';
		break;
}

$kelvinTemp = $weatherData['main']['temp'];
$celsiusTemp = round($kelvinTemp - 273.15);

?>
<html>
<head>
	<link rel="stylesheet" href="assets/stylesheet.css">
	<script defer src="assets/weather-icons/svgxuse.js"></script>
</head>
<body>
	<?php if(!$isMobile){ ?>
	<div id="info-block">
		<table>
			<tbody>
				<tr>
					<td id="icon-block">
						<svg class="icon float-right icon-<?php echo $weatherIcon;?>"><use xlink:href="assets/weather-icons/symbol-defs.svg#icon-<?php echo $weatherIcon;?>"></use></svg>
					</td>
					<td id="text-block">
						<p id="city-country"><span><?php echo ucfirst($city);?></span><?php echo ', '.$country; ?></p>
						<p id="deg"><?php echo $celsiusTemp.' deg'; ?></p>
						<p id="currency"><span>Currency: </span><?php echo $currency; ?></p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
	<div>
		<p id="city-country"><span><?php echo ucfirst($city);?></span><?php echo ', '.$country; ?></p>
	</div>
	<div id ="icon-mobile">
		<svg class="icon icon-<?php echo $weatherIcon;?>"><use xlink:href="assets/weather-icons/symbol-defs.svg#icon-<?php echo $weatherIcon;?>"></use></svg>
	</div>
	<div id = "text-mobile">
		<p id="deg"><?php echo $celsiusTemp.' deg'; ?></p>
		<p id="currency"><span>Currency: </span><?php echo $currency; ?></p>
	</div>
	<?php } ?>
</body>
</html>