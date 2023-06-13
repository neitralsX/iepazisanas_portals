<?php
session_start();
require_once "db_connect.php";

// Redirect to profile page if user is already logged in
if (isset($_SESSION["username"])) {
  header("Location: profile.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $username = mysqli_real_escape_string($conn, $username);

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row["password"];

    if (password_verify($password, $hashedPassword)) {
      // Authentication successful, set session variables and redirect to profile page
      $_SESSION["username"] = $username;
      header("Location: profile.php");
      exit;
    } else {
      $error = "Invalid username or password.";
    }
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Signin</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Signin</h1>
    <?php if (isset($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="signin.php" method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <input type="submit" value="Signin">
    </form>
    <p>Forgot your password? <a href="reset_password.php">Reset Password</a></p>

    <a href="index.html" class="back-link">Back to Homepage</a>
  </div>
</body>
</html>
