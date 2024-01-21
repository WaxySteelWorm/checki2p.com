<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
    <link rel="preload" href="/assets/fonts/InterVariable.woff2" as="font" type="font/woff2" crossorigin=anonymous>
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
</head>
<body>
    <div class="header">
        <img src="../assets/images/logo.svg" alt="Logo" class="logo">
    </div>
    <div class="donate-banner">
        Please consider donating:
        <span onclick="copyToClipboard('45Gtj5tkhs4EsbnV7kkhMCRpbZUdqCQqR5qmLFVLAvbFCYaPL4pFbBkEBLJ7beHqkiJxdTBkPwFsT5EMu5jDrYBHPjQzPuv', 'xmr-confirmation')">XMR</span> |  <span onclick="copyToClipboard('LULvg4mJc9Y37hU3sbVTMxJAPyNwyCJHw6', 'ltc-confirmation')">ETH</span> |
       
        <span onclick="copyToClipboard('1NDRuQNyJZmYK4AJwve1aqa56ntuXpbyA7', 'btc-confirmation')">BTC</span>
        <span id="xmr-confirmation" class="copy-confirmation">Copied!</span>
        <span id="ltc-confirmation" class="copy-confirmation">Copied!</span>
        <span id="btc-confirmation" class="copy-confirmation">Copied!</span>
    </div>
    <div class="message">
    <?php
    include 'checkproxy.php';
    $message = checkIfUsingProxy();

    // Determine which image to display based on the message
    $imageSrc = strpos($message, 'NOT using a known outproxy') !== false ? '../assets/images/red_light.svg' : '../assets/images/green_light.svg';
?>

<div class="status-container">
    <img src='<?php echo $imageSrc; ?>' style='height: 60px; alt='Status Indicator' class='status-light'>
    <div class='status-message'><?php echo $message; ?></div>
</div>
</div>
    <footer>
    Created by <a href=https://stormycloud.org/>stormycloud.org</a> | <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>    </footer>
    </body>
    </html>