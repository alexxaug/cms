<?php include "db.php"; ?>
<?php session_start(); ?>
<?php  include "../admin/admin_functions.php"; ?>
<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
?>
<?php

if(isset($_POST['login'])){
  loginUser($_POST['username'], $_POST['password']);
  };

?>
