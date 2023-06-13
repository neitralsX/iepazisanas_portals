<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
  <title>Password Reset</title>
</head>
<body>
  <h1>Password Reset</h1>
  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted email address
    $email = $_POST["email"];

    // Check if the email exists in the database
    // ... rest of the code to check if the email exists

    // Generate a password reset token
    $token = bin2hex(random_bytes(32));

    // Save the token in the database for the user
    // ... rest of the code to update the user's token in the database

    // Send the password reset link to the user's email
    $resetLink = "http://example.com/reset.php?email=$email&token=$token";
    $emailContent = "Please click the following link to reset your password: $resetLink";
    $subject = "Password Reset";
    $headers = "From: noreply@example.com";

    if (mail($email, $subject, $emailContent, $headers)) {
      echo "Password reset link has been sent to your email.";
    } else {
      echo "Failed to send the password reset link.";
    }
  }
  ?>
  <form action="reset_password.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="submit" value="Reset Password">
  </form>
</body>
</html>
