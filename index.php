<?php
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    include_once("./View/$page.php");
?>