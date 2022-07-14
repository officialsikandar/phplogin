<?php
include "../config.php";
if(isset($_POST['submit'])){
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

    $user = "SELECT * FROM `user` WHERE `user`.`username` = '$email' AND `user`.`password`= '$password' LIMIT 1";
    $data = mysqli_query($conn, $user);
    $row = mysqli_num_rows($data);
    if($row == 1){
      header("Location: signup.php");
    }
    else{
      echo "Email or Password does not exist!";
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
        <h1 style="color:#124574">Sign-up</h1>
      </div>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                <label class="form-check-label" style="margin-left:400px;" for="exampleCheck1"><a href="forget.php">Forget Password?</a></label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
  </body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>