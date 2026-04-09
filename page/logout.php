<?php
require "../conf/function.php";

session_start();
session_unset();
session_destroy();


header("Location: $url");
exit();
?>
