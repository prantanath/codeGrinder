<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
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

        .selected {
            background-color: #007bff;
            color: #fff;
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
            <div class="welcome">Welcome,
                <?php echo $user; ?>!
            </div>
            <button class="btn btn-danger me-2" onclick="logout()">Logout</button>

        </div>
    </div>
    <div class="container">
        <form method="get" action="recommendations.php">
            <div class="row">
                <?php
                // Retrieve the list of famous tags from the database or define them manually
                $famousTags = array(
                    "implementation",
                    "string",
                    "sorting",
                    "graph",
                    "greedy",
                    "math",
                    "brute force",
                    "sortings",
                    "data structures",
                    "number theory",
                    "binary search",
                    "dp",
                    "two pointers",
                    "bitmasks"
                );

                // Loop through the famous tags and generate cards
                foreach ($famousTags as $tag) {
                    echo '
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body" onclick="toggleSelection(event)">
                            <input type="checkbox" name="tags[]" value="' . $tag . '">
                            <label>' . $tag . '</label>
                        </div>
                    </div>
                </div>
                ';
                }
                ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Get Recommendations</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('click', function (event) {
            const clickedElement = event.target;

            // Check if the clicked element is within a card
            if (clickedElement.closest('.card')) {
                const card = clickedElement.closest('.card');
                const input = card.querySelector('input[type="checkbox"]');

                if (card.classList.contains('selected')) {
                    // If the card is already selected, deselect it
                    card.classList.remove('selected');
                    input.checked = false;
                }
                else {
                    // Deselect all other cards
                    // const allCards = document.querySelectorAll('.card');
                    // allCards.forEach(function(card) {
                    //     card.classList.remove('selected');
                    //     const cardInput = card.querySelector('input[type="checkbox"]');
                    //     cardInput.checked = false;
                    // });

                    // Select the clicked card
                    card.classList.add('selected');
                    input.checked = true;
                }
            }
        });

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
    </script>




</body>

</html>