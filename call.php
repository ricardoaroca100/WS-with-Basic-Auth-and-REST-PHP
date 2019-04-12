<?php
// Here is the url to our web service
$url = "http://www.johanbroddfelt.se/samples/48_ws_auth/ws.php";

// The username and password used to access the service
$username = 'John';
$password = 'Doe';

// Her we create a quite large object for such a simple sample, but I wanted to show you how a larger
// structure could look like if you might need some of the structures in your code
$jObj = new stdClass();
$jObj->name = 'John Doe';
$jObj->age = 44;

// Here we create an object inside our main object
$location = new stdClass();
$location->address = "Homestreet 7";
$location->zip = "1234";
$location->city = "Hometown";

$jObj->location = $location;

// Here is an array, just to show some different kinds of data
$pObj1 = new stdClass();
$pObj1->brand = "Viper";
$pObj1->year = 1997;
$carArr[] = $pObj1;

$pObj2 = new stdClass();
$pObj2->brand = "Volvo";
$pObj2->year = 2013;
$carArr[] = $pObj2;

$jObj->cars = $carArr;

// Here we encode the object to a JSON string so that we can send it
$content = json_encode($jObj);
echo 'Sending: ' . $content . '';

$options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => "Content-type: application/json"
                   . "Accept: application/json"
                   . "Authorization: Basic " . base64_encode("$username:$password"),
        'content' => $content
    )
);
$context  = stream_context_create($options);
$json_response = file_get_contents($url, false, $context);

echo 'JSON response: ' . $json_response . '';
$response = json_decode($json_response, true);
echo 'Object: ';
var_dump($response);
