<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["newUsername"];
  $password = $_POST["newPassword"];
  $email = $_POST["email"];

  // Create a database connection
  $servername = "localhost";
  $username_db = "root";
  $password_db = "";
  $database = "online_judge";
  $conn = new mysqli($servername, $username_db, $password_db, $database);

  // Check if the connection was successful
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Prepare and execute the SQL query to insert the user's data
  $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $hashedPassword, $email);
  $stmt->execute();

  // Check if the registration was successful
  if ($stmt->affected_rows > 0) {
    $_SESSION["successMessage"] = "Registration successful!";
  }

  // Close the statement and the database connection
  $stmt->close();
  $conn->close();

  // Redirect to index.php
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Problem Recommendation Website - Registration</title>
</head>

<body>
  <h1>Registration</h1>
  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
    <div>
      <label for="newUsername">Username:</label>
      <input type="text" id="newUsername" name="newUsername" required>
    </div>
    <div>
      <label for="newPassword">Password:</label>
      <input type="password" id="newPassword" name="newPassword" required>
    </div>
    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div>
      <input type="submit" value="Register">
    </div>
  </form>
</body>

</html>