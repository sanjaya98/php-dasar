<?php
session_start();
require 'functions.php';

// cek cookie
if( isset($_COOKIE['id'] ) &&  isset($_COOKIE['key']) ) {
  $id = $_COOKIE['id'];
  $key  = $_COOKIE['key'];

  // ambi Username berdasarkan id
  $result = mysqli_query( $conn, "SELECT username FROM user WHERE id = $id");
  $row = mysqli_num_rows($result);

  // cek cookie dan username
  if( $key === hash('sha256', $row['username']) ) {
    $_SESSION['login'] = true;
  }

}

if( isset($_SESSION["login"]) ) {
    header("location: index.php");
    exit;

}



  if( isset($_POST["login"]) ) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if( mysqli_num_rows($result) === 1 ) {

        // cek password
      $row = mysqli_fetch_assoc($result);
      if( password_verify($password, $row["password"]) ) {

        // set session
        $_SESSION["login"] = true;

        // cek remember me
        if ( isset($_POST['remember']) ) {
          // buat cookie

          setcookie('id', $row['id'], time()+120 );
          setcookie('key', hash('sha256', $row['username']), time()+120 );
        }


        header("location: index.php");
        exit;
      }
    }

    $error = true;

  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Halaman Login</title>

  </head>
  <body>

   <h1>Halaman Login</h1>

   <form action="" method="post">

    <?php  if( isset($error) ) : ?>
      <p style="color: #fb0606; font-style: italic;">username / password salah</p>
    <?php endif; ?>

     <ul>
       <li>
         <label for="username">Username</label>
         <input type="text" name="username" id="username">
       </li>
       <li>
         <label for="password">Password</label>
         <input type="password" name="password" id="password">
       </li>
       <li>
         <input type="checkbox" name="remember" id="remember">
         <label for="remember">Remember me</label>
       </li>
       <li>
         <button type="submit" name="login">Login</button>
       </li>
     </ul>

   </form>

  </body>
</html>
