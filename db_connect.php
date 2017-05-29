<?php
try {
    $db = new PDO("mysql:host={$_db_host};dbname={$_db_name};charset=utf8", $_db_user, $_db_pass);
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
    die();
}

// Fin del script.
