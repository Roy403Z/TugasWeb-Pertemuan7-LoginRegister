<?php
if (isset($_COOKIE['user_login_data'])) {
    setcookie('user_login_data', '', time() - 3600, "/");
}

header('Location: login.php');
exit();
?>
