<?php
$apiKey = '49cc426143bee1ee3b4653262a27330d'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $city = $_POST["city"];

   
    if (!empty($city)) {
        $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey";

        
        $ch = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

   
        $response = curl_exec($ch);


        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            exit;
        }

     
        curl_close($ch);

   
        $data = json_decode($response, true);

       
        if ($data && $data['cod'] == 200) {
            $cityName = $data['city']['name'];
            $country = $data['city']['country'];

            echo "<h2>Weather Forecast for $cityName, $country</h2>";

         
            $groupedData = [];
            foreach ($data['list'] as $forecast) {
                $timestamp = $forecast['dt'];
                $date = date('Y-m-d', $timestamp);

                if (!isset($groupedData[$date])) {
                    $groupedData[$date] = [
                        'temperatures' => [],
                        'descriptions' => [],
                    ];
                }

                $groupedData[$date]['temperatures'][] = $forecast['main']['temp'];
                $groupedData[$date]['descriptions'][] = $forecast['weather'][0]['description'];
            }

            foreach ($groupedData as $date => $dayData) {
                $averageTemperature = array_sum($dayData['temperatures']) / count($dayData['temperatures']);
                $description = $dayData['descriptions'][0];

                echo "<article class='content'>";
                echo "<h2>$date</h2>";
                echo "<img src='sun.png' alt='' class='image-png'>";
                echo "<p>Date: $date | Average Temperature: $averageTemperature °C | Description: $description</p>";
                echo "</article>";
            }
        } else {
            echo 'Error fetching weather data.';
        }
    } else {
        echo 'Please enter a city name.';
    }
}
?>
