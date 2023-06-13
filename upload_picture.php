<?php
// Retrieve the user ID from the form submission
$userId = $_POST['userId'];

// Check if a file was uploaded
if ($_FILES['profilePicture']['name']) {
  // File upload configuration
  $targetDir = "photos/";
  $fileName = basename($_FILES['profilePicture']['name']);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if ($_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
    echo "Upload error: " . $_FILES['profilePicture']['error'];
    exit;
}

  // Allow only specific file types (e.g., JPEG, PNG)
  $allowedTypes = array('jpg', 'jpeg', 'png');
  if (in_array($fileType, $allowedTypes)) {
    // Upload the file to the server
    if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFilePath)) {
      // File uploaded successfully, update the user's profile picture in the database
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "iepazisanas_portals";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Update the user's profile picture filename in the database
      $sql = "UPDATE users SET profile_picture = '$fileName' WHERE id = $userId";
      if ($conn->query($sql) === TRUE) {
        header("Location: profile.php");
        // // Profile picture updated successfully
        // echo "Profile picture uploaded successfully";
      } else {
        echo "Error updating profile picture: " . $conn->error;
      }

      $conn->close();
    } else {
      echo "Error uploading file";
    }
  } else {
    echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
  }
} else {
  echo "No file selected";
}
?>
