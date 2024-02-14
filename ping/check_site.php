<?php

session_start();

// Rate limiting parameters
$limit = 5; // Maximum number of requests per time frame
$timeout = 60; // Time frame in seconds

// Initialize or update session tracking for rate limiting
if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = time();
    $_SESSION['request_count'] = 0;
}

if (time() - $_SESSION['last_request_time'] < $timeout) {
    $_SESSION['request_count']++;
} else {
    $_SESSION['request_count'] = 1;
    $_SESSION['last_request_time'] = time();
}

if ($_SESSION['request_count'] > $limit) {
    echo "Rate limit exceeded. Please try again later.";
    exit;
}


// Validate domain function
function isValidDomain($domain) {
    // Check if domain ends with .i2p
    return preg_match("/^.+\.i2p$/", $domain);
}


// Check if form was submitted and domain field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['domain'])) {
    $domain = $_POST['domain'];

    // Validate domain
    if (!isValidDomain($domain)) {
        echo "Invalid domain. Please enter a valid domain.";
        exit;
    }

    // Define an array of proxies
    $proxies = ['reseed.stormycloud.org:4444'];

    $success = false;

    foreach ($proxies as $proxy) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if ($response !== false && curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
            echo "Okay - Accessed via proxy: $proxy";
            $success = true;
            break; // Exit the loop if successful
        }

        curl_close($ch);
    }

    if (!$success) {
        echo "Error - All proxies failed or site is down";
    }
} else {
    echo "Please submit a domain to check.";
}
?>
