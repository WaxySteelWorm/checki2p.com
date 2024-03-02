<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Reseed Check</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon.ico">
        

    <header>
    <span id="homelink"></span>
    <nav>
    <ul>
            <li><a href="../index.php">CheckI2P.com</a></li>
            <li><a href="../reseed/index.php">Reseed Server Status</a></li>
            <li><a href="../ping/index.php">I2P Website Check</a></li>
            <li><a href="../donate/index.php">Donate Today!</a></li>
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

    </div>            </div>

            <div class="message">
            <?php
include 'db.php'; // Ensure this path is correct for your db.php file

// Modified SQL query
$result = $conn->query("SELECT *, SUBSTRING_INDEX(SUBSTRING_INDEX(server_name, '.', -2), '.', 1) AS secondary_domain, SUBSTRING_INDEX(server_name, '.', -1) AS tld FROM server_status ORDER BY tld, secondary_domain, last_checked DESC");

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
