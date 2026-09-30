<?php

require_once "db.php";
require_once "auth.php";

if (isset($_POST['submit'])) {
  $email = is_email($_POST['email']);
  $uname = is_username($_POST['uname']);
  $role = uncrack($_POST['role']);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit;
  }

  $stmt = $db->prepare("SELECT `id` FROM `admin` WHERE `email` = ?");
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    echo "Oops...This email already exists!";
    exit;
  }

  $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);

  try {
    $db->prepare("INSERT INTO `admin` (`email`, `password`, `name`, `role`) VALUES (?, ?, ?, ?)")
      ->execute([$email, $password, $uname, $role]);
    header('Location:../users.php?added');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
