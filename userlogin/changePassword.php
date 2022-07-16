<?php
// include "index.php";
include "../config.php";

if(isset($_POST['submit'])){
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $otp = mysqli_real_escape_string($conn, $_POST['otp']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
  $timeStamp = getdate(date('U'));
  $ts = "$timeStamp[0]";
    $user = "SELECT * FROM `user` WHERE `user`.`username` = '$email' LIMIT 1";
    $data = mysqli_query($conn, $user);
    $row = mysqli_num_rows($data);
    if($row == 1){
      $data = mysqli_fetch_assoc($data);
      $get_email = $data['username'];
      $get_token = $data['token'];
      $get_timeStamp = $data['timeStamp'];
      
      // echo $get_token."   ".$get_email."   ".$otp;
      if($get_token === $otp){
        if($ts-$get_timeStamp <= 20){
          if($password === $cpassword){
            $update_password = "UPDATE `user` SET `password` = '$password' WHERE `user`.`username` = '$get_email';";
            $update_password_run = mysqli_query($conn, $update_password);
            if($update_password_run){
              echo '<script>alert("Password Successfully Updated");</script>';
              header('Location: http://localhost/php1/userlogin/');
            }
            else{
              echo '<script>alert("Password Not Updated, Something went wrong!");</script>';
            }
          }
          else{
              echo '<script>alert("Confirm Password Not Matched!");</script>';
          }
        }
        else{
          echo '<script>alert("Time is Out!");</script>';
        }
      }
      else{
        echo '<script>alert("Entered OTP is Wrong");</script>';
        header('Location: http://localhost/php1/userlogin/forget.php');
      }
    }
    else{
          echo '<script>alert("Email not found");</script>';
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
        <h1 style="color:#124574">Change Password</h1>
      </div>

        <form action="changePassword.php" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <input type="text" name="otp" class="form-control mb-3" placeholder="OTP" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Passowrd" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <input type="text" name="cpassword" class="form-control mb-3" placeholder="Conform Password" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Change Password</button>

        </form>
    </div>
    
  </body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
