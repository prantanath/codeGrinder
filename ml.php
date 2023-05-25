<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: error.php");
    exit;
}
if (!isset($_SESSION["codeforcesUsername"])) {
    $_SESSION["unsuccessMessage"] = "Place your handle first";
    header("Location: main.php");
    exit;
}

$handle = $_SESSION["codeforcesUsername"];

if (!isset($_SESSION["solvedProblems"])) {
    $_SESSION["unsuccessMessage"] = "Place your handle first";
    header("Location: main.php");
    exit;
}
$solved_problems = $_SESSION['solvedProblems'];
$apiUrl = "https://codeforces.com/api/user.info?handles=" . $handle;
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data["status"] === "OK") {
    $rating = $data["result"][0]["rating"];
} else {
    $rating = "N/A";
}
// include PHP-ML library
require_once 'autoload.php';

use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\ArrayDataset;

// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_judge";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the problems and ratings from the database
$problems = array();
$ratings = array();
$sql = "SELECT contestID, difficulty FROM problem_list";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if(!isset($solved_problems[$row["contestID"]]) || $solved_problems[$row["contestID"]] != "OK"){        
        array_push($problems, $row["contestID"]);
        array_push($ratings, [(float) $row["difficulty"]]);
        }
    }
} else {
    // echo "No problems found in database";
    exit();
}

// close the database connection
$conn->close();

// load the saved model from file
$modelFile = __DIR__ . '/knnrecom.pkl';
$model = unserialize(file_get_contents($modelFile));

// user ratings
$userRatings = [$rating]; // replace with the user's ratings

// create the dataset with user ratings
$userDataset = new ArrayDataset($ratings, $problems);

// train the model using k-nearest neighbors algorithm
$k = 5; // set the number of nearest neighbors to consider
$model->train($userDataset->getSamples(), $userDataset->getTargets());

// predict the contest ID using the trained model
$predictedContestId = $model->predict([$userRatings]);

// output the recommended contest ID
// echo "Recommended Contest ID: " . $predictedContestId[0];
$recommendedContestId = $predictedContestId[0];
$contestNumber = substr($recommendedContestId, 0, strpos($recommendedContestId, "_"));
$problemID = substr($recommendedContestId, strpos($recommendedContestId, "_") + 1);
$recommendedProblemLink = "https://codeforces.com/contest/{$contestNumber}/problem/{$problemID}";

echo $recommendedProblemLink;
?>