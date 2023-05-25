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
    $url = "https://codeforces.com/api/problemset.problems";

    // Make the API call and retrieve the response
    $response = file_get_contents($url);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Extract the problem list from the response
    $problemList = $data['result']['problems'];

    // Insert the problem list into the MySQL database
    foreach ($problemList as $problem) {
        // Escape the single quote character in the problem name
        $contest_id = $problem['contestId'];
        $index = $problem['index'];
        $problem_id = $contest_id . "_" . $index;
        
        $name = str_replace("'", "''", $problem['name']);

        // Join the tags array into a comma-separated string
        $tags = implode(",", $problem['tags']);

        $difficulty = isset($problem['rating']) ? $problem['rating'] : '';

        $sql = "INSERT INTO problem_list (contestID, name, tags, difficulty) VALUES ('$problem_id','$name', '$tags', '$difficulty')";

        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $conn->error;
        }

    }

    // Close the MySQL connection
    $conn->close();
?>
