<?php
include 'config.php';
include 'db_connect.php';

####
#### Manejo de las peticiones hechas por nuestra aplicación.
#### Podemos considerarlo como un controller (controlador) de acciones
#### a partir de lo que consulta u opera el usuario en éste módulo.
####

// --------------------------------

if ($_GET["action"] == "search_for_tablelist") {
    $form = [];
    $formdata = [
        "Apellido",
        "Nombre",
        "DNI"
    ];
    $filter = "";

    // Guardar en una variable.
    foreach ($formdata as $f) {
        $form[$f] = $_GET[$f];
    }

    // Concatenar según la consulta.
    if ($form["Apellido"] != "") {
        $filter .= " AND Apellido LIKE '%{$form["Apellido"]}%'";
    }

    if ($form["Nombre"] != "") {
        $filter .= " AND Nombre LIKE '%{$form["Nombre"]}%'";
    }

    if ($form["DNI"] != "") {
        $filter .= " AND DNI LIKE '%{$form["DNI"]}%'";
    }

    $sql = "SELECT * FROM profesores WHERE Id <> 0 " . $filter . " ORDER BY Id DESC"; //echo $sql;exit;
    $query = $db->query($sql);

    if ($query) {
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $resp = [
            "success" => TRUE,
            "results" => $results
        ];
    } else {
        $resp = ["success" => FALSE];
    }

    // Enviar la respuesta.
    header('Content-Type: application/json');
    echo json_encode($resp);
}

// Fin del script.
