<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://sports-data3.p.rapidapi.com/nba",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: sports-data3.p.rapidapi.com",
		"X-RapidAPI-Key: e103566983mshc38d5759511e755p19cbe7jsn25aa72f7ea8e"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$response = json_decode($response, true);
}

?>