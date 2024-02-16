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
            <form id="domainCheckForm">
        Domain: <input type="text" name="domain" id="domain"><br>
        <button type="submit">Check Domain</button>
    </form>
    <div id="result"></div>
    <div id="advancedInfo" style="display:none;"></div>

    <script>
        $(document).ready(function(){
            $('#domainCheckForm').on('submit', function(e){
                e.preventDefault(); // Prevent default form submission
                var domain = $('#domain').val();
                $.ajax({
                    url: 'check_domain.php',
                    type: 'POST',
                    data: { domain: domain },
                    success: function(response) {
                        $('#result').html(response);
                        $('#advancedInfo').html('').hide();
                    }
                });
            });

            $(document).on('click', '#showAdvanced', function(e){
                e.preventDefault(); // Prevent default link action
                var domain = $('#domain').val(); // Get the domain from the input field
                $.ajax({
                    url: 'check_domain.php',
                    type: 'GET',
                    data: { domain: domain },
                    success: function(advancedInfo) {
                        $('#advancedInfo').html(advancedInfo).show(); // Set and show advanced info
                    }
                });
            });
        });
    </script>

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
