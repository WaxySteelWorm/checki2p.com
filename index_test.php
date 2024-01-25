
<?php
include 'checkproxy.php';

function isApiRequest() {
    // Check for a query parameter or HTTP Accept header
    return isset($_GET['api']) || strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
}

function getApiResponse($message, $userIP) {
    $isUsingProxy = strpos($message, 'NOT using a known outproxy') === false;
    return json_encode([
        'isProxy' => $isUsingProxy,
        'IP' => $userIP
    ]);
}

$userIP = $_SERVER['REMOTE_ADDR'];
$message = checkIfUsingProxy();

if (isApiRequest()) {
    header('Content-Type: application/json');
    echo getApiResponse($message, $userIP);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>I2P Proxy Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
</head>
<body>
    <div class="status-container">
        <?php
        // Determine which image to display based on the message
        $imageSrc = strpos($message, 'NOT using a known outproxy') !== false ? '../assets/images/red_light.svg' : '../assets/images/green_light.svg';
        $imageAlt = strpos($message, 'NOT using a known outproxy') !== false ? 'Red Light Indicator - Not using a known outproxy' : 'Green Light Indicator - Using a known outproxy';
        ?>
        <img src='<?php echo $imageSrc; ?>' alt='<?php echo $imageAlt; ?>' class='status-light'>
        <div class='status-message'><?php echo $message; ?></div>
    </div>
</body>
</html>
