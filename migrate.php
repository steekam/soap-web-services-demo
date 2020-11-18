<?php

require_once __DIR__.'/vendor/autoload.php';
require_once 'constants.php';

use App\Database;

$pdo = (new Database())->connect();
$students_table_query = trim(file_get_contents("scripts/create_students_table.sql"));
try {
    $pdo->exec($students_table_query);
    echo "Created students table successfully";
} catch (Exception $e) {
    die($e->getMessage());
}
