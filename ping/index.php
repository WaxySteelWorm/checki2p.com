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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Website Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
        <!-- ... [Defines Crypto Copy to Clipboard function] ... -->
        <script>
        function copyToClipboard(text, elementId) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";  
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);

            // Show copy confirmation
            var confirmation = document.getElementById(elementId);
            confirmation.style.display = "inline";
            setTimeout(function() {
                confirmation.style.display = "none";
            }, 2000);  // Hide confirmation after 2 seconds
        }
    </script>


<header>
    <span id="homelink"></span>
    <nav>
        <ul>
            <li><a href="../index.php">CheckI2P.com</a></li>
            <li><a href="../reseed/index.php">Reseed Server Status</a></li>
            <li><a href="../ping/index.php">I2P Website Check</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
</header>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="../assets/images/logo.svg" alt="Logo" class="logo">
        </div>

        <div class="content">
            <div class="donate-banner">
        Please consider donating:
        <span onclick="copyToClipboard('45Gtj5tkhs4EsbnV7kkhMCRpbZUdqCQqR5qmLFVLAvbFCYaPL4pFbBkEBLJ7beHqkiJxdTBkPwFsT5EMu5jDrYBHPjQzPuv', 'xmr-confirmation')">XMR</span> |  <span onclick="copyToClipboard('LULvg4mJc9Y37hU3sbVTMxJAPyNwyCJHw6', 'ltc-confirmation')">ETH</span> |
       
        <span onclick="copyToClipboard('1NDRuQNyJZmYK4AJwve1aqa56ntuXpbyA7', 'btc-confirmation')">BTC</span>
        <span id="xmr-confirmation" class="copy-confirmation">Copied!</span>
        <span id="ltc-confirmation" class="copy-confirmation">Copied!</span>
        <span id="btc-confirmation" class="copy-confirmation">Copied!</span>
    </div>            </div>

            <div class="message">
            <form method="POST">
            <input type="text" id="domain" name="domain" placeholder="Enter I2P Domain" value="<?php echo htmlspecialchars($domain); ?>">
            <button type="submit">Check Status</button>
        </form>
        <?php if (!empty($statusMessage)): ?>
            <div class="status"><?php echo $statusMessage; ?></div><br>
            <?php if (!$displayAdvanced): ?>
                <a href="?advanced=true&domain=<?php echo urlencode($domain); ?>">Show Advanced Information</a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($displayAdvanced && !empty($advancedInfo)): ?>
            <div><?php echo $advancedInfo; ?></div>
        <?php endif; ?>
    </div>

    <footer class="reseed-footer">
    Created by <a href="https://stormycloud.org/">stormycloud.org</a> | 
    <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | 
    <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | 
    <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>
</footer>
</body>
</html>
