<?php

class Cursos
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "root";
    private $db = "database";

  

    public $dbConnect;

    public $respuesta = array();
    public function __construct()
    {
        $this->dbConnect = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->dbConnect->connect_error) {
            die("Error en la conexión a la base de datos: " . $this->dbConnect->connect_error);
        }
    }
    public function getDbConnect()
    {
        return $this->dbConnect;
    }
    public function executeQuery($query)
    {
        $result = $this->dbConnect->query($query);
        if ($result === false) {
            die("Error en la consulta: " . $this->dbConnect->error);
        }
        return $result;
    }
    public function prepare($query)
    {
        return $this->dbConnect->prepare($query);
    }
    public function postInsert($table, $camps, $vals, $bind_param, $data_camps)
    {

        $sql = "INSERT INTO $table ($camps) VALUES ($vals)";

        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            $respuesta["success"] = false;
            $respuesta["message"] = "Error en la preparación de la consulta" . mysqli_error($this->dbConnect);
        } else {
            // Enlaza los parámetros y ejecuta la consulta
            if (!mysqli_stmt_bind_param($stmt, $bind_param, ...$data_camps)) {
                // Si hay un error al enlazar los parámetros
                $respuesta["success"] = false;
                $respuesta["message"] = "Error al enlazar los parámetros: " . mysqli_stmt_error($stmt);
            } else {
                // Ejecuta la consulta
                if (!mysqli_stmt_execute($stmt)) {
                    // Si hay un error al ejecutar la consulta
                    $respuesta["success"] = false;
                    $respuesta["message"] = "Error en la consulta: " . mysqli_error($this->dbConnect);
                } else {
                    // Si la consulta se ejecuta correctamente
                    $respuesta["success"] = true;
                    $respuesta["message"] = "Consulta satisfactoria";
                }
            }
            // Cierra el statement
            mysqli_stmt_close($stmt);
        }
        return json_encode($respuesta);
    }

    public function getData($table)
    {
        $data = array();
        $sql = "SELECT *FROM $table";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public  function findLeccionExist ($firstdatacondicion, $secondcond){
        $sql = "SELECT * FROM lecciones WHERE id_curso = ? AND id_leccion = ?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if(!$stmt){
            throw new Exception("error: ", $this->dbConnect->error);
        }
        mysqli_stmt_bind_param($stmt, "ii", $firstdatacondicion, $secondcond); // Solo se necesita un marcador de posición para el valor de la condición
        if (mysqli_stmt_execute($stmt)) { // Verifica si la ejecución fue exitosa
            $result = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        } else {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }
    }
    public  function findCourseExist ($firstdatacondicion){
        $sql = "SELECT * FROM cursos WHERE id = ?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if(!$stmt){
            throw new Exception("error: ", $this->dbConnect->error);
        }
        mysqli_stmt_bind_param($stmt, "i", $firstdatacondicion); // Solo se necesita un marcador de posición para el valor de la condición
        if (mysqli_stmt_execute($stmt)) { // Verifica si la ejecución fue exitosa
            $result = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        } else {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }
    }
    public function getCamposSinCondicion($camposObtener, $table)
    {
        $data = array();
        $sql = "SELECT $camposObtener FROM $table";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
        }
        return $data;
    }
    public function getCamposConCondicion($tabla, $condicion, $params)
    {
        $data = array();
        $sql = "SELECT * FROM $tabla WHERE $condicion=$params";
        $result = $this->dbConnect->query($sql);

        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
        }
        return $data;
    }
    public function findCourse($id_curso)
    {
        $data = array();
        $sql = "SELECT * FROM cursos WHERE id = ? AND activo = 1";
    
        // Preparar la consulta
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }
    
        // Vincular el parámetro
        $stmt->bind_param("i", $id_curso);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
        }
    
        // Obtener los datos
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        // Cerrar el statement
        $stmt->close();
    
        return $data;
    }
    
    public function getLeccionCondicion($primero, $segundo, $tercero)
    {
        $data = array();
        $sql = "SELECT * FROM enrollments WHERE user_id = $primero AND course_id = $segundo AND ultima_leccion_vista_id = $tercero";
        $result = $this->dbConnect->query($sql);

        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
        }
        return $data;
    }
    public function getJoinCamps($tabla1, $tabla2, $condicion, $prepare, $condicion_tb1, $condicion_tb2)
    {
        $data = array();
        // Preparar la consulta SQL con marcadores de posición (?)
        $sql = "SELECT $tabla1.*, $tabla2.* FROM $tabla1 JOIN $tabla2 ON $tabla1.$condicion_tb1 = $tabla2.$condicion_tb2 WHERE $tabla2.$condicion_tb2 = ?";
        // $sql = "SELECT lecciones.*, cursos.* FROM lecciones JOIN cursos ON lecciones.id_curso = cursos.id WHERE cursos.id = '1';";

        // Preparar la consulta
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }

        // Asignar el parámetro a la consulta preparada y ejecutar la consulta
        $stmt->bind_param($prepare, $condicion); // Suponiendo que $condicion sea un valor entero (si es una cadena, usa "s" en lugar de "i")
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado de la consulta: " . $stmt->error);
        }

        // Recorrer el resultado y almacenar los datos en $data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Cerrar la consulta preparada
        $stmt->close();

        return $data;
    }
    public function updateData($table, $datas, $condicion, $params)
    {
        $sql = "UPDATE $table SET $datas WHERE $condicion=?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            throw new Exception("Error: " . $this->dbConnect->error);
        }

        // Asignar valor a los parámetros
        mysqli_stmt_bind_param($stmt, 's', $params); // Asignar el valor del parámetro $params

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $rows_affected = mysqli_stmt_affected_rows($stmt);

        mysqli_stmt_close($stmt); // Cerrar el statement

        return $rows_affected > 0; // Devolver verdadero si se han afectado filas, falso de lo contrario
    }


    public function getCourses($suscripcion)
    {
        $data = array();

        if ($suscripcion == 1) {
            // Si la suscripción es 1, selecciona tanto cursos gratuitos como de pago (is_free = 0 o 1)
            $sql = "SELECT cursos.*, usuarios.nombre, usuarios.apellido  FROM cursos INNER JOIN usuarios ON usuarios.id = cursos.id_instructor  WHERE cursos.activo = 1 AND (cursos.is_free = 1 OR cursos.is_free = 0) ORDER BY cursos.id DESC";
            // No es necesario vincular parámetros ya que no estamos usando una variable en la consulta
            $stmt = $this->dbConnect->prepare($sql);
        } else {
            // Si la suscripción no es 1, solo selecciona los cursos gratuitos (is_free = 0)
            $sql = "SELECT cursos.*, usuarios.nombre, usuarios.apellido 
FROM cursos 
INNER JOIN usuarios ON usuarios.id = cursos.id_instructor  
WHERE cursos.activo = 1 AND cursos.is_free = 0 
ORDER BY cursos.id DESC
";
            $stmt = $this->dbConnect->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
            }
        }

        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();

        return $data;
    }

    public function getLeccionOfCourse($id_curso)
    {
        $data = [];
        $sql = "
            SELECT 
                l.*, 
                c.id AS curso_id, 
                c.id_instructor, 
                u.nombre, 
                u.apellido, 
                u.id AS usuario_id 
            FROM 
                lecciones AS l
            INNER JOIN 
                cursos AS c ON l.id_curso = c.id
            INNER JOIN 
                usuarios AS u ON c.id_instructor = u.id
            WHERE 
                l.active = 1 
                AND l.id_curso = ?
            ORDER BY 
                l.orden ASC;
        ";
    
        // Preparar la consulta
        $stmt = $this->dbConnect->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
        }
    
        // Vincular los parámetros
        $stmt->bind_param("i", $id_curso);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    
        // Cerrar la consulta
        $stmt->close();
    
        return $data;
    }
    
    public function getVistos ($userid, $id_curso){
        
        $data = array();
        $sql = "SELECT * FROM enrollments WHERE user_id= ? and course_id=?";
        //Preparar la consulta
        $stmt = $this->dbConnect->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("ii",  $userid, $id_curso);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Cerrar la consulta
        $stmt->close();

        return $data;
    }
    public function getDataByOrderDescCu($table)
    {
        $data = array();
        $sql = "SELECT * FROM $table WHERE activo = '1' ORDER BY id DESC";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getDataByOrderDescCuFree($table)
    {
        $data = array();
        $sql = "SELECT * FROM $table WHERE activo = '1' AND is_free = '0' ORDER BY id DESC";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getLeccion($table, $id_leccion, $id_curso, $orden)
    {
        $data = array();
        $sql = "SELECT * FROM $table WHERE id_leccion = ? AND id_curso = ? AND orden = ?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
        }
        $stmt->bind_param("iii", $id_leccion, $id_curso, $orden);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado: " . $stmt->error);
        }
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    public function getLeccionOrden($primero, $segundo)
    {
        $data = array();
        $sql = "SELECT * FROM lecciones WHERE id_curso = $primero AND orden = $segundo ";
        $result = $this->dbConnect->query($sql);

        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
        }
        return $data;
    }
    public function getJoinCampsOrder($tabla1, $tabla2, $condicion, $prepare, $condicion_tb1, $condicion_tb2, $camp, $st)
    {
        // SELECT lecciones.*, cursos.* FROM lecciones JOIN cursos ON lecciones.id_curso = cursos.id WHERE cursos.id = '1' ORDER BY lecciones.orden ASC
        $data = array();
        // Preparar la consulta SQL con marcadores de posición (?)
        $sql = "SELECT $tabla1.*, $tabla2.* FROM $tabla1 JOIN $tabla2 ON $tabla1.$condicion_tb1 = $tabla2.$condicion_tb2 WHERE $tabla2.$condicion_tb2 = ? ORDER BY $tabla1.$camp $st";
        // $sql = "SELECT lecciones.*, cursos.* FROM lecciones JOIN cursos ON lecciones.id_curso = cursos.id WHERE cursos.id = '1';";

        // Preparar la consulta
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }

        // Asignar el parámetro a la consulta preparada y ejecutar la consulta
        $stmt->bind_param($prepare, $condicion); // Suponiendo que $condicion sea un valor entero (si es una cadena, usa "s" en lugar de "i")
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado de la consulta: " . $stmt->error);
        }

        // Recorrer el resultado y almacenar los datos en $data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Cerrar la consulta preparada
        $stmt->close();

        return $data;
    }

    public function updateDataFun($table, $datas, $condicion, $params)
    {
        $setValues = implode(', ', array_map(function ($key, $value) {
            return "$key=?";
        }, array_keys($datas), array_values($datas)));

        $sql = "UPDATE $table SET $setValues WHERE $condicion=?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            throw new Exception("Error: " . $this->dbConnect->error);
        }

        // Asignar valor a los parámetros
        $types = str_repeat('s', count($datas)) . 's'; // Tipos de datos: 'ss...'
        $bindParams = array_merge([$stmt], [$types]);
        foreach ($datas as &$value) {
            $bindParams[] = &$value;
        }
        $bindParams[] = &$params;
        call_user_func_array('mysqli_stmt_bind_param', $bindParams); // Asignar los valores de los parámetros

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $rows_affected = mysqli_stmt_affected_rows($stmt);

        mysqli_stmt_close($stmt); // Cerrar el statement

        return $rows_affected > 0;
    }

    public function searchCurso($param)
    {
        // Añadir comodines '%' al parámetro de búsqueda
        $param = '%' . $param . '%';

        $sql = "SELECT id, titulo_curso, imagen_curso FROM cursos WHERE titulo_curso LIKE ? AND activo= '1'";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            throw new Exception("Error: " . $this->dbConnect->error);
        }

        // Definir el tipo de dato del parámetro (en este caso, una cadena)
        mysqli_stmt_bind_param($stmt, "s", $param);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }

        // Obtener los resultados como un conjunto de resultados
        $result = mysqli_stmt_get_result($stmt);

        // Obtener los resultados como un array asociativo
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Retornar el resultado
        return $rows;
    }

    public function getCursoFav($id_user)
    {
        $data = array();
        $sql = "SELECT cursos.*, fav.* FROM cursos JOIN fav ON cursos.id = fav.id_curso WHERE fav.id_usuario = ?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }
        $stmt->bind_param("i", $id_user);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado de la consulta:" . $stmt->error);
        }
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function deletedata($tabla, $condicion, $data)
    {
        $sql = "DELETE FROM $tabla WHERE $condicion = ?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->dbConnect->error);
        }
        $stmt->bind_param("i", $data); // Aquí debes usar "i" para representar un entero
        if (!$stmt->execute()) {
            return false;
        }
        $stmt->close();
        return true;
    }
    public function getCursoCompleted($userid)
    {
        $data = array();
        $sql = "SELECT DISTINCT lecciones.* FROM lecciones JOIN enrollments ON enrollments.user_id = ?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta" . $this->dbConnect->error);
        }
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta" . $this->dbConnect->error);
        }
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    public function updateCurso($titulo, $imagen, $instructor, $id)
    {
        $sql = "UPDATE cursos SET titulo_curso=?, imagen_curso=?, id_instructor=? WHERE id=?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error:" . $this->dbConnect->error);
        }
        $stmt->bind_param('ssii', $titulo, $imagen, $instructor, $id); // 'ssii' indica los tipos de datos de los parámetros.

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }
        $rows_affected = $stmt->affected_rows;
        $stmt->close();
        return $rows_affected > 0;
    }
    public function updateLeccion($titulo, $imagen, $instructor, $desc, $id)
    {
        $sql = "UPDATE lecciones SET titulo=?, img_leccion=?, video_url=?,descripcion=? WHERE id_leccion=?";
        $stmt = $this->dbConnect->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error:" . $this->dbConnect->error);
        }
        $stmt->bind_param('ssssi', $titulo, $imagen, $instructor, $desc, $id); // 'ssii' indica los tipos de datos de los parámetros

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }
        $rows_affected = $stmt->affected_rows;
        $stmt->close();
        return $rows_affected > 0;
    }
    public function getlecciones(){
        $sql = "SELECT * FROM lecciones WHERE active =  1 order  by lecciones.orden  ASC";
        $stmt= $this->dbConnect->prepare($sql);
        if(!$stmt){
            throw new Exception( "error: ",  $this->dbConnect->error);
        }
        if(!$stmt->execute()){
            throw new Exception("error al ejecutar consulta" .$stmt->error);
        }
        $rows_affected = $stmt->affected_rows;
        $stmt->close();
        return $rows_affected >0;
    }
    public function getShowEnrrollments($cursoid, $userid){
        $slq = "SELECT * FROM enrollments as l INNER JOIN usuarios as u  INNER JOIN cursos as c ON c.id = l.course_id on l.user_id = u.id WHERE  c.id=? AND l.user_id=?";
    }
}
