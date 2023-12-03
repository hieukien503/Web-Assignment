<?php

/** Enable PHP error reporting */
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
/**
 * Run this script only once. 
 * When done, comment out this script.
 */
<<<<<<< HEAD
 include_once("Model/initDB.php");
=======
if (isset($_SESSION['initDB'])) {
    if ($_SESSION['initDB']) {
        include_once("Model/initDB.php");
        $_SESSION['initDB'] = false;
    }
}

>>>>>>> 9448510d2a3d7f944975ef7539391a49fb926d08
?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : "home";
include_once("./View/$page.php");
?>