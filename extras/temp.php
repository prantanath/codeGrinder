<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Check if the Codeforces username is saved in the session
if (!isset($_SESSION["codeforcesUsername"])) {
    header("Location: home.php");
    exit;
}

$codeforcesUsername = $_SESSION["codeforcesUsername"];

// Fetch user details from Codeforces API
$apiUrl = "https://codeforces.com/api/user.info?handles=" . $codeforcesUsername;
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data["status"] === "OK") {
    $rating = $data["result"][0]["rating"];
} else {
    $rating = "N/A";
}

$username = $_SESSION["username"];


$url = "https://codeforces.com/api/user.status?handle=" . $codeforcesUsername . "&from=1&count=10000";

// Fetch the JSON data from Codeforces API
$response = file_get_contents($url);
$data = json_decode($response, true);

// Extract the list of submissions from the response
$submissions = $data['result'];

// Extract the list of solved problem IDs from the submissions
$solved_problems = array();
foreach ($submissions as $submission) {
    $problem_id = $submission['problem']['contestId'] . "_" . $submission['problem']['index'];
    $verdict = $submission['verdict'];
    if ($verdict == "OK") {
        $solved_problems[] = $problem_id;
    }
}

// Get the list of all problems from your database
$dsn = 'mysql:host=localhost;dbname=online_judge';
$username = 'root';
$password = '';
$db = new PDO($dsn, $username, $password);
$sql = "SELECT * FROM problem_list";
$stmt = $db->prepare($sql);
$stmt->execute();
$problems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filter out the unsolved problems of the user by matching with the problems in the database
$unsolved_problems = array();
foreach ($problems as $problem) {
    $problem_id = $problem['contestID'] . "_" . $problem['name'];
    $difficulty = $problem['difficulty'];
    $tags = $problem['tags'];
    if (!in_array($problem_id, $solved_problems)) {
        $unsolved_problems[] = array(
            "contestID" => $problem['contestID'],
            "name" => $problem['name'],
            "tags" => $tags,
            "difficulty" => $difficulty
        );
    }
}
function getRecommendedProblemsByRating($rating, $problems)
{
    // Implement your logic to recommend problems based on user rating
    // You can filter problems from the $problems array based on the user's rating and return the recommended problems
    // For example, you can filter problems with difficulty level within a certain range based on the user's rating
    $minDifficulty = $rating ;
    $maxDifficulty = $rating + 300;

    $recommendedProblems = array();
    $i=0;
    foreach ($problems as $problem) {
        $difficulty = $problem['difficulty'];
        if ($difficulty >= $minDifficulty && $difficulty <= $maxDifficulty) {
            $recommendedProblems[] = $problem;
        }
    }

    return $recommendedProblems;
}
$recommendedProblems = getRecommendedProblemsByRating($rating,$unsolved_problems);
// print_r($recommendedProblems);
// Assuming you have a function to retrieve recommended problems based on user rating
?>

<!DOCTYPE html>
<html>
<head>
    <title>Problem Recommendation Website - Home</title>
    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
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
            margin-right: 65%; /* Updated margin value */
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
    </style>
</head>
<body>
<div class="hder">
    <div class="header">
        <div class="website-name">CodeGrinder</div>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                <li><a class="dropdown-item" href="info.php">Info</a></li>
                <li><a class="dropdown-item" href="tags.php">Menu Item 2</a></li>
                <li><a class="dropdown-item" href="#">Menu Item 3</a></li>
            </ul>
        </div>
        <div class="welcome">Welcome, <?php echo $codeforcesUsername; ?>!</div>
        <button class="btn btn-danger me-2" onclick="logout()">Logout</button>

    </div>
</div>
<div class="container">
    
    <h1>Recommended Problems</h1>

    <?php
    $randomProblemsIndexes = array_rand($recommendedProblems, 5);

    foreach ($randomProblemsIndexes as $index) {
        $problem = $recommendedProblems[$index];
        $contestID = $problem['contestID'];
        $problemName = $problem['name'];
    
        // Extract contest number and problem ID
        $contestNumber = substr($contestID, 0, strpos($contestID, "_"));
        $problemID = substr($contestID, strpos($contestID, "_") + 1);
        $problemURL = "https://codeforces.com/contest/{$contestNumber}/problem/{$problemID}";
    
        echo "<div>";
        echo "<p><a href='{$problemURL}' target='_blank'>{$contestID} - {$problemName}</a></p>";
        echo "</div>";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</div>
</body>
</html>
