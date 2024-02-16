<?php
session_start(); // Start the session at the very beginning

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
    if ($httpcode >= 200 && $httpcode < 300) {
        $status = "<span>$domain is </span><span class='dot glowing-green'></span><span>online.</span>";
    } else {
        $status = "<span>$domain is </span><span class='dot glowing-red'></span><span>offline.</span>";
    }
    $_SESSION['advanced'][$domain] = explode("\n", trim($output)); // Store headers

    echo "<div id='status'>$status</div>"; // Wrap status in a div for styling
    echo '<div><a href="#" id="showAdvanced">Show advanced information</a></div>'; // Ensure it's on a new line
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['domain'])) {
    $domain = $_GET['domain'];
    if (isset($_SESSION['advanced'][$domain])) {
        echo "<div>"; // Ensure advanced information is contained
        foreach ($_SESSION['advanced'][$domain] as $header) {
            echo htmlspecialchars($header) . '<br>';
        }
        echo "</div>";
    } else {
        echo "No advanced information available.";
    }
}
?>
