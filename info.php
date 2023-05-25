<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: error.php");
    exit;
}
$user = $_SESSION["username"];
// Check if the Codeforces username is saved in the session
if (!isset($_SESSION["codeforcesUsername"])) {
    $_SESSION["unsuccessMessage"] = "Place your handle first";
    header("Location: main.php");
    exit;
}

$handle = $_SESSION["codeforcesUsername"];
?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        h2,
        h3 {
            margin: 5px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin: 5px 0;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin: 20px;
            padding: 20px;
            text-align: center;
        }

        .card-header {
            background-color: inherit;
            border-radius: 10px 10px 0px 0px;
            color: white;
            font-size: 24px;
            padding: 10px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.9);
        }


        .ccard-header {
            background-color: gray;
            border-radius: 10px 10px 0px 0px;
            color: white;
            font-size: 24px;
            padding: 10px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.9);
        }


        .card-body {
            margin-top: 20px;
            text-align: left;
        }

        .tag {
            background-color: #008CBA;
            border-radius: 5px;
            color: white;
            display: inline-block;
            font-size: 14px;
            margin-right: 5px;
            padding: 5px 10px;
        }

        .strongest,
        .weakest {
            font-weight: bold;
            text-transform: uppercase;
        }

        .strongest {
            color: #4CAF50;
        }

        .weakest {
            color: #f44336;
        }

        .tag-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .problem-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .problem-card {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .problem-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .clear {
            clear: both;
        }

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
            background-color: wheat;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
            /* Updated margin value */
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

        .cf {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .area-element {
            /* background-color: ; */
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .bullet {
            margin-right: 5px;
            font-size: 24px;
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
<?php
// User handle to fetch information for
// $handle = "pranthoR";

// Fetch user information from Codeforces API
$json = file_get_contents("https://codeforces.com/api/user.info?handles={$handle}");
$data = json_decode($json, true)["result"][0];

// Extract user information
$handle = $data["handle"];
$rating = $data["rating"] ?? "Unrated";
$maxRating = $data["maxRating"] ?? "Unrated";
$rank = $data["rank"] ?? "Unrated";
$country = $data["country"] ?? "Unknown";
// Get the user's handle color based on their rating
if ($rating < 1200) {
    $color = "#808080"; // Gray
} elseif ($rating < 1400) {
    $color = "#008000"; // Green
} elseif ($rating < 1600) {
    $color = "#03a89e"; // Teal
} elseif ($rating < 1900) {
    $color = "#0000FF"; // Blue
} elseif ($rating < 2100) {
    $color = "#800080"; // Purple
} elseif ($rating < 2300) {
    $color = "#FFA500"; // Orange
} elseif ($rating < 2400) {
    $color = "#FFA500"; // Orange
} elseif ($rating < 2600) {
    $color = "#FF0000"; // Red
} elseif ($rating < 3000) {
    $color = "#FF0000"; // Red
} else {
    $color = "#FFD700"; // Gold
}
// echo $color;
// Fetch user's solved problems from Codeforces API
$json = file_get_contents("https://codeforces.com/api/user.status?handle={$handle}");
$data = json_decode($json, true)["result"];

// Count number of solved problems by tag and difficulty
$tags = [];
$difficulty = [];
foreach ($data as $submission) {
    if ($submission["verdict"] == "OK") {
        $problem = $submission["problem"];
        foreach ($problem["tags"] as $tag) {
            if (!isset($tags[$tag])) {
                $tags[$tag] = 0;
            }
            $tags[$tag]++;
        }
        $diff = $problem["difficulty"] ?? "Unrated";
        if (!isset($difficulty[$diff])) {
            $difficulty[$diff] = 0;
        }
        $difficulty[$diff]++;
    }
}

// Sort tags by number of solved problems
arsort($tags);

// Get strongest and weakest areas
$strongest = "";
$weakest = "";
$cnt = count($tags);
$tmp = 0;
// if (!empty($difficulty)) {
//     $strongest = array_search(max($difficulty), $difficulty);
//     $weakest = array_search(min($difficulty), $difficulty);
// }

// Display user information and statistics
foreach ($tags as $tag => $count) {
    if ($tmp == 0) {
        $strongest = $tag;
    }
    if ($tmp == $cnt - 1) {
        $weakest = $tag;
    }
    // echo "<li style='color: hsl(" . rand(0, 360) . ", 100%, 50%);'>{$tag} ({$count})</li>";
    $tmp++;
}
// echo "</ul>";
// echo "<div style='background-color: $color; color: white; padding: 10px; text-align: center;'>";
// echo "<h3>Strongest Area: {$strongest}</h3>";
// echo "<h3>Weakest Area: {$weakest}</h3>";
// echo "</div>";
// echo "</div>";

?>

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
            <div class="welcome">Welcome,
                <?php echo $user; ?>!
            </div>
            <button class="btn btn-danger me-2" onclick="logout()">Logout</button>

        </div>
    </div>



    <div class="container">
        <div class="card-header">
            <?= $handle ?>
        </div>
        <div class="card-body">
            <h3>Rating:
                <?= $rating ?> /
                <?= $maxRating ?>
            </h3>
            <h3>Rank:
                <?= $rank ?> | Country:
                <?= $country ?>
            </h3>
            <h3>Most Solved Tags:</h3>
            <div class="tag-list">
                <?php
                $rowCounter = 0;
                echo "<div class='row'>";
                foreach ($tags as $tag => $count):
                    if ($rowCounter % 3 == 0 && $rowCounter != 0) {
                        echo "</div><div class='row'>";
                    }
                    ?>
                    <div class='row-3'>
                        <div class='card'>
                            <div class='card-body'>
                                <p>
                                    <?= $tag ?> (
                                    <?= $count ?>)
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                    $rowCounter++;
                endforeach;
                echo "</div>";
                ?>
            </div>
            <div class="ccard-header">
                Strongest and Weakest Areas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="row-md-6">
                        <div class="strongest-areas">
                            <span class="strongest">Strongest Areas:</span>
                            <?php
                            $strongestTags = array_slice($tags, 0, 5);
                            $ans = "";
                            foreach ($strongestTags as $tag => $count) {
                                $ans .= "<span class='area-element'><span class='bullet'>&bull;&nbsp;</span>" . strtoupper($tag) . "</span>&nbsp;";

                            }
                            echo "<span class='cf'>$ans</span>";
                            ?>
                        </div>
                    </div>

                    <div class="row-md-6">
                        <div class="weakest-areas">
                            <br>
                            <span class="weakest">Weakest Areas:</span>
                            <?php
                            $weakestTags = array_slice($tags, -5, 5);
                            $ans = "";
                            foreach ($weakestTags as $tag => $count) {
                                $ans .= "<span class='area-element'><span class='bullet'>&bull;&nbsp;</span>" . strtoupper($tag) . "</span>&nbsp;";


                            }
                            echo "<span class='cf'>$ans</span>";
                            ?>
                        </div>
                    </div>
                </div>
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

                function logout() {
                    window.location.href = 'logout.php';
                }

                var color = "<?php echo $color; ?>";

                // Get the card header element
                var cardHeader = document.querySelector(".card-header");

                // Set the background color dynamically
                cardHeader.style.backgroundColor = color;
            </script>
</body>