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
    $email = $email = $subject = $message = "";

    //sanitize user add form data
    function sanitize($data) {
        global $conn;
        $data = @trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return mysqli_real_escape_string($conn,$data);
    }

    //isset($_POST['send'])
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    if (empty($_POST['name'])) {
      $errors[] = "name is required";
    } 
    else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['name'])) {
      $errors[] = "Invalid name. Only alphanumeric characters are allowed.";
    } else {
        $name = sanitize($_POST['name']);
    }
    
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

        $mail->SMTPDebug = 3;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; //ssl
        $mail->Port = 587; //465 --> ssl
        $mail->Username = 'boncestudios@gmail.com';
        $mail->Password = 'fbglkjbwatgxigqi'; //app password -> security -> generate app password

        $mail->setFrom($email, $name); //email from input
        $mail->addAddress('boncestudios@gmail.com', 'Bounce Studio');

        $mail->isHTML(true);

        //$mail->addAttachment()
        $mail->Subject = $subject; //$subject
        $mail->Body = $message;

        if($mail->send()) {
            echo 
            '<script>
                alert("Thank you for contacting and choosing Bounce Studio.\n We will get back to you in a few minutes.");
                document.location.href = "index.php";
            </script>
            ';
        } else {
            echo 
            '<script>
                alert("Message could not be delivered successfully! Please try again");
                //document.location.href = "index.php";
            </script>
            ';
        }

        //header("Location: ./thankyou.php");

        $mail->smtpClose();
    } else {

        // Display the validation errors
        foreach ($errors as $error) {
            echo 
            '<script>
                alert("'.$error.'");
                document.location.href = "index.php";
            </script>
            ';
        }
    }
}
?>