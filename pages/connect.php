<?php

if (!class_exists("EmptyDbResult")) {
    class EmptyDbResult
    {
        public int $num_rows = 0;

        /**
         * Mimic mysqli_result::fetch_assoc() for empty results.
         *
         * @return null
         */
        public function fetch_assoc()
        {
            return null;
        }

        /**
         * Mimic mysqli_result::fetch_all() for empty results.
         *
         * @param mixed $mode
         * @return array
         */
        public function fetch_all($mode = null): array
        {
            return [];
        }
    }
}

$host = getenv("DB_HOST") ?: "127.0.0.1";
$port = (int) (getenv("DB_PORT") ?: "3306");
$dbname = getenv("DB_NAME") ?: "login_db";
$username = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASSWORD") ?: "";

$db_connection_error = null;
$empty_db_result = new EmptyDbResult();
$conn = null;

mysqli_report(MYSQLI_REPORT_OFF);

set_error_handler(function ($severity, $message) use (&$db_connection_error) {
    $db_connection_error = $message;
    return true;
});

try {
    $conn = new mysqli($host, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        $db_connection_error = $conn->connect_error;
        $conn = null;
    } else {
        $conn->set_charset("utf8mb4");
    }
} catch (Throwable $e) {
    $db_connection_error = $e->getMessage();
    $conn = null;
} finally {
    restore_error_handler();
}
?>
