<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: error.php");
    exit;
}

$username = $_SESSION["username"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the Codeforces username from the form submission
    $codeforcesUsername = $_POST["codeforces-username"];

    // Save the Codeforces username in a session variable
    $_SESSION["codeforcesUsername"] = $codeforcesUsername;

    // Redirect to the next page or perform any other operations
    header("Location: recommend.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Problem Recommendation Website - Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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

        .welcome {
            font-weight: bold;
            animation: slideIn 2s ease-in-out;
            margin-top: 10px;
            margin-right: 2%;
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


        .unsuccess-message {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: #d9534f;
            color: white;
            text-align: center;
            animation: slide-in 0.5s ease-out;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION["unsuccessMessage"])): ?>
        <div class="unsuccess-message">
            <?php echo $_SESSION["unsuccessMessage"]; ?>
        </div>
        <?php unset($_SESSION["unsuccessMessage"]); ?>
    <?php endif; ?>

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
                <?php echo $username; ?>!
            </div>
            <button class="btn btn-danger me-2" onclick="logout()">Logout</button>

        </div>
    </div>
    <div class="container">
        <h1>Practice Problems Recommender</h1>
        <p>Review your profile on multiple platforms for competitive programming and receive suggestions for practice
            problems.</p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="codeforces-username" class="form-label">Enter Codeforces Username:</label>
                <input type="text" class="form-control" name="codeforces-username" placeholder="Codeforces Username"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Get Recommendations</button>
        </form>
        <div id="input-format">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li> Each handle should be exactly spelled (case-sensitive) </li>
                        <li> Sites supported <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Site</th>
                                        <th>Prefix</th>
                                        <th>Example</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span> <img class="input-site-icon" src="/images/icons/codeforces.png">
                                            </span>
                                            Codeforces
                                        </td>
                                        <td>
                                            exact cf handle
                                        </td>
                                        <td>
                                            <code>pranthoR</code>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span> <img class="input-site-icon" src="/images/icons/codechef.png">
                                            </span>
                                            Codechef (not supported yet)
                                        </td>
                                        <td>
                                            <i class="fas fa-times"></i>

                                        </td>
                                        <td>
                                            <i class="fas fa-times"></i>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </li>
                        <li>
                            Place your exact Codeforces handle in the box<br>
                            e.g. <code>pranthoR</code>

                        </li>
                        <li>
                            More platforms coming soon


                        </li>
                    </ul>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>


                document.addEventListener("DOMContentLoaded", function () {
                    var successMessage = document.querySelector(".success-message");
                    var unsuccessMessage = document.querySelector(".unsuccess-message");
                    if (successMessage) {
                        successMessage.style.display = "block";
                        setTimeout(function () {
                            successMessage.style.display = "none";
                        }, 3000); 
                    }
                    if (unsuccessMessage) {
                        unsuccessMessage.style.display = "block";
                        setTimeout(function () {
                            unsuccessMessage.style.display = "none";
                        }, 3000); 
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
        </div>
</body>

</html>