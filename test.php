<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
 <style>

header {
    position: sticky;
    top: 0;
    z-index: 999;
    padding: 10px 10px 4px;
    background: #d3d3d3; /* Adjust the background color as needed */
    border-bottom: 2px solid black; /* Adjust the border color as needed */
    animation: down .5s ease .8s both;
}

header a {
    font-weight: 700 !important;
    color: black; /* Adjust the text color as needed */
    text-decoration: none;
}

header ul {
    display: flex;
    justify-content: space-around;
    justify-content: right;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0 0 8px;
}

header li {
    line-height: 1.6;
    margin: 0 10px;
}

    </style>
</head>
<body>

<!-- Header -->
<header>
    <span id="homelink"></span>
    <nav>
        <ul>
            <li><a href="outproxy.html">I2P Outproxy</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="donate.html">Donate</a></li>
            <li><a href="contact.html">Contact</a></li>
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
Test stuff

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
