<?php 
session_start();

print_r($_POST);

echo $_SESSION['photo'];

unset($_SESSION['photo']);