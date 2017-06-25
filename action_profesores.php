<?php
####
#### Manejo de las peticiones hechas por nuestra aplicación.
#### Podemos considerarlo como un controller (controlador) de acciones
#### a partir de lo que consulta u opera el usuario en éste módulo.
####

include 'config.php';
include 'db_connect.php';
include 'common/helpers_func.php';

/**
* Servicios pertenecientes a operaciones comunes de profesor.
* Podría ésta clase situarse luego en otro lugar aparte.
*/
class ServiceProfesores
{
	public static function getDb() {
		// Devolver la variable/constante configurada ya de antemano.
		return $GLOBALS["db"];
	}

	public static function insertFromArray($input_fields) {
		$fields = [];

		// Comprobación de datos obligatorios. DEBEN estar en el array dado.
		$required_list = [
			"apellido",
			"nombres",
			"DNI"
		];
		foreach ($required_list as $f) {
			if ( ! isset($input_fields[$f]) || $input_fields[$f] == "") {
				throw new Exception("Error. No se han provisto todos los datos requeridos.");
			}
		}

		// Estipulamos cuales son todos los nombres de columna que lleva éste registro
		// para tomarlas correctamente del array recibido por param.
		$fields_list = [
			"apellido",
			"nombres",
			"DNI"
		];
		foreach ($fields_list as $f) {
			if (isset($fields_list[$f])) {
				$fields[$f] = $input_fields[$f];
			} else {
				$fields[$f] = "";
			}
		}

		$sql = "INSERT INTO Profesores (
					Id,
					apellido,
					nombres,
					DNI)
				VALUES (
					NULL,
					'{$fields["apellido"]}',
					'{$fields["nombres"]}',
					'{$fields["DNI"]}')";

		$query = self::getDb()->prepare($sql);
		$query_ok = $query->execute();

		return $query_ok;
	}

}

// 				!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// * * * * * Reescritura del action create, probando la clase service.
if ($_GET["action"] == "create") {
	$opera_ok = FALSE;
	try {
		$opera_ok = ServiceProfesores::insertFromArray($_POST);
	} catch (Exception $e) {
		$ex = exceptionToString($e);
		
		writeLogMessage($ex);
		$err_msg = $ex;
	}

	if ($opera_ok) {
		$resp = [
			"success" => TRUE
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// --------------------------------

if ($_GET["action"] == "search_for_tablelist") {
	$form = [];
	$formdata = [
		"apellido",
		"nombres",
		"DNI"
	];
	$filter = "";

	// Guardar en una variable.
	foreach ($formdata as $f) {
		$form[$f] = $_GET[$f . '_search'];
	}

	// Concatenar según la consulta.
	if ($form["apellido"] != "") {
		$filter .= " AND apellido LIKE '%{$form["apellido"]}%'";
	}

	if ($form["nombres"] != "") {
		$filter .= " AND nombres LIKE '%{$form["nombres"]}%'";
	}

	if ($form["DNI"] != "") {
		$filter .= " AND DNI LIKE '%{$form["DNI"]}%'";
	}

	$sql = "SELECT
				Id,
				apellido,
				nombres,
				DNI
			FROM Profesores
			WHERE Id <> 0 " . $filter . "
			ORDER BY Id DESC"; //echo $sql;exit;

	$query_ok = FALSE;
	try {
		$query = $db->prepare($sql);
		$query_ok = $query->execute();
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		$resp = [
			"success" => TRUE,
			"results" => $results
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// --------------------------------

/*
if ($_GET["action"] == "create") {
	$form = [];
	$formdata = [
		"apellido",
		"nombres",
		"DNI"
	];

	// Guardar en una variable.
	foreach ($formdata as $f) {
		$form[$f] = $_POST[$f];
	}

	$sql = "INSERT INTO Profesores (
				Id,
				apellido,
				nombres,
				DNI)
			VALUES (
				NULL,
				'{$form["apellido"]}',
				'{$form["nombres"]}',
				'{$form["DNI"]}')";

	$query_ok = FALSE;
	try {
		$query = $db->prepare($sql);
		$query_ok = $query->execute();
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$resp = [
			"success" => TRUE
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}
*/

// --------------------------------

if ($_GET["action"] == "update") {
	$form = [];
	$formdata = [
		"Id",
		"apellido",
		"nombres",
		"DNI"
	];

	// Guardar en una variable.
	foreach ($formdata as $f) {
		$form[$f] = $_POST[$f];
	}

	$sql = "UPDATE Profesores
			SET
				apellido = '{$form["apellido"]}',
				nombres = '{$form["nombres"]}',
				DNI = '{$form["DNI"]}'
			WHERE Id = {$form["Id"]}";

	$query_ok = FALSE;
	try {
		$query = $db->prepare($sql);
		$query_ok = $query->execute();
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$resp = [
			"success" => TRUE
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// --------------------------------

if ($_GET["action"] == "delete") {
	// Solo obtenemos el id de la solicitud.
	$Id = $_POST["Id"];

	$sql = "DELETE FROM Profesores WHERE Id = {$Id}";

	$query_ok = FALSE;
	try {
		$query = $db->prepare($sql);
		$query_ok = $query->execute();
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$resp = [
			"success" => TRUE
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// --------------------------------

if ($_GET["action"] == "fetch_single") {
	// Solo obtenemos el id de la solicitud.
	$Id = $_GET["Id"];

	$sql = "SELECT
				Id,
				apellido,
				nombres,
				DNI
			FROM Profesores
			WHERE Id = {$Id}";

	$query_ok = FALSE;
	try {
		$query = $db->prepare($sql);
		$query_ok = $query->execute();
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$result = $query->fetchObject();
		$resp = [
			"success" => TRUE,
			"result" => $result
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// --------------------------------

if ($_GET["action"] == "validate_dni_exists") {
	$dni = $_GET["dni"]? : 0;

	$query_ok = FALSE;
	try {
		$query = $db->query("SELECT COUNT(*) FROM Profesores WHERE DNI={$dni}");
		$query_ok = ($query !== FALSE);
	} catch (PDOException $e) {
		writeLogMessage($e->getMessage());
		$err_msg = $e->getMessage();
	}

	if ($query_ok) {
		$num = $query->fetchColumn();
		$resp = [
			"success" => TRUE,
			"existing" => ($num > 0)
		];
	} else {
		$resp = ["success" => FALSE];
		if ($_app_debug_mode && isset($err_msg)) {
			$resp["error_msg"] = $err_msg;
		}
	}

	// Enviar la respuesta.
	header('Content-Type: application/json');
	echo json_encode($resp);
}

// Fin del script.
