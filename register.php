<?php
  require_once("connect.php");
  $username = $email = $password = $confirmPassword = $Err ="";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["register"])){
      $username = test_input($_POST["Username"]);
      $email = test_input($_POST["email"]);
      $password = test_input($_POST["password"]);
      $confirmPassword = test_input($_POST["confirmPassword"]);

      if(empty($_POST['Username']) or empty($_POST['email']) or empty($_POST['password']) or empty($_POST['confirmPassword'])){
        $Err = "Empty input";
      }else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $Err = "Invalid email format";
          echo $Err;
        }else {
          $sql = "SELECT 1 FROM user WHERE email = '$email'";
          $result = $conn->prepare($sql);
          $result->execute();
          if ($result->rowCount() > 0){
            $Err = 'Email already exists';
          }elseif($password != $confirmPassword){
            $Err = "Passwords doesn't match";
          }else {
            $stmt = $conn->prepare("INSERT INTO user (username, email,password)VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            header('Location: login.php');
          }

        }
      }
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Register</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
          <form method="post" action="">
            <?php
              if(!empty($Err))
              echo '<div class="alert alert-danger" role="alert"><span class="error">'.$Err.'</span></div>';
              $Err= "";
              ?>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="Username" name="Username" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                    <label for="Username">Username</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required">
                    <label for="inputEmail">Email address</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
            <input class="btn btn-primary btn-block" type="submit" value="Register" name="register">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="login.html">Login Page</a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
