<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Website Test</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
        
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
            <form method="post" action="index.php">
        <label for="domain">Enter I2P Domain:</label>
        <input type="text" id="domain" name="domain" required>
        <input type="submit" value="Check Status">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the domain from the form input
    $domain = $_POST['domain'];

    // Add 'http://' if missing
    if (substr($domain, 0, 7) !== "http://") {
        $domain = "http://" . $domain;
    }

    // The URL of the checking script
    $checkUrl = "https://reseed.stormycloud.org/cgi-bin/check.sh?" . $domain;

    // Use cURL to send the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $checkUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check if there was a cURL error (optional)
    if ($response === false) {
        echo "<p>Error: Unable to check the domain status.</p>";
    } else {
        // Decode the JSON response
        $statusData = json_decode($response, true);
        $status = $statusData['status'] ?? 'offline'; // Default to offline if status is not set

        // Display the status with a colored dot
        if ($status === 'online') {
            echo "<p><span class='dot glowing-green'></span>" . htmlspecialchars($domain) . " is Online</p>";
        } else {
            echo "<p><span class='dot glowing-red'></span>" . htmlspecialchars($domain) . " is Offline</p>";
        }
    }
}
?>



</body>


            </div>
        </div>
    </div>

    <footer class="reseed-footer">
    Created by <a href="https://stormycloud.org/">stormycloud.org</a> | 
    <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | 
    <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | 
    <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>
</footer>
</body>
</html>
