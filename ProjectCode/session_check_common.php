<?php
session_start();
if (!isset($_SESSION['usrname'])) {
  // Jump to login page
  header('Location: LoginPage.html');
}
?>