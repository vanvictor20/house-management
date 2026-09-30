<?php

require_once "../admin/functions/db.php";

if (isset($_POST['submit'])) {
  try {
    $db->prepare("INSERT INTO comments(name, comment, blogid) VALUES (?,?,?)")
      ->execute([uncrack($_POST['name']), uncrack($_POST['comment']), $_POST['blogid']]);
    header('Location:../blog.php');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
