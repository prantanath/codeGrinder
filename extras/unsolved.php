<?php
// Set the handle of the user
$user_handle = "pranthoR";

// Set the API URL for user.status method
$url = "https://codeforces.com/api/user.status?handle=" . $user_handle . "&from=1&count=10000";

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
    $minDifficulty = $rating - 100;
    $maxDifficulty = $rating + 100;

    $recommendedProblems = array();
    foreach ($problems as $problem) {
        $difficulty = $problem['difficulty'];
        if ($difficulty >= $minDifficulty && $difficulty <= $maxDifficulty) {
            $recommendedProblems[] = $problem;
        }
    }

    return $recommendedProblems;
}
$prb = getRecommendedProblemsByRating(1252,$unsolved_problems);
// Output the list of unsolved problems of the user
// print_r($prb);
$tagCounts = array();
foreach ($solved_problems as $problem) {
    $tags = $problem['tags'];
    foreach ($tags as $tag) {
        if (!isset($tagCounts[$tag])) {
            $tagCounts[$tag] = 0;
        }
        $tagCounts[$tag]++;
    }
}

// Prepare the data for the pie chart
$labels = array_keys($tagCounts);
$data = array_values($tagCounts);
$backgroundColor = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)'];
$borderColor = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="pieChart"></canvas>

    <script>
        // Create the pie chart
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: <?php echo json_encode($backgroundColor); ?>,
                    borderColor: <?php echo json_encode($borderColor); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
?>