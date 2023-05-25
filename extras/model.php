<?php
// include PHP-ML library
require_once 'autoload.php';

use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\ArrayDataset;
use Phpml\Metric\Accuracy;

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
    while($row = $result->fetch_assoc()) {
        array_push($problems, [(float) $row["difficulty"]]);
        array_push($ratings, $row["contestID"]);
    }
} else {
    echo "No problems found in database";
    exit();
}

// create the dataset
$dataset = new ArrayDataset($problems, $ratings);

// create and train the model using k-nearest neighbors algorithm
$k = 5; // set the number of nearest neighbors to consider
$model = new KNearestNeighbors($k);
$model->train($dataset->getSamples(), $dataset->getTargets());

// save the model to a file
$modelFile = __DIR__ . '/knnrecom.pkl';
file_put_contents($modelFile, serialize($model));


// close the database connection
$conn->close();
?>
