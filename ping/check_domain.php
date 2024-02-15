<?php
session_start();

// Implement rate limiting
$rate_limit = 5; // Max requests
$rate_time = 600; // Time in seconds (10 minutes)
if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

// Clean up old requests
$_SESSION['requests'] = array_filter($_SESSION['requests'], function($time) use ($rate_time) {
    return $time > time() - $rate_time;
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (count($_SESSION['requests']) >= $rate_limit) {
        die(json_encode(['error' => 'Rate limit exceeded. Please try again later.']));
    } else {
        $_SESSION['requests'][] = time(); // Log the time of this request
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['domain'])) {
    $domain = $_POST['domain'];

    // Validate the domain
    if (!preg_match('/^[a-zA-Z0-9.-]+\.(i2p|I2P)$/', $domain)) {
        echo 'Invalid domain. Only domains ending in .i2p or .I2P are allowed.';
        exit;
    }

    // Set up cURL
    $url = 'http://' . $domain; // Assuming HTTP for I2P domains
    $proxy = 'reseed.stormycloud.org:5555'; // Proxy address
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check if online and store result
    $status = $httpcode >= 200 && $httpcode < 300 ? "$domain is online." : "$domain is offline.";
    $_SESSION['advanced'][$domain] = explode("\n", trim($output)); // Store headers

    echo $status . ' <a href="#" id="showAdvanced">Show advanced information</a>';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['domain'])) {
    $domain = $_GET['domain'];
    if (isset($_SESSION['advanced'][$domain])) {
        foreach ($_SESSION['advanced'][$domain] as $header) {
            echo htmlspecialchars($header) . '<br>';
        }
    } else {
        echo "No advanced information available.";
    }
}

}
?>
