<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['domain']) && isset($_POST['mode'])) {
    $domain = $_POST['domain'];
    $mode = $_POST['mode'];

    // Validate the domain
    if (!preg_match('/^[a-zA-Z0-9.-]+\.(i2p|I2P)$/', $domain)) {
        echo 'Invalid domain. Only domains ending in .i2p or .I2P are allowed.';
        exit;
    }

    // Set proxy and URL
    $proxy = 'reseed.stormycloud.org:5555'; // Your proxy address
    $url = 'http://' . $domain; // Assuming HTTP for I2P domains

    // Initialize a cURL session
    $ch = curl_init($url);

    // Set options for cURL
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);

    // Execute and get information
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Prepare the response based on mode
    if ($httpcode >= 200 && $httpcode < 300) {
        $status = "$domain is online.";
    } else {
        $status = "$domain is offline.";
    }

    if ($mode === 'basic') {
        echo $status;
    } else if ($mode === 'advanced') {
        echo $status;
        if ($httpcode >= 200 && $httpcode < 300) {
            echo '<br><a href="#" onclick="$(\'#advancedInfo\').toggle();return false;">Show advanced Information</a>';
            echo '<div id="advancedInfo" style="display:none;">';
            foreach (explode("\n", trim($output)) as $header) {
                echo htmlspecialchars($header) . '<br>';
            }
            echo '</div>';
        }
    }
}
?>
