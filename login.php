<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_judge";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to verify the password hash
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows == 1) {
        // Bind the result to a variable
        $stmt->bind_result($storedHash);
        $stmt->fetch();

        // Verify the password
        if (verifyPassword($password, $storedHash)) {
            // Password is correct
            $_SESSION["username"] = $username;

            // Redirect to another page or perform additional actions
            header("Location: main.php");
            exit;
        } else {
            // Password is incorrect
            $_SESSION["unsuccessMessage"]="Invalid username or password.";
            $stmt->close();
            header("Location: index.php");
            exit;
        }
    } else {
        // User does not exist
        $_SESSION["unsuccessMessage"]="User does not exist.";
        $stmt->close();
        header("Location: index.php");
        exit;
    }

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
