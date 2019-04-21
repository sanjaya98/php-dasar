<?php

// hapus session
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// hapsu cookie
setcookie('id', '', time() - 360 );
setcookie('key', '', time() - 360);




header("location: login.php");
exit;


?>
