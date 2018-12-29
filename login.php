<?php
  require_once("connect.php");
  $email = $password = $Err ="";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["login"])){
      $email = test_input($_POST["inputEmail"]);
      $password = test_input($_POST["inputPassword"]);

      if(empty($_POST['inputEmail']) or empty($_POST['inputPassword']) ){
        $Err = "Empty input";
      }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $Err = "Invalid email format";
      }else {
          $sql = "SELECT username FROM user WHERE email = '$email' and password = '$password'";
          $result = $conn->prepare($sql);
          $result->execute();
          if ($result->rowCount() == 1){
            $username = $result->fetch();
            session_start();
            $_SESSION['username']=$username['username'];
            header('Location: index.php');
          }else{
            $Err = "Invalid email or password";
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

    <title>SB Admin - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <form method="POST" action="">
            <?php
              if(!empty($Err))
              echo '<div class="alert alert-danger" role="alert"><span class="error">'.$Err.'</span></div>';
              $Err= "";
              ?>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>
            <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Register an Account</a>
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
