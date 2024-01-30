<?php
include 'db.php';

$result = $conn->query("SELECT * FROM server_status");

echo "<table border='1'>";
echo "<tr><th>Server Name</th><th>Status</th><th>Last Checked</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["server_name"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    echo "<td>" . $row["last_checked"] . "</td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();
?>
