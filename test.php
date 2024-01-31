<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
 <style>

header, footer, img {
    user-select: none;
}

header {
    position: sticky;
    top: 0;
    z-index: 999;
    padding: 10px 10px 4px;
    background: #d3d3d3; /* Adjust the background color as needed */
    border-bottom: 2px solid #14476c; /* Adjust the border color as needed */
    animation: down .5s ease .8s both;
}

header a {
    font-weight: 700 !important;
    color: white; /* Adjust the text color as needed */
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
            <?php
include 'db.php'; // Ensure this path is correct for your db.php file

$result = $conn->query("SELECT * FROM server_status ORDER BY last_checked DESC");

$last_checked_global = "";

echo "<table class='status-table'>";
echo "<tr><th>Server Name</th><th>Status</th></tr>";

while($row = $result->fetch_assoc()) {
    if (empty($last_checked_global)) {
        $last_checked_global = $row["last_checked"];
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["server_name"]) . "</td>";

    $status = $row["status"];
    $status_message = htmlspecialchars($row["status_message"]);
    $last_checked = new DateTime($row["last_checked"]);
    $now = new DateTime();

    $tooltip = $status === 'online' ? 'Online' : '';
    if ($status === 'offline') {
        $first_offline = isset($row["first_offline"]) ? new DateTime($row["first_offline"]) : $last_checked;
        $interval = $first_offline->diff($now);
        $tooltip = "Offline for " . $interval->format('%a days, %h hours, %i minutes');
    } elseif ($status === 'warning') {
        $tooltip = $status_message;
    }

    $status_class = $status === 'online' ? 'glowing-green' : ($status === 'offline' ? 'glowing-red' : 'glowing-yellow');
    echo "<td style='text-align: center;'><span class='dot $status_class' title='$tooltip'></span></td>";
    echo "</tr>";
}

echo "</table>";

if (!empty($last_checked_global)) {
    echo "<p>Last Checked: " . htmlspecialchars($last_checked_global) . "</p>";
}

$conn->close();
?>

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
