<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Reseed Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
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

$result = $conn->query("SELECT * FROM server_status ORDER BY server_name");

echo "<table class='status-table'>";
echo "<tr><th>Server Name</th><th>Status</th></tr>";

while($row = $result->fetch_assoc()) {
    # ... [existing code] ...

    if ($status === 'offline') {
        $first_offline = new DateTime($row["first_offline"]);
        $interval = $first_offline->diff($now);
        $tooltip = "Offline since " . $first_offline->format('Y-m-d H:i') . " (" . $interval->format('%a days, %h hours, %i minutes') . ")";
    } elseif ($status === 'warning') {
        $tooltip = $status_message;
        $status_text = "WARNING";
    }


    $status_class = $status === 'online' ? 'glowing-green' : ($status === 'offline' ? 'glowing-red' : 'glowing-yellow');
    echo "<td><div class='status-container' title='$tooltip'><span class='dot $status_class'></span><span class='status-text'>$status_text</span></div></td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();
?>

            </div>
        </div>


    </div>
</body>
</html>
