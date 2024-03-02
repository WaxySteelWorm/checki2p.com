<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
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
            <li><a href="../ping/index.php">I2P Website Check</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
</header>
</head>
<body>
    <div class="header">
        <img src="../assets/images/logo.svg" alt="Logo" class="logo">
    </div>

    <div class="message">
    <div class="donation-section">
        <h2 class="donation-title">Support CheckI2P.com</h2>
        <p class="donation-text">CheckI2P.com is proudly developed and maintained by <a href="your-link-here" class="bold-link">StormyCloud Inc.</a> Your donation will contribute to the ongoing operations of StormyCloud Inc. With community support, we aim to expand our influence within the privacy-focused community.</p>
        <p class="donation-text">All donations are directed towards the operating expenses of StormyCloud Inc and are exclusively used to fund initiatives centered on privacy.</p>
    </div>

    <table id="donate_options">
<thead>
  <tr>
    <th>Monero (XMR)</th> 
    <th>Bitcoin (BTC)</th> 
    <th>Ethereum (ETH)</th> 
    <th>Litecoin (LTC)</th> 
  </tr>
  <tr>
    <th><img src="../assets/images/xmr.png" width="150" height="150"></th>
    <th><img src="../assets/images/btc.png" width="150" height="150"></th>
    <th><img src="../assets/images/eth.png" width="150" height="150"></th>
    <th><img src="../assets/images/ltc.png" width="150" height="150"></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><span>45Gtj5tkhs4EsbnV7kkhMCRpbZUdqCQqR5qmLFVLAvbFCYaPL4pFbBkEBLJ7beHqkiJxdTBkPwFsT5EMu5jDrYBHPjQzPuv</span></td>
    <td><span>1NDRuQNyJZmYK4AJwve1aqa56ntuXpbyA7</span></td>
    <td><span>0x07FA04Bd6660dCB8f0C9338F37aBdA67A656CA2F</span></td>
    <td><span>LULvg4mJc9Y37hU3sbVTMxJAPyNwyCJHw6</span></td>
  </tr>
</tbody>
</table>
</div>
    <footer>
    Created by <a href=https://stormycloud.org/>stormycloud.org</a> | <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>    </footer>
    </body>
    </html>
