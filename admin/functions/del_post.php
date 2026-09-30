<?php 

 
require_once "db.php";
require_once "auth.php";

if (isset($_POST["id"])) {

	$id = $_POST["id"];

    try {
      $db->beginTransaction();
      $db->prepare("DELETE FROM comments WHERE blogid=?")->execute([$id]);
      $db->prepare("DELETE FROM posts WHERE id=?")->execute([$id]);
      $db->commit();
      header('Location:../posts.php?deleted');

      }

     catch (Exception $e) {
        $e->getMessage();
        echo "Error";
    }

}
else {
	header('Location:../posts.php?del_error');
}

	

?>