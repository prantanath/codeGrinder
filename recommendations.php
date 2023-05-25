<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: error.php");
    exit;
}
// Check if the Codeforces username is saved in the session
if (!isset($_SESSION["codeforcesUsername"])) {
    $_SESSION["unsuccessMessage"] = "Place your handle first";
    header("Location: main.php");
    exit;
}

$handle = $_SESSION["codeforcesUsername"];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Problem Recommendations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding: 20px;
        }

        .tag-header {
            margin-top: 30px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease-in-out;
        }

        .card a {
            text-decoration: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #59838D;
        }

        .card:hover a {
            color: white;
        }

        .card-title {
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }

        .card-text {
            color: #777;
            font-size: 14px;
        }

        .card:hover .card-text {
            color: white;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: gainsboro;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: skyblue;
        }

        .hder {
            background-color: skyblue;
        }

        .header {
            background-color: #333;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
            margin-bottom: 20px;
        }

        .website-name {
            font-size: 24px;
            font-weight: bold;
        }

        .dropdown-toggle {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
        }

        .dropdown-menu {
            background-color: #333;
        }

        .dropdown-item {
            color: #fff;
        }

        .welcome {
            font-size: 18px;
            margin-right: 10px;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-weight: bold;
        }


        .dropdown {
            position: relative;
            display: inline-block;
            margin-right: 65%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 10px;
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown.open .dropdown-content {
            display: block;
        }

        .dropdown-btn {
            background-color: #c82333;
            color: #f2f2f2;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .dropdown-btn:hover {
            background-color: #999;
        }

        .dropdown-content a {
            display: block;
            color: #333;
            padding: 8px 12px;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: #f2f2f2;
        }



        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Animation */
        @keyframes slideIn {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(0);
            }
        }


        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 80px;
            background-color: #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            z-index: 9999;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .popup:hover {
            transform: translate(-50%, -50%) scale(1.02);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            background-color: #ffffff00;

        }

        .popup::before {
            content: "";
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .popup-content {
            position: relative;
        }

        .popup-close {
            position: absolute;
            bottom: 111px;
            left: 118%;
            width: 20px;
            height: 20px;
            background-color: #ccc;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup-close:hover {
            background-color: #999;
        }

        .popup a {
            display: block;
            color: #007bff;
            text-decoration: none;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .popup a:hover {
            text-decoration: none;
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="hder">
        <div class="header">
            <div class="website-name">CodeGrinder</div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="menuDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Menu
                </button>
                <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                    <li><a class="dropdown-item" href="info.php">Analysis</a></li>
                    <li><a class="dropdown-item" href="tags.php">Topic Recommendation</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showPopup()">Problem Of The Day</a></li>
                </ul>
            </div>
            <div class="welcome">Welcome!</div>
            <button class="btn btn-danger me-2" onclick="logout()">Logout</button>

        </div>
    </div>
    <div class="container">
        <?php

        // Retrieve the selected tags from the form submission
        $selectedTags = $_GET["tags"];


        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "online_judge";

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $apiUrl = "https://codeforces.com/api/user.info?handles=" . $handle;
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        if ($data["status"] === "OK") {
            $rating = $data["result"][0]["rating"];
        } else {
            $rating = "N/A";
        }
        // Display the recommendations for each individual tag
        $minDifficulty = $rating;
        $maxDifficulty = $rating + 300;
        foreach ($selectedTags as $tag) {

            $sql = "SELECT contestID, name, difficulty FROM problem_list WHERE tags LIKE '%$tag%' AND difficulty >= $minDifficulty AND difficulty <= $maxDifficulty ORDER BY RAND() LIMIT 5";
            // Execute the query
            $result = $conn->query($sql);

            // Display the recommendations for the current tag
            echo "<div class='tag-header'>";
            echo "<h2>Recommendations for Tag: $tag</h2>";
            echo "</div>";
            echo "<div class='row'>";
            while ($row = $result->fetch_assoc()) {
                $contestNumber = substr($row["contestID"], 0, strpos($row["contestID"], "_"));
                $problemID = substr($row["contestID"], strpos($row["contestID"], "_") + 1);
                $problemURL = "https://codeforces.com/contest/{$contestNumber}/problem/{$problemID}";
                echo "<div class='col-sm-4'>";
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'><a href='{$problemURL}' target='_blank'>Contest ID: " . $row["contestID"] . "</a></h5>";
                echo "<p class='card-text'>Name: " . $row["name"] . "</p>";
                echo "<p class='card-text'>Difficulty: " . $row["difficulty"] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPopup() {
            // Retrieve the recommended problem link using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var problemLink = xhr.responseText;

                    // Create the popup element
                    var popup = document.createElement("div");
                    popup.classList.add("popup");

                    // Create the popup content
                    var popupContent = document.createElement("div");
                    popupContent.classList.add("popup-content");

                    // Create the exit button
                    var exitButton = document.createElement("button");
                    exitButton.classList.add("popup-close");
                    exitButton.innerHTML = "&times;";
                    exitButton.addEventListener("click", closePopup);

                    // Create the problem link element
                    var link = document.createElement("a");
                    link.href = problemLink;
                    link.textContent = "Problem of the day";

                    // Add the problem link to the popup content
                    popupContent.appendChild(exitButton);
                    popupContent.appendChild(link);

                    // Add the popup content to the popup element
                    popup.appendChild(popupContent);

                    // Add the popup to the document body
                    document.body.appendChild(popup);
                }
            };
            xhr.open("GET", "ml.php", true);
            xhr.send();
        }

        function closePopup() {
            var popup = document.querySelector(".popup");
            if (popup) {
                popup.remove();
            }
        }
    </script>
</body>

</html>