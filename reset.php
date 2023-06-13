<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $email = $_GET["email"];
  $token = $_GET["token"];

  // Check if the email and token are valid
  // ... rest of the code to validate the email and token

  // Display the password reset form
  echo '
  <!DOCTYPE html>
  <html>
  <head>
    <title>Reset Password</title>
  </head>
  <body>
    <h1>Reset Password</h1>
    <form action="update_password.php" method="POST">
      <input type="hidden" name="email" value="' . $email . '">
      <input type="hidden" name="token" value="' . $token . '">
      <input type="password" name="password" placeholder="New Password" required><br>
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br>
      <input type="submit" value="Reset">
    </form>
  </body>
  </html>
  ';
}
?>
