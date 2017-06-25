<?php
####
#### Funciones de apoyo para todo el conjunto del sistema.
####

# -----------------------------

/**
 * Genera un log diario y escribe en éste el mensaje pasado por parámetro.
 */
function writeLogMessage($msg) {
	$hora = date("H:i:s");
	$msg_str = $hora. " " . $msg . "\r\n";

    // Carpeta de éste archivo.
    $mfilepath = dirname(__FILE__) . '/';

	// Ubicación que tendrá el txt.
    $location = $mfilepath . "../logs/";

    $filename = date("Y-m-d") . "_msglog.txt";
	$file_route = $location . $filename;
	file_put_contents($file_route, $msg_str, FILE_APPEND);
}

/**
 * Recibe un objeto Exception y lo formatea y devuelve en texto para una mejor
 * comprensión del mismo.
 */
function exceptionToString(Exception $e) {
	$fullmessage = "Caught Exception: " . $e->getMessage(). "\n\n"
    					. "File: " . $e->getFile(). "\n\n"
    					. "Line: " . $e->getLine(). "\n\n"
    					. "Trace: \n" . $e->getTraceAsString(). "\n\n";
    return $fullmessage;
}

// Fin del script.
