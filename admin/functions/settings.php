<?php

require_once "db.php";
require_once "auth.php";

// UPDATE PASSWORD
if (isset($_POST['submit'])) {
  if ($_POST['password'] !== ($_POST['password2'] ?? null)) {
    header('Location:../settings.php?mismatch');
    exit;
  }
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);

  try {
    $db->prepare("UPDATE admin SET password = ? WHERE email = ?")
      ->execute([$password, $_SESSION['email']]);
    header('Location:../index.php?set');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
