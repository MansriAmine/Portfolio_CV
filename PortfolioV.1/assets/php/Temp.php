<?php
// Database connection details
$servername = "localhost"; // Replace with your server address if not local
$username = "root";        // Replace with your MySQL username
$password = "";            // Replace with your MySQL password
$dbname = "esp_database"; // Replace with your database name

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get temperature data from the POST request
    $temperature = $_POST['temperature'];

    // Validate the input
    if (is_numeric($temperature)) {
        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO temperature_data (temperature) VALUES (?)");
        $stmt->bind_param("d", $temperature); // "d" indicates a double/float parameter

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "Temperature data inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid temperature value.";
    }
} else {
    echo "Invalid request method. Use POST.";
}

// Close the database connection
$conn->close();
?>