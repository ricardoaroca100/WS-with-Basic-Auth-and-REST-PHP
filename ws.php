<?php
// WEB SERVICE

// Make sure you get a login prompt if you try to access the service
if (!isset($_SERVER['PHP_AUTH_USER']) and !$_SERVER['PHP_AUTH_USER']) {
    header('WWW-Authenticate: Basic realm="LOGIN REQUIRED"');
    header('HTTP/1.0 401 Unauthorized');
    $status = array('error' => 1, 'message' => 'Access denied 401!');
    echo json_encode($status);
    exit;
}

// Check if you could login. This is of course a very simple check. You probably have a login function to check the user
$accessOk = false;
if ($_SERVER['PHP_AUTH_USER'] == 'John' and $_SERVER['PHP_AUTH_PW'] == 'Doe') {
	$accessOk = true;
}

// If the login fail we prompt the login box again
if (!$accessOk) {
    header('WWW-Authenticate: Basic realm="WRONG PASSWORD"');
    header('HTTP/1.0 401 Unauthorized');
    $status = array('error' => 2, 'message' => 'Wrong username or password!');
    echo json_encode($status);
    exit;
}

// If we manage to get in we read the content from the POST and turn it into a php object
$jContent = file_get_contents('php://input');
$jObj = json_decode($jContent); //convert JSON into array
#echo '' . $jContent . '';
#print_r($jObj);
#echo '';
$carsCnt = count($jObj->cars);

// Then we compose a string and add it to our return array and print it to screen as a reply
$status = array('error' => 0, 'message' => 'Hi ' . $jObj->name . '. You live in ' . $jObj->location->city . ' and have ' . $carsCnt . ' cars. Have a nice day!');
echo json_encode($status);
