<?php
session_start();
require_once "db_connect.php";

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
  header("Location: index.html");
  exit;
}

$username = $_SESSION["username"];

// Fetch the user's information
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();
  $userId = $row["id"];
  $currentUsername = $row["username"];
  $currentAge = $row["age"];
  $currentEmail = $row["email"];
  $currentPhone = $row["phone"];
} else {
  // Redirect to signin page if user not found
  header("Location: index.html");
  exit;
}

// Update user information
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $newUsername = $_POST["username"];
  $newPassword = $_POST["password"];
  $newAge = $_POST["age"];
  $newEmail = $_POST["email"];
  $newPhone = $_POST["phone"];

  $newUsername = mysqli_real_escape_string($conn, $newUsername);
  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  $newAge = mysqli_real_escape_string($conn, $newAge);
  $newEmail = mysqli_real_escape_string($conn, $newEmail);
  $newPhone = mysqli_real_escape_string($conn, $newPhone);

  $updateSql = "UPDATE users SET username='$newUsername', password='$hashedPassword', age=$newAge, email='$newEmail', phone='$newPhone' WHERE id=$userId";

  if ($conn->query($updateSql) === TRUE) {
    // Update the session username if it was changed
    if ($newUsername !== $currentUsername) {
      $_SESSION["username"] = $newUsername;
    }
    echo "Profile updated successfully!";
  } else {
    echo "Error: " . $updateSql . "<br>" . $conn->error;
  }
}

if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to the signin page
    header("Location: index.html");
    exit();
  }
  
  // Retrieve the user's profile picture path from the database
  $username = $_SESSION['username'];
  $sql = "SELECT profile_picture FROM users WHERE username = '$username'";

?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div style="position:absolute; left:20%;" class="container">
  <center>
    <h1>Labdien, <?php echo $currentUsername; ?> !<br>Jūsu profils:</h1>
   <p>Profila bilde:</p> <?php if ($row['profile_picture']) { ?>
      <img style="position:relative; width:200px; height: 200px;" src="photos/<?php echo $row['profile_picture']; ?>" alt="Profile Picture">
    <?php } ?>
    <!-- Profile Picture Upload Form -->
    <form action="upload_picture.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="userId" value="<?php echo $userId; ?>">
      <input type="file" name="profilePicture">
      <input type="submit" value="Augšupielādēt attēlu">
    </form>
   </center>
   </div>
    <div style="position:absolute; right: 20%;" class="container">
    <center>
      <h1>Rediģēt profila datus:</h1>
    <form action="profile.php" method="POST">
      <label for="username">Lietotājvārds:</label>
      <input type="text" name="username" value="<?php echo $currentUsername; ?>" required><br>

      <label for="password">Parole:</label>
      <input type="password" name="password" placeholder="Leave blank to keep current password"><br>

      <label for="age">Vecums:</label>
      <input type="text" name="age"  value="<?php echo $currentAge; ?>"><br>

      <label for="email">E-pasts:</label>
      <input type="text" name="email" value="<?php echo $currentEmail; ?>"><br>

      <label for="phone">Tel. nr.:</label>
      <input type="text" name="phone" value="<?php echo $currentPhone; ?>"><br>

      <input type="submit" value="Update Profile">
    </form>
   </center>
  </div>
  <a href="logout.php" class="logout-link">Iziet</a>
</body>
</html>
