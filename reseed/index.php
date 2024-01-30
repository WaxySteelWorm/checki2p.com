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
include 'db.php'; // Ensure this path is correct for your db.php file

$result = $conn->query("SELECT * FROM server_status ORDER BY server_name");

echo "<table class='status-table'>";
echo "<tr><th>Server Name</th><th>Status</th><th>Details</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["server_name"]) . "</td>";

    $status = $row["status"];
    $status_message = htmlspecialchars($row["status_message"]);
    $last_checked = new DateTime($row["last_checked"]);
    $now = new DateTime();

    $details = "";
    if ($status === 'offline') {
        $first_offline = isset($row["first_offline"]) ? new DateTime($row["first_offline"]) : $last_checked;
        $interval = $first_offline->diff($now);
        $details = "Offline since " . $first_offline->format('Y-m-d H:i') . " (" . $interval->format('%a days, %h hours, %i minutes') . ")";
    } elseif ($status === 'warning') {
        $details = $status_message;
    }

    $status_class = $status === 'online' ? 'glowing-green' : ($status === 'offline' ? 'glowing-red' : 'glowing-yellow');
    echo "<td><span class='dot $status_class' title='$details'></span> " . strtoupper($status) . "</td>";
    echo "<td>" . $details . "</td>";
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
