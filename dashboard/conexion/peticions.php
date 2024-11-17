<?php
header('Content-Type: application/json');
include "../../conexion/Cursos.php";
$actions = new Cursos();
if (isset($_POST["action"]) && $_POST["action"] == "getcourses") {
    $dataUrl = $_POST["suscripcion"];
    $getCurso = $actions->getCourses($dataUrl);

    if (!$getCurso) {
        $response = array("success" => false, "message" => "No se ha encontrado ningún curso");
    } else {
        $response = array("success" => true, "message" => $getCurso);
    }

    echo json_encode($response);
}
if (isset($_POST["action"]) && $_POST["action"] == "getleccionofcourse") {
    try {
        $dataUrl = $_POST["idcurso"];
        $iduser = $_POST["idusuario"];
        
        // Obtener las lecciones del curso
        $getCurso = $actions->getLeccionOfCourse($dataUrl);

        if (!$getCurso) {
            // Si no se encuentra el curso
            $response = array("success" => false, "message" => "No se ha encontrado ninguna lección");
        } else {
            // Obtener las lecciones vistas por el usuario
            $revisarExist = $actions->getVistos($iduser, $dataUrl);
            
            // Si se encuentran lecciones vistas
            if ($revisarExist) {
                // Crear un array de los IDs de las lecciones vistas por el usuario
                $vistosIds = array_map(function($visto) {
                    return $visto['ultima_leccion_vista_id'];
                }, $revisarExist);
                
                // Añadir el campo 'estado' a cada lección
                foreach ($getCurso as &$leccion) {
                    // Si el ID de la lección está en el array de lecciones vistas
                    if (in_array($leccion['id_leccion'], $vistosIds)) {
                        $leccion['estado'] = 1; // Marcamos como completada
                    } else {
                        $leccion['estado'] = 0; // Marcamos como pendiente
                    }
                }

                // Devolver los datos con las lecciones y su estado
                $response = array("success" => true, "message" => $getCurso, "vistos" => $revisarExist);
            } else {
                // Si no se han visto lecciones, las marcamos todas como pendientes
                foreach ($getCurso as &$leccion) {
                    $leccion['estado'] = 0; // Marcamos todas como pendientes
                }
                $response = array("success" => true, "message" => $getCurso, "vistos" => array());
            }
        }

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    } catch (\Throwable $th) {
        // Si ocurre un error, se maneja y se devuelve un mensaje de error
        $response = array("success" => false, "error" => $th->getMessage());
        echo json_encode($response);
    }
}
