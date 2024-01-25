<?php
include '../../checkproxy.php'; 

$userIP = $_SERVER['REMOTE_ADDR'];
list($message, $proxyDetails) = checkIfUsingProxy();

$isUsingOutProxy = strpos($message, 'NOT using a known outproxy') === false;

$response = [
    'isOutProxy' => $isUsingOutProxy,
    'IP' => $userIP
];

if ($isUsingOutProxy) {
    $response['proxyName'] = $proxyDetails['name'];
    $response['proxyLocation'] = $proxyDetails['location'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
