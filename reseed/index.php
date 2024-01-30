<?php
include 'db.php';

$result = $conn->query("SELECT * FROM server_status");
$last_checked_global = "";

echo "<table border='1'>";
echo "<tr><th>Server Name</th><th>Status</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["server_name"] . "</td>";
    $status = $row["status"] == "offline" ? "OFFLINE since " . $row["last_checked"] : "ONLINE";
    echo "<td>" . $status . "</td>";
    echo "</tr>";
    $last_checked_global = $row["last_checked"];
}

echo "</table>";

echo "<p>Last Checked: " . $last_checked_global . "</p>";

$conn->close();
?>
