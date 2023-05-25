<?php
// Set the Codeforces API endpoint and the user handle
$apiUrl = "https://codeforces.com/api/user.status";
$userHandle = "pranthoR";

// Set the parameters for the API request
$params = array(
    "handle" => $userHandle,
    "from" => 1,
    "count" => 10000 // You can increase or decrease the count as needed
);

// Build the API URL with the parameters
$url = $apiUrl . "?" . http_build_query($params);

// Make the API request and decode the JSON response
$response = json_decode(file_get_contents($url), true);

// Loop through the submissions and extract the solved problems
$solveCountByDifficulty = array("easy" => 0, "medium" => 0, "hard" => 0);
foreach ($response["result"] as $submission) {
    if ($submission["verdict"] == "OK") { // The submission was accepted
        $problem = $submission["problem"];
        $difficulty = isset($problem["rating"]) ? $problem["rating"] : 0;
        if ($difficulty <= 1200) {
            $solveCountByDifficulty["easy"]++;
        } elseif ($difficulty <= 1600) {
            $solveCountByDifficulty["medium"]++;
        } else {
            $solveCountByDifficulty["hard"]++;
        }
    }
}

// Now $solveCountByDifficulty array contains the solve count for each difficulty level

// Create the data array for the chart
$data = array(
    "labels" => array("Easy", "Medium", "Hard"),
    "datasets" => array(
        array(
            "label" => "Solve Count",
            "backgroundColor" => array("green", "blue", "red"),
            "data" => array_values($solveCountByDifficulty)
        )
    )
);

// Encode the data array as JSON
$dataJson = json_encode($data);

// Render the chart using Chart.js
?>
<canvas id="myChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Get the canvas element
var ctx = document.getElementById("myChart").getContext("2d");

// Define the chart data
var data = {
  labels: ["Easy", "Medium", "Hard"],
  datasets: [
    {
      label: "Solve Count",
      data: <?php echo json_encode(array_values($solveCountByDifficulty)); ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
      ],
      borderWidth: 1
    }
  ]
};

// Create the chart
var myChart = new Chart(ctx, {
  type: "bar",
  data: data,
  options: {
    scales: {
      yAxes: [
        {
          ticks: {
            beginAtZero: true
          }
        }
      ]
    },
    legend: {
      display: true
    },
    title: {
      display: true,
      text: "User Solve Count by Difficulty"
    }
  }
});

// Add a gradient background for each bar
var gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(255, 99, 132, 0.4)');
gradient.addColorStop(0.5, 'rgba(54, 162, 235, 0.4)');
gradient.addColorStop(1, 'rgba(255, 206, 86, 0.4)');
myChart.data.datasets[0].backgroundColor = gradient;

// Update the chart
myChart.update();

</script>

?>
