<!DOCTYPE html>
<html>
<head>
  <title>Simple HTML Chat</title>
  <link rel="stylesheet" href="style.css">
  <style>
    #chatbox {
      width: 400px;
      height: 300px;
      border: 1px solid #ccc;
      overflow-y: scroll;
      margin-bottom: 10px;
    }

    #message {
      width: 300px;
    }

    #sendBtn {
      width: 80px;
    }

    #clearBtn {
      width: 80px;
    }
  </style>
  
</head>
<body>
  <center>
  <?php     include 'navbar.php'?>
  <div id="chatbox"></div>
  <input type="text" id="message" placeholder="Ievadiet tekstu" />
  <button id="sendBtn">Sūtīt</button>
  <button class="btn btn-primary" id="clearBtn">Attīrīt čatu</button>
  <script>
    // Retrieve chat messages from local storage and display them
    var chatbox = document.getElementById('chatbox');
    var messages = JSON.parse(localStorage.getItem('chatMessages')) || [];

    function displayMessages() {
      chatbox.innerHTML = '';

      for (var i = 0; i < messages.length; i++) {
        var messageElement = document.createElement('p');
        messageElement.textContent = messages[i];
        chatbox.appendChild(messageElement);
      }
    }

    displayMessages();

    // Handle send button click event
    var sendBtn = document.getElementById('sendBtn');
    sendBtn.addEventListener('click', function() {
      var messageInput = document.getElementById('message');
      var message = messageInput.value;

      if (message) {
        // Add message to local storage
        messages.push(message);
        localStorage.setItem('chatMessages', JSON.stringify(messages));

        // Display the new message in the chatbox
        var newMessageElement = document.createElement('p');
        newMessageElement.textContent = message;
        chatbox.appendChild(newMessageElement);

        // Clear the input field
        messageInput.value = '';
      }
    });

    // Handle clear button click event
    var clearBtn = document.getElementById('clearBtn');
    clearBtn.addEventListener('click', function() {
      // Clear chat messages from local storage
      localStorage.removeItem('chatMessages');

      // Clear chatbox
      messages = [];
      displayMessages();
    });
  </script><br>
    <a href="index.html">Sākums</a>
  </center>
</body>
</html>
