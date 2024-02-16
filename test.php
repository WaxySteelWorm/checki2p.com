<html>
<head>
    <style>
        .copy-confirmation {
    display: none;
    /* Add more styling here */
}
</style>
</head>
<body>
<div class="donate-banner">
    Please consider donating:
    <button onclick="copyToClipboard('45Gtj5tkhs4EsbnV7kkhMCRpbZUdqCQqR5qmLFVLAvbFCYaPL4pFbBkEBLJ7beHqkiJxdTBkPwFsT5EMu5jDrYBHPjQzPuv', 'xmr-confirmation')">Copy XMR Address</button>
    <button onclick="copyToClipboard('LULvg4mJc9Y37hU3sbVTMxJAPyNwyCJHw6', 'ltc-confirmation')">Copy ETH Address</button>
    <button onclick="copyToClipboard('1NDRuQNyJZmYK4AJwve1aqa56ntuXpbyA7', 'btc-confirmation')">Copy BTC Address</button>
    <span id="xmr-confirmation" class="copy-confirmation">Copied!</span>
    <span id="ltc-confirmation" class="copy-confirmation">Copied!</span>
    <span id="btc-confirmation" class="copy-confirmation">Copied!</span>
</div>
</body>
</html>