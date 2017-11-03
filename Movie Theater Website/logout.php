<?php
session_start();
unset($_SESSION["username"]);
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}
if (isset($_SESSION['manager'])) {
    unset($_SESSION['manager']);
}
session_destroy();
header("Location: index.php");