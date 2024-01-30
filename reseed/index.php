<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Reseed Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/reseed.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
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
                <?php
                include 'db.php';

                $result = $conn->query("SELECT * FROM server_status");
                $last_checked_global = "";

                echo "<table class='status-table'>";
                echo "<tr><th>Server Name</th><th>Status</th></tr>";

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["server_name"] . "</td>";
                    if ($row["status"] == "offline") {
                        echo "<td><span class='dot glowing-red'></span> OFFLINE since " . $row["last_checked"] . "</td>";
                    } else {
                        echo "<td><span class='dot glowing-green'></span> ONLINE</td>";
                    }
                    echo "</tr>";
                    $last_checked_global = $row["last_checked"];
                }

                echo "</table>";

                echo "<p class='last-checked'>Last Checked: " . $last_checked_global . "</p>";

                $conn->close();
                ?>
            </div>
        </div>

        <footer>
        Created by <a href=https://stormycloud.org/>stormycloud.org</a> | <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>    </footer>
        </footer>
    </div>
</body>
</html>
