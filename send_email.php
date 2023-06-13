<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  // Modify the email subject and recipient as needed
  $subject = "Support Request";
  $to = "girt.pulle@inbox.lv";

  // Modify the email content as needed
  $emailContent = "Name: $name\n";
  $emailContent .= "Email: $email\n";
  $emailContent .= "Message: $message\n";

  // Set the email headers
  $headers = "From: $name <$email>" . "\r\n" .
             "Reply-To: $email" . "\r\n" .
             "X-Mailer: PHP/" . phpversion();

  // Send the email
  if (mail($to, $subject, $emailContent, $headers)) {
    echo "Email sent successfully.";
  } else {
    echo "Failed to send the email.";
  }
} else {
  echo "Invalid request.";
}
?>
