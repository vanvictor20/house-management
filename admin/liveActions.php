<?php

require_once "functions/db.php";
require_once "functions/auth.php";

if (isset($_GET["act"]) && $_GET["act"] == 'notifications') {
	// mark a notification as seen
	db_query($conn, "UPDATE `transactions` SET `seen`='YES' where `id`=?", [$_GET["q"]]);
}
