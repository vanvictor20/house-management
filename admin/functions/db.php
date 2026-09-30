<?php
/*
 * Main connector: loads configuration, opens the database connections and
 * provides the shared input helpers.
 */

$config = require file_exists(__DIR__ . '/config.php')
    ? __DIR__ . '/config.php'
    : __DIR__ . '/config.example.php';

if ($config['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}

$host = $config['db']['host'];
$user = $config['db']['user'];
$usrpassword = $config['db']['password'];
$database = $config['db']['name'];
$port = $config['db']['port'];

global $connection, $mysqli, $conn, $db;

try {
    // $mysqli is used for multi-statement transactions (autocommit toggling),
    // so it gets its own connection; $conn and $connection share one.
    $mysqli = new mysqli($host, $user, $usrpassword, $database, $port);
    $connection = new mysqli($host, $user, $usrpassword, $database, $port);
    $conn = $connection;
    $mysqli->set_charset('utf8mb4');
    $connection->set_charset('utf8mb4');

    $db = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $user, $usrpassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
}

/**
 * Run a prepared statement on a mysqli connection and return the result
 * (mysqli_result for SELECTs, true for writes, false on failure).
 */
function db_query(mysqli $link, string $sql, array $params = [])
{
    try {
        $stmt = $link->prepare($sql);
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...array_map('strval', $params));
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result === false ? true : $result;
    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

/*********************************************************
            other basic methods
**********************************************************/

// Trim input and HTML-escape it before it is stored.
// SQL injection is handled by prepared statements, not here.
function uncrack($data)
{
    return htmlspecialchars(trim((string) $data));
}

// format usernames
function is_username($data)
{
    return ucwords(strtolower(uncrack($data)));
}

// format emails
function is_email($data)
{
    return strtolower(uncrack($data));
}

function is_logged_in_temporary()
{
    if (isset($_SESSION['email'])) {
        global $username;

        $email = $_SESSION["email"];
        $username = substr($email, 0, strpos($email, "@"));

        return true;
    }
    return false;
}
