<?php
// include "index.php";
include "../config.php";

// ****************Email send function (send_password_reset)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
require 'vendor/autoload.php';

function send_password_reset($get_email,$token){
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
    $mail = new PHPMailer;                   
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sikandaritguy@gmail.com';                     //SMTP username
    $mail->Password   = 'xonkacudtpzyckqb';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    //Recipients
    $mail->setFrom('sikandaritguy@gmail.com', 'Sikandar Khan');
    $mail->addAddress($get_email);     //Add a recipient
               //Name is optional
    $mail->addReplyTo('sikandaritguy@gmail.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password reset notification';
    $mail->Body    = '<div class="">
                        <div class="header">
                            <h1 style="color:red; background-color:black;">Your verification code is:</h1>
                            <p style="color:blue; font-size:1.2em;"><b>'.$token.'</b></p>
                            <p>Your account can’t be accessed without this verification code, even if you didn’t submit this request.</p>
                            <p>To keep your account secure, we recommend using a unique password for your Adobe account or using the Adobe Account Access app to sign in. Adobe Account Access’ two-factor authentication makes signing in to your account easier, without needing to remember or change passwords.</p>
                            <p>If you have any questions, please contact Support.</p>
                        </div>
                      </div>
  ';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // if($mail == true){
    //   echo '<script>alert("Message has been sent");</script>';
    // }
    // else{
    //   echo '<script>alert("Message has Not sent! Something is wrong.");</script>';
    // }
}


if(isset($_POST['reset'])){
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $token = idate('U').rand(111,999);

    $user = "SELECT * FROM `user` WHERE `user`.`username` = '$email' LIMIT 1";
    $data = mysqli_query($conn, $user);
    $row = mysqli_num_rows($data);
    if($row == 1){
      $data = mysqli_fetch_assoc($data);
      $get_email = $data['username'];
      $update_token = "UPDATE `user` SET `token` = '$token' WHERE `user`.`username` = '$get_email'";
      $update_token_run = mysqli_query($conn, $update_token);
      if($update_token_run){
          send_password_reset($get_email,$token);
          echo '<script>alert("We have send reset link on your Email");</script>';
          header("Location: http://localhost/php1/userlogin/changePassword.php");
          // exit(0);
      }
      else{
          echo '<script>alert("Something whent wrong");</script>';
        // header("Location: forget.php");
        // exit(0);
      }
    }
    else{
          echo '<script>alert("Email not found");</script>';
        // header("Location: forget.php");
        // exit(0);
    }
}
?>
<!doctype html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>signup Page</title>
  </head>
  <body>
    <div class="container pt-5" style="width: 50%;">
      <div class="heading text-center mb-5">
        <h1 style="color:#124574">Forget Password</h1>
      </div>

        <form action="forget.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <button type="submit" name="reset" class="btn btn-primary">Get link</button>

        </form>
    </div>
  </body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
