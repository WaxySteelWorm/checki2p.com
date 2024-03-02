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

$result = $conn->query("SELECT * FROM server_status");

$servers = [];
while($row = $result->fetch_assoc()) {
    $servers[] = $row;
}

// Function to extract domain parts for sorting
function getDomainParts($serverName) {
    $parts = explode('.', $serverName);
    $tld = array_pop($parts);
    $secondaryDomain = array_pop($parts);
    return ['tld' => $tld, 'secondaryDomain' => $secondaryDomain, 'fullDomain' => $serverName];
}

// Sort servers by TLD and then by secondary domain
usort($servers, function ($a, $b) {
    $aParts = getDomainParts($a['server_name']);
    $bParts = getDomainParts($b['server_name']);

    if ($aParts['tld'] === $bParts['tld']) {
        return $aParts['secondaryDomain'] <=> $bParts['secondaryDomain'];
    }
    return $aParts['tld'] <=> $bParts['tld'];
});

echo "<table class='status-table'>";
echo "<tr><th>Server Name</th><th>Status</th></tr>";

$last_checked_global = "";
foreach ($servers as $row) {
    if (empty($last_checked_global)) {
        $last_checked_global = $row["last_checked"];
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["server_name"]) . "</td>";

    // Existing status display logic here...
    // (Keep the rest of your original script here to handle status display)

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
