<?php

require_once "../admin/functions/db.php";

if (isset($_POST['submit'])) {
  $email = is_email($_POST['email']);

  $existing = $db->prepare("SELECT id FROM subscribers WHERE email = ?");
  $existing->execute([$email]);

  if ($existing->fetch()) {
    header("Location:../index.php?fail");
    exit;
  }

  try {
    $db->prepare("INSERT INTO subscribers(email) VALUES (?)")->execute([$email]);
    header('Location:../index.php?subscribed');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
