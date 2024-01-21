<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    
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

</head>
<body>

    <div class="header">
        <img src="logo.png" alt="Logo" class="logo">
    </div>

    <div class="donate-banner">
        Please consider donating |
        <span onclick="copyToClipboard('45Gtj5tkhs4EsbnV7kkhMCRpbZUdqCQqR5qmLFVLAvbFCYaPL4pFbBkEBLJ7beHqkiJxdTBkPwFsT5EMu5jDrYBHPjQzPuv', 'xmr-confirmation')">XMR</span> |
        <span onclick="copyToClipboard('LULvg4mJc9Y37hU3sbVTMxJAPyNwyCJHw6', 'ltc-confirmation')">ETH</span> |
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
        // Show green light if using a known outproxy, red light if not
        $imageSrc = strpos($message, 'NOT using a known outproxy') !== false ? 'red_light.svg' : 'green_light.svg';

        // Display the image and message
        echo "<img src='$imageSrc' alt='Status Indicator' style='height: 80px; vertical-align: middle;'> $message";
    ?>
</div>

    <footer>
        Created by stormycloud.org |
        <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> |
        <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> |
        <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>
    </footer>

    </body>
    </html>