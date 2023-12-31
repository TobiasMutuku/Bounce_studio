<?php
session_start();
  
require("connection.php");

//sanitize user add form data
function sanitize($data) {
  global $conn;
  $data = @trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  
  return mysqli_real_escape_string($conn,$data);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = sanitize($_POST['email']);
  $password = sanitize($_POST['password']);

  //$pass = password_hash($password, PASSWORD_BCRYPT);

  $selectUser = "SELECT * FROM users  WHERE email='$email' ";
  $received = mysqli_query($conn,$selectUser);

  if(!$received){
    echo mysqli_error($conn);
  } else{
    $row =mysqli_num_rows($received);
    $received = mysqli_fetch_assoc($received);

    if($row>0){
      if($password === $received['password']){
        $_SESSION['username'] = $received['user_name'];
        $_SESSION['user_id'] = $received['user_id'];

        //if its the admin redirect to admin page
        if($_SESSION['username'] == 'admin'){
          header("location: adminDashboard.php");
        }
        else{
          header("location: index.php");
        }
      } else {
        echo "
        <script>
          alert('Incorrect Password!');
          document.location.href = 'signIn.php';
        </script>
      ";
      exit();
      }
    } else {
      echo '
        <script>
          alert("User not registered");
          document.location.href = "signIn.php";
        </script>
      ';
      exit();
    }
  }
    $conn->close();
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bounce Studios</title>
  <link rel="stylesheet" type="text/css" href="./Styles/style.css">
  <link rel="icon" href="./Assets/Website icon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
  <script src="https://use.fontawesome.com/e9a23594ea.js"></script>
</head>

<div class="log">

  <body>
    <h2>Sign In</h2>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required placeholder="e.g yourname@gmail.com">
      
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required placeholder="******">

      <br></br>
      <p class="forget_pass">Forgot password?<a href="resetPassword.php">Reset password</a></p>

      <input type="submit" value="Sign In" class="sign_in">
      <br></br>
      <p>Don't have an account?<a href="signUp.php">Sign Up</a></p>
    </form>
  </body>
</div>

</html>