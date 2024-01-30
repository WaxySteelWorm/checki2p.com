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
                <!-- Donate banner content -->
            </div>

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
            <!-- Footer content -->
        </footer>
    </div>
</body>
</html>
