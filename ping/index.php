<?php
// Start a session to store advanced info between requests
session_start();

// Initialize variables
$statusMessage = '';
$advancedInfo = '';
$displayAdvanced = false;
$domain = ''; // Initialize the domain variable

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['domain'])) {
    $domain = trim($_POST['domain']); // Get the domain from POST data

    // Remove 'http://' or 'https://' from the domain if present
    $domain = preg_replace('#^https?://#', '', $domain);

    // Validate the domain format
    if (!preg_match('/^[a-zA-Z0-9.-]+\.(i2p|I2P)$/', $domain)) {
        $statusMessage = 'Invalid domain. Only domains ending in .i2p or .I2P are allowed.';
    } else {
        // Domain is valid, proceed with checking the status
        $url = 'http://' . $domain; // Construct the URL for the cURL request
        $proxy = 'reseed.stormycloud.org:5555'; // Specify the I2P proxy address
        $ch = curl_init($url); // Initialize a cURL session

        // Set cURL options
        curl_setopt($ch, CURLOPT_NOBODY, true); // We only need the response headers
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in the output
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_PROXY, $proxy); // Set the proxy server for I2P

        // Execute the cURL request
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the response status code
        curl_close($ch); // Close the cURL session

        // Store headers for advanced information
        $_SESSION['advanced'][$domain] = explode("\n", trim($output));

        // Set the status message based on the HTTP status code
        if ($httpcode >= 200 && $httpcode < 300) {
            $statusMessage = "<span>$domain is <span class='dot glowing-green'></span>online.</span>";
        } else {
            $statusMessage = "<span>$domain is <span class='dot glowing-red'></span>offline.</span>";
        }
    }
}

// Check if advanced information is requested
if (isset($_GET['advanced'], $_GET['domain'])) {
    $domain = $_GET['domain'];
    $domain = preg_replace('#^https?://#', '', $domain); // Sanitize the domain

    // Display advanced information if available
    if (isset($_SESSION['advanced'][$domain])) {
        $headers = $_SESSION['advanced'][$domain];
        $advancedInfo = '<table border="1"><tr><th>Header</th><th>Value</th></tr>';
        foreach ($headers as $header) {
            if (strpos($header, ':') !== false) {
                list($key, $value) = explode(':', $header, 2);
                $advancedInfo .= "<tr><td>".htmlspecialchars($key)."</td><td>".htmlspecialchars(trim($value))."</td></tr>";
            }
        }
        $advancedInfo .= '</table>';
        $displayAdvanced = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>I2P Website Status Checker</title>
    <style>
        .container {
            text-align: center;
            margin-top: 20px;
        }

        .dot {
            height: 15px;
            width: 15px;
            border-radius: 50%;
            display: inline-block;
        }

        .glowing-green {
            background-color: #4CAF50;
            box-shadow: 0 0 8px #4CAF50;
        }

        .glowing-red {
            background-color: #f44336;
            box-shadow: 0 0 8px #f44336;
        }

        table {
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>I2P Website Status Checker</h1>
        <form method="POST">
            <label for="domain">Enter I2P Domain:</label><br>
            <input type="text" id="domain" name="domain" value="<?php echo htmlspecialchars($domain); ?>"><br>
            <button type="submit">Check Status</button>
        </form>
        <?php if (!empty($statusMessage)): ?>
            <p><?php echo $statusMessage; ?></p>
            <?php if (!$displayAdvanced): ?>
                <a href="?advanced=true&domain=<?php echo urlencode($domain); ?>">Show Advanced Information</a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($displayAdvanced && !empty($advancedInfo)): ?>
            <div><?php echo $advancedInfo; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
