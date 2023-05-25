<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online_judge";

    // Create a new MySQL connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    $sql = "CREATE TABLE problem_list (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        contestID VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        tags VARCHAR(255) NOT NULL,
        difficulty INT(11)
    )";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Close the MySQL connection
    $conn->close();

?>
