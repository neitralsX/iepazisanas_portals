<!-- greetings.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Greetings</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* Add your CSS styles for the greetings page here */
  </style>
</head>
<body>
<h1 style="position:absolute; top:10%;">Reģistrētie lietotāji:</h1><br>
  <?php
  // Retrieve the user's data from the database
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "iepazisanas_portals";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the users' data from the database
  $sql = "SELECT * FROM users";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display the users' data
    while ($row = $result->fetch_assoc()) {
      ?>
      <div class="user" style="padding:10px;">
        
        <h3>Lietotājvārds: <?php echo $row['username']; ?></h3>
        <p>Vecums: <?php echo $row['age']; ?></p>
        <?php if ($row['profile_picture']) { ?>
          <img  style="position:relative; width:200px; height: 200px;" src="photos/<?php echo $row['profile_picture']; ?>" alt="Profile Picture">
        <?php } ?>
      </div>
      <?php
    }
  } else {
    echo "No users found";
  }

  $conn->close();
  ?>
  <div style="position:absolute; bottom:30%;">
  <a href="index.html">Sākums</a><br>
  <a href="chat.php">Čats</a>
</div>
</body>
</html>
