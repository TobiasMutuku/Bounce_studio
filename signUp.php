<?php

require_once("connection.php");

//define variables
$username = $image = $email = $phone_number = $pass = "";

//sanitize user add form data
function sanitize($data) {
    global $conn;
    $data = @trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    return mysqli_real_escape_string($conn,$data);
}

// Validate the form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $errors = [];
  $dir = './uploads/';

  $fileName = $_FILES['image']['name'];
  $fileTmpName = $_FILES['image']['tmp_name'];
  $fileError = $_FILES['image']['error'];

if (empty($_POST['username'])) {
  $errors[] = "Username is required";
} 
else if (!preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['username'])) {
  $errors[] = "Invalid username. Only alphanumeric characters, hyphens, and underscores are allowed.";
  //array_push($errors, "Invalid username. Only alphanumeric characters, hyphens, and underscores are allowed.")
} else {
    $username = sanitize($_POST['username']);
}

if (empty($fileName)) {
  $errors[] = "Your photo is required";
} 
else {
  $filename = basename($_FILES['image']['name']);
  $filetype = pathinfo($filename, PATHINFO_EXTENSION);

  $allowedImageTypes = array('jpg', 'jpeg', 'png', 'gif');

  if(in_array($filetype, $allowedImageTypes)) {
      if($fileError === 0){
          if(move_uploaded_file($fileTmpName, $dir.$filename)) {
              $image = $fileName;
          } else {
              echo '<script>
                      alert("Failed to upload file");
                  </script>';
          }
      }else {
          $errors[] = "There was an error uploading the image";
      }

    } else {
        $errors[] = "Invalid image format! Only jpg, jpeg, png & gif are allowed";
    }
}

if (empty($_POST['email'])) {
    $errors[] = "Email is required";
} 
else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
} else {
    $email = sanitize($_POST['email']);
}

if (empty($_POST['phone'])) {
    $errors[] = "Phone no. is required";
} 
else if (!preg_match('/^[+][0-9]/', $_POST['phone'])) {
    $errors[] = "Invalid phone number! Should start with +country code...";
}
else if (!preg_match('/^[+][0-9]{10,13}$/', $_POST['phone'])) {
  $errors[] = "Invalid phone number! Exceeds phone number length";
} else {
    $phone_number = sanitize($_POST['phone']);
}


if (empty($_POST['password'])) {
    $errors[] = "Password is required";
  } 
  else if ($_POST['password'] != $_POST['confirm_password']) {
    $errors[] = "Passwords do not match";
  }
  else if (!preg_match('/^(?=.*[A-Za-z])(?=.*[@#$%^&*-+=]).{8,24}$/', $_POST['password'])) {
    $errors[] = "Password should contain atleast one special character & be atleast 8 characters!";
  } else {
    $password = sanitize($_POST['password']);
  }

// If there are no errors, insert the user into the database
if (count($errors) == 0) {

//hash password -->$password = password_hash($pass, PASSWORD_BCRYPT);

//check whether an account with the email exist
$queryuser = "SELECT email FROM users WHERE email = '$email'";
$userResult = mysqli_query($conn,$queryuser);

if(mysqli_num_rows($userResult) > 0){
    echo '
        <script>
            alert("This email is already used by someone else. Try a different email kindly");
            document.location.href = "signUp.php";
        </script>
    ';
    exit();
} else {
    //insert data
    //insert data
        //insert data
        $query = "INSERT INTO users(user_name, user_image, email, phone_no, password) VALUES('$username','$image','$email','$phone_number','$password')";

    $insertData = mysqli_query($conn,$query);

    //check if query was successful
    if($insertData) {
        echo '
            <script>
                alert("User added successfully");
                document.location.href = "signIn.php";
            </script>
        ';
    exit();
  }else {
    die("Something went wrong.\n Our team is working on it.\n Please try again after some few minutes.");
        //echo "<h3 style='color:red'>User not registered. Please try again.</h3>".mysqli_error($connection);
  }

    // Close the database connection
    $conn->close();
} 
} else {
// Display the validation errors
foreach ($errors as $error) {
    echo "
        <script>
            alert('$error');
            document.location.href = 'signUp.php';
        </script>
    ";
    exit();
}
}

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



<body>
  <div class="log">
    <h2 class="sign_up_title">Sign Up</h2>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data"
      class="sign_up_form">

      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="image">User Image:</label>
      <input type="file" id="image" name="image" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone No:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <br></br>
      <input type="submit" value="Sign Up">
      <br></br>
      <p>Already have an account?<a href="signIn.php">Sign In</a></p>
    </form>
  </div>
</body>

</html>