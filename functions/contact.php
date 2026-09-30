<?php

require_once "../admin/functions/db.php";

if (isset($_POST['submit'])) {
  try {
    $db->prepare("INSERT INTO contacts(names, email, message) VALUES (?,?,?)")
      ->execute([uncrack($_POST['names']), is_email($_POST['email']), uncrack($_POST['message'])]);
    header('Location:../contact.php?sent');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
