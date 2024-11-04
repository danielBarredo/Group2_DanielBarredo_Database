<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "grouppage"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = $conn->real_escape_string($_POST['fname']);
    $password = $conn->real_escape_string($_POST['password']);
    $robot = $conn->real_escape_string($_POST['robot']);

    // Validate form input
    if (strlen($name) >= 3 && !preg_match('/\d/', $name) && ctype_digit($password) && ($robot == 'yes' || $robot == 'no')) {
        // Save the data to the session
        $_SESSION['name'] = $name;

        // Insert data into the database
        $sql = "INSERT INTO users (name, password, robot) VALUES ('$name', '$password', '$robot')";
        if ($conn->query($sql) === TRUE) {
            echo "Data saved successfully!";
            header("Location: poll.html");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Invalid form data. Please try again.";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('footerBg2.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  
    .form-container {
      position: relative;
      background-color: white;
      padding: 30px;
      padding-top: 60px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: left;
      z-index: 1;
    }
  
    .logo {
      position: absolute;
      top: -300px;
      left: 50%;
      transform: translateX(-50%);
      width: 400px;
      height: auto;
      z-index: 2;
    }
  
    form {
      display: flex;
      flex-direction: column;
    }
  
    label {
      font-size: 14px;
      color: #555;
      margin-bottom: 8px;
      text-align: left;
    }
  
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
    }
  
    input[type="submit"] {
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-family: 'Arial', sans-serif;
      transition: background-color 0.3s ease;
    }
  
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  
    #txtHint {
      font-style: italic;
      color: #888;
      margin: 5px 0;
    }
  
    .error {
      color: red;
      font-size: 12px;
      margin-top: 10px;
    }
  
    p {
      text-align: left;
      margin-top: 10px;
      font-size: 14px;
    }
  
    /* Cookie notification banner */
    .cookie-banner {
      display: none;
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: pink;
      color: #333;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }
  
    .cookie-banner button {
      background-color: #333;
      color: white;
      border: none;
      padding: 5px 10px;
      margin-left: 10px;
      cursor: pointer;
    }
  
    .cookie-banner button:hover {
      background-color: #555;
    }
  </style>
  <script>
  function showHint(str) {
    const suggestions = ["May", "Daniel", "Rosary Bea", "Jose", "Bee-an"];
    if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } else {
      let hint = suggestions.filter(name => name.toLowerCase().startsWith(str.toLowerCase()));
      document.getElementById("txtHint").innerHTML = hint.join(", ");
    }
  }
  
  function validateForm() {
    var name = document.getElementById("fname").value;
    var password = document.getElementById("password").value;
    var robot = document.getElementById("robot").value;
    var error = document.getElementById("error");
  
    error.innerHTML = "";
  
    if (name.length < 3 || /\d/.test(name)) {
      error.innerHTML = "First name must be at least 3 characters long and contain no numbers.";
      return false;
    }
  
    if (!/^\d+$/.test(password)) {
      error.innerHTML = "Password must contain numbers only.";
      return false;
    }
  
    if (robot.toLowerCase() !== "yes" && robot.toLowerCase() !== "no") {
      error.innerHTML = "The answer to 'Are you a robot?' must be 'yes' or 'no'.";
      return false;
    }
  
    setCookie("userName", name, 7);  // Set cookie to remember the user's name for 7 days
    window.location.href = "poll.html";
    return false;
  }
  
  // Function to set a cookie
  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
  }
  
  // Function to check if a cookie exists
  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }
  
  // Display the cookie notification banner if user hasn't accepted cookies
  window.onload = function() {
    if (!getCookie("cookieConsent")) {
      document.getElementById("cookie-banner").style.display = "block";
    }
  }
  
  // Function to accept cookies and hide the banner
  function acceptCookies() {
    setCookie("cookieConsent", "true", 365);  // Remember consent for one year
    document.getElementById("cookie-banner").style.display = "none";
  }
  </script>
  <title>Group 2: Website</title>
</head>
<body>
<div class="form-container">
  <img src="group photos/logo.png" alt="Group Logo" class="logo">

  <form method="POST">
    <label for="fname">What is your name?</label>
    <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" placeholder="Enter your name">
    <p>Suggestions: <span id="txtHint"></span></p>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Enter password">

    <label for="robot">Are you a robot?</label>
    <input type="text" id="robot" name="robot" placeholder="">

    <input type="submit" value="Submit">
    
    <!-- Display error message from session if any -->
    <p id="error" class="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></p>
  </form>
</div>

<!-- Cookie Notification Banner -->
<div id="cookie-banner" class="cookie-banner">
  This site uses cookies to improve your experience. 
  <button onclick="acceptCookies()">Accept</button>
</div>
</body>
</html>
