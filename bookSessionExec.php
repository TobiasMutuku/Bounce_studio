<?php include './session.php'; ?>
<?php
    //name spaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    //define variables
    $email = $subject = $message = "";

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

    /*if (empty($_POST['name'])) {
      $errors[] = "name is required";
    } 
    else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['name'])) {
      $errors[] = "Invalid name. Only alphanumeric characters are allowed.";
      //array_push($errors, "Invalid name. Only alphanumeric characters, hyphens, and underscores are allowed.")
    } else {
        $name = sanitize($_POST['name']);
    }*/
    
    if (empty($_POST['email'])) {
        $errors[] = "Email is required";
    } 
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        $email = sanitize($_POST['email']);
    }

    if (empty($_POST['subject'])) {
        $errors[] = "subject is required";
    } else {
        $subject = sanitize($_POST['subject']);
    }


    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    }  else {
        $message = sanitize($_POST['message']);
    }

    // If there are no errors, send to mail and insert into the database
    if (count($errors) == 0) {

        $mail = new PHPMailer(true); //new PHPMailer;

        //$mail->SMTPDebug = 3;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; //ssl
        $mail->Port = 587; //465 --> ssl
        $mail->Username = 'boncestudios@gmail.com';
        $mail->Password = ''; //app password -> security -> generate app password

        $mail->setFrom('boncestudios@gmail.com', 'Bounce Studio'); //email from input
        $mail->addAddress($email);

        $mail->isHTML(true);

        //$mail->addAttachment()
        $mail->Subject = $subject; //$subject
        $mail->Body = 'Your request has been received and we will get back to you about your booking.Thank you for choosing Bounce Studio';

        //$mail->send();

        if($mail->send()) {
        
        //insert data
        $query = "INSERT INTO bookings(user_id, email, subject, message) VALUES('$user_id','$email','$subject','$message')";
        //`bookings`(`booking_id`, `name`, `email`, `subject`, `message`, `time`) VALUES ('','','','','','')

        $insertData = mysqli_query($conn,$query);

        //check if query was successful
        if($insertData) {
            echo '
                <script>
                    alert("Thank you for your choosing Bounce Studio! Your Session booking is successful.");
                    document.location.href = "thankyou.php";
                </script>
                ';
		    //header("location: thankyou.php");
		    exit();
	    }else {
		    die("Session booking failed!");
            //echo "<h3 style='color:red'></h3>".mysqli_error($connection);
	    }

        // Close the database connection
        $conn->close();
        } else {
            echo 
            '<script>
                alert("Session booking not successful! Please try again");
                document.location.href = "bookSession.php";
            </script>
            ';
        }
        
        //header("Location: thankyou.php");

        $mail->smtpClose();
    } else {
    // Display the validation errors
    foreach ($errors as $error) {
        echo "<p>" . $error . "</p>";
    }
}
    
}
?>