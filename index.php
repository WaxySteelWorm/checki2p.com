<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2P Proxy Check</title>
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
    <div class="header">
        <img src="../assets/images/logo.svg" alt="Logo" class="logo">
    </div>
    <div class="donate-banner">

    </div>
    <div class="message">
    <?php
include 'checkproxy.php';
list($message, $proxyDetails) = checkIfUsingProxy(); // Assuming checkIfUsingProxy now returns an array

// Determine which image to display based on the message
$usingProxy = $proxyDetails !== null; // Check if proxy details are present
$imageSrc = $usingProxy ? '../assets/images/green_light.svg' : '../assets/images/red_light.svg';
$imageAlt = $usingProxy ? 'Green Light Indicator - Using a known outproxy' : 'Red Light Indicator - Not using a known outproxy';
?>

<div class="status-container">
        <img src='<?php echo $imageSrc; ?>' alt='<?php echo $imageAlt; ?>' class='status-light'>
        <div class='status-message'><?php echo $message; ?></div>
    </div>
</div>
    <footer>
    Created by <a href=https://stormycloud.org/>stormycloud.org</a> | <a href="https://github.com/WaxySteelWorm/checki2p.com" target="_blank">Github</a> | <a href="https://twitter.com/StormyCloudInc" target="_blank">Twitter</a> | <a href="https://www.instagram.com/stormycloudinc/" target="_blank">Instagram</a>    </footer>
    </body>
    </html>
