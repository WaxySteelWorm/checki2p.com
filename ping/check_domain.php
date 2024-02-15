<?php
session_start(); // Start the session to store advanced data

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['domain'])) {
    $domain = $_POST['domain'];

    // Validate the domain
    if (!preg_match('/^[a-zA-Z0-9.-]+\.(i2p|I2P)$/', $domain)) {
        echo 'Invalid domain. Only domains ending in .i2p or .I2P are allowed.';
        exit;
    }

    $url = 'http://' . $domain; // Assuming HTTP for I2P domains
    $proxy = 'reseed.stormycloud.org:5555'; // Your proxy address

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);

    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode >= 200 && $httpcode < 300) {
        $status = "$domain is online.";
    } else {
        $status = "$domain is offline.";
    }

    // Store advanced headers in session
    $_SESSION['advanced'][$domain] = explode("\n", trim($output));

    echo $status . ' <a href="#" id="showAdvanced">Show advanced information</a>';

} elseif (isset($_GET['domain']) && isset($_SESSION['advanced'][$_GET['domain']])) { // Additional check for advanced data
    $domain = $_GET['domain'];
    if (isset($_SESSION['advanced'][$domain])) {
        foreach ($_SESSION['advanced'][$domain] as $header) {
            echo htmlspecialchars($header) . '<br>';
        }
    }
}
?>
