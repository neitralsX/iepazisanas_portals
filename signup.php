<?php
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $age = $_POST["age"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];

  $username = mysqli_real_escape_string($conn, $username);
  $age = mysqli_real_escape_string($conn, $age);
  $email = mysqli_real_escape_string($conn, $email);
  $phone = mysqli_real_escape_string($conn, $phone);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (username, password, age, email, phone) VALUES ('$username', '$hashedPassword', '$age', '$email', '$phone')";
  if ($conn->query($sql) === TRUE) {
    header("Location: profile.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$profilePictureDir = 'profile_pictures/'; // Specify the directory where the profile pictures will be stored

// Process the uploaded profile picture
$profilePictureName = $_FILES['profile_picture']['name'];
$profilePictureTemp = $_FILES['profile_picture']['tmp_name'];
$profilePicturePath = $profilePictureDir . $profilePictureName;

if (move_uploaded_file($profilePictureTemp, $profilePicturePath)) {
  // File uploaded successfully, include the profile picture path in the SQL INSERT statement
  $insertSql = "INSERT INTO users (username, password, profile_picture) VALUES ('$username', '$hashedPassword', '$profilePicturePath')";
  // ... rest of the code
} else {
  // Failed to upload the file
  // ... handle the error as needed
}

?>