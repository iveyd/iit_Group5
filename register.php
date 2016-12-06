<?php

// The code in this file was provided by Richard Plotka
  session_start();
  include "resources/php/config.php";
  
  // Connect to the database
  try {
    $host = $config["DB_HOST"];
    $dbname = $config["DB_NAME"];
    $user = $config["DB_USERNAME"];
    $pass = $config["DB_PASSWORD"];
    $dbconn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
  }
  catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
  
  if (isset($_POST['register']) && $_POST['register'] == 'Register') {
    
    //make sure that all fields have been filled in
    if (!isset($_POST['username']) || !isset($_POST['pass']) || !isset($_POST['passconfirm']) || empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['passconfirm'])) {
      $msg = "Please fill in all form fields.";
    }
    else if ($_POST['pass'] !== $_POST['passconfirm']) { //make sure passwords match
      $msg = "Passwords must match.";
    }
    else {
      // Generate random salt
      $salt = hash('sha256', uniqid(mt_rand(), true));      

      // Apply salt before hashing
      $salted = hash('sha256', $salt . $_POST['pass']);
      
      // Store the salt with the password, so we can apply it again and check the result
      $stmt = $dbconn->prepare("INSERT INTO users (username, password, salt) VALUES (:username, :pass, :salt)");
      $stmt->execute(array(':username' => $_POST['username'], ':pass' => $salted, ':salt' => $salt));
      $msg = "Account created.";
      header("Location: index.php");
    }
  } 
?>
<!doctype html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="resources/css/main.css">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Collection Tracker</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    </div>
  </div>
</nav>

  <div id="login" class="text-center">
    <h1>User Registration</h1>
    <?php if (isset($msg)) echo "<p>$msg</p>" ?>
    <form method="post" action="register.php">
      <label for="username">Username: </label><input type="text" name="username" />
      <label for="pass">Password: </label><input type="password" name="pass" />
      <label for="passconfirm">Confirm: </label><input type="password" name="passconfirm" /><br><br>
      <input type="submit" name="register" value="Register" />
    </form>
  </div>

  <footer class="container-fluid text-center">
    <!-- <p>Footer Text</p> -->
  </footer>
</body>
</html>
