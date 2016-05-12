<?php

if (isset($_GET[id])) {
    include 'single.php';
    include ("footer.php");
} else {
    $pageTitle = "Main page";
    include("header.php");
    include 'main.php';
    include ("footer.php");
}
?>    
