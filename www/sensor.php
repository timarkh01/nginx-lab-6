<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://lab6_clickhouse:8123/']);


function sensor_insert($sensor_id, $type, $value, $unit) {
    global $client;
    $sql = "INSERT INTO sensor_data (event_time, sensor_id, sensor_type, value, unit) VALUES ";
    $sql .= "(now(), $sensor_id, '$type', $value, '$unit')";
    return $client->post('', ['body' => $sql])->getBody()->getContents();
}


function sensor_latest($limit = 10) {
    global $client;
    $sql = "SELECT * FROM sensor_data ORDER BY event_time DESC LIMIT $limit";
    $response = $client->post('', ['body' => $sql]);
    return json_decode($response->getBody(), true);
}


function sensor_avg($type, $minutes = 5) {
    global $client;
    $sql = "SELECT avg(value) FROM sensor_data WHERE sensor_type = '$type' AND event_time > now() - $minutes * 60";
    $response = $client->post('', ['body' => $sql]);
    $data = json_decode($response->getBody(), true);
    return $data['data'][0][0] ?? 0;
}
?>