<?php

session_start();



// Validate domain function
function isValidDomain($domain) {
    // Check if domain ends with .i2p
    return preg_match("/^.+\.i2p$/", $domain);
}


// Check if form was submitted and domain field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['domain'])) {
    $domain = $_POST['domain'];

    // Validate domain
    if (!isValidDomain($domain)) {
        echo "Invalid domain. Please enter a valid domain.";
        exit;
    }

    // Define an array of proxies
    $proxies = ['reseed.stormycloud.org:4444'];

    $success = false;

    foreach ($proxies as $proxy) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if ($response !== false && curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
            echo "Okay - Accessed via proxy: $proxy";
            $success = true;
            break; // Exit the loop if successful
        }

        curl_close($ch);
    }

    if (!$success) {
        echo "Error - All proxies failed or site is down";
    }
} else {
    echo "Please submit a domain to check.";
}


// Assuming $domain and $success are set from earlier in the script
// Connect to your database
$mysqli = new mysqli("dustin.in", "dustinin_i2p_website_checks", "4e9s53kDWpt3", "dustinin_i2p_website_checks");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Insert the check
$status = $success ? 'Online' : 'Offline';
$stmt = $mysqli->prepare("INSERT INTO website_checks (domain, status) VALUES (?, ?)");
$stmt->bind_param("ss", $domain, $status);
$stmt->execute();

// Retrieve the last 5 checks
$result = $mysqli->query("SELECT domain, status FROM website_checks ORDER BY checked_at DESC LIMIT 5");

$checks = [];
while ($row = $result->fetch_assoc()) {
    $checks[] = $row;
}

// Close connection
$stmt->close();
$mysqli->close();

// Return checks as part of the AJAX response or handle appropriately


// Assuming $domain and $success are already defined
$statusMessage = $success ? 'Online' : 'Offline';
$statusClass = $success ? 'glowing-green' : 'glowing-red';

// Construct the JSON response
$response = [
    'currentCheck' => [
        'domain' => $domain,
        'status' => $statusMessage,
        'class' => $statusClass
    ],
    'lastChecks' => $checks // Assuming $checks contains the last 5 checks from the database
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
