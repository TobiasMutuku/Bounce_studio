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
    <h2 class="add_user_title">Add User</h2>
    <br>
    <form action="addUserExec.php" method="post" enctype="multipart/form-data">

      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="image">Photo:</label>
      <input type="file" id="image" name="image" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone No:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      
      <div class="add_btns">
      <input type="submit" value="Add User" class="add_btn">
      <a href="adminDashboard.php" class="back_btn">Back</a>
      </div>

    </form>
  </div>
  </body>

</html>