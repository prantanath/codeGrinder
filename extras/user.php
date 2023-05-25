<?php
// Retrieve user's solved problem list from Codeforces
$handle = 'dummy007'; // replace with actual handle
// Set the user handle
// Set the URL for the request
$url = "https://codeforces.com/api/user.status?handle=pranthoR&from=1&count=100";

// Open a stream to the URL using fopen
$response = file_get_contents($url);

$data = json_decode($response, true);
$user_solved_problems = array();
foreach ($data['result'] as $submission) {
    if ($submission['verdict'] == 'OK') {
        $problem_id = $submission['problem']['contestId']."_".$submission['problem']['index'];
        $problem_name = $submission['problem']['name'];
        $problem_tags = implode(',', $submission['problem']['tags']);
        if($submission['problem']['rating']) {
            $problem_difficulty = $submission['problem']['rating'];
        }
        $problem = array('id' => $problem_id,'name' => $problem_name, 'tags' => $problem_tags, 'difficulty' => $problem_difficulty);
        array_push($user_solved_problems, $problem);
    }
}

// Display user's solved problems
echo "<h2>User's solved problems:</h2>";
echo "<ul>";
foreach ($user_solved_problems as $problem) {
    echo "<li>{$problem['id']} - {$problem['name']} ({$problem['difficulty']}) - {$problem['tags']}</li>";
}
echo "</ul>";


?>