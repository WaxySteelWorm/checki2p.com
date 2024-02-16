<?php
session_start();

$statusMessage = '';
$advancedInfo = '';
$displayAdvanced = false;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['domain'])) {
    $domain = $_POST['domain'];

    // Validate the domain
    if (!preg_match('/^[a-zA-Z0-9.-]+\.(i2p|I2P)$/', $domain)) {
        $statusMessage = 'Invalid domain. Only domains ending in .i2p or .I2P are allowed.';
    } else {
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

        // Store headers and determine status
        $_SESSION['advanced'][$domain] = explode("\n", trim($output));
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
    if (isset($_SESSION['advanced'][$domain])) {
        $advancedInfo = implode('<br>', $_SESSION['advanced'][$domain]);
        $displayAdvanced = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Website Test</title>
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
            <form id="domainCheckForm" method="POST">
        <div style="text-align: center;">
            <label for="domain">I2P Domain:</label><br>
            <input type="text" name="domain" id="domain" value="<?php echo htmlspecialchars($domain ?? ''); ?>"><br>
            <button type="submit">Check Domain</button>
        </div>
    </form>
    <?php if (!empty($statusMessage)): ?>
        <div id="result"><?php echo $statusMessage; ?></div>
        <div><?php if (!$displayAdvanced): ?>
            <a href="?advanced=true&domain=<?php echo urlencode($domain); ?>">Show advanced information</a>
        <?php endif; ?></div>
    <?php endif; ?>
    <?php if ($displayAdvanced && !empty($advancedInfo)): ?>
        <div id="advancedInfo"><?php echo $advancedInfo; ?></div>
    <?php endif; ?>
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
