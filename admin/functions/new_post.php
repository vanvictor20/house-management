<?php

require_once "db.php";
require_once "auth.php";

if (isset($_POST["submit"])) {
  $author = uncrack($_POST['author']);
  $title = uncrack($_POST['title']);
  $content = $_POST['content'];

  try {
    $db->prepare("INSERT INTO posts(author, title, content) VALUES (?,?,?)")
      ->execute([$author, $title, $content]);
    header('Location:../posts.php?posted');
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error";
  }
}
