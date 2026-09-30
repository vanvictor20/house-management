<?php

require_once "db.php";
require_once "auth.php";

if (isset($_POST["deleteTenant"])) {
  $tenid = $_POST["tenID"];
  $numberOfRooms = (int) $_POST["num"];
  $roomId = $_POST['hsID'];
  $hsState = $_POST["state"];

  if ($numberOfRooms == 0) {
    // a renting unit is being freed, so the house becomes vacant
    $hsState = 'Vacant';
  }
  $numberOfRooms += 1;

  $mysqli->autocommit(false);
  $status = db_query($mysqli, "DELETE FROM `tenants` WHERE `tenantID`=?", [$tenid])
    && db_query($mysqli, "UPDATE `houses` SET `number_of_rooms`=?, `house_status`=? WHERE `houseID`=?", [$numberOfRooms, $hsState, $roomId]);

  if ($status) {
    $mysqli->commit();
    header('Location:../tenants.php?deleted');
  } else {
    $mysqli->rollback();
    header('Location:../tenants.php?del_error');
  }
} else {
  header('Location:../tenants.php?del_error');
}
