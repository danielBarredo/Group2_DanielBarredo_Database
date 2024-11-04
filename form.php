<?php
// HTTP header
header("Content-Type: text/html; charset=UTF-8");

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['fname'];
    $password = $_POST['password'];
    $robot = $_POST['robot'];

    // This is the form validation
    if (strlen($name) < 3 || preg_match("/\d/", $name)) {
        $error = "First name must be at least 3 characters long and contain no numbers.";
    } elseif (!preg_match("/^\d+$/", $password)) {
        $error = "Password must contain numbers only.";
    } elseif ($robot !== "yes" && $robot !== "no") {
        $error = "The answer to 'Are you a robot?' must be 'yes' or 'no'.";
    } else {
        // Include
        include('poll.html');
        exit();
    }
}
?>

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

  window.location.href = "poll.html";
  return false; 
}
</script>
<title>Group 2: Website</title>
</head>
<body>

<div class="form-container">
  <img src="group photos/logo.png" alt="Group Logo" class="logo"> 
  <form method="POST" action="">
    <label for="fname">What is your name?</label>
    <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" placeholder="Enter your name">
    <p>Suggestions: <span id="txtHint"></span></p>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Enter password">

    <label for="robot">Are you a robot?</label>
    <input type="text" id="robot" name="robot" placeholder="">

    <input type="submit" value="Submit">
    
    <p id="error" class="error">
        <?php if ($error) echo $error; ?>
    </p>
  </form>
</div>

</body>
</html>
