<?php
session_start();
session_destroy();
header("Location: http://applicationweb:8080/home.php");
exit();
?>
