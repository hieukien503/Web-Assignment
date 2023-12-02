<?php
session_start();

unset($_SESSION['login']);
unset($_SESSION['initDB']);
header("Location: ../index.php");
?>
