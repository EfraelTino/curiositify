<?php

class Pow
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
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
    public function getLeccionCondicion( $primero, $segundo, $tercerdo){
        $data = array();
        $sql = "SELECT * FROM enrollments WHERE user_id = $primero AND course_id = $segundo AND ultima_leccion_vista_id = $tercerdo";
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

    public function searchCurso($param){
        // Añadir comodines '%' al parámetro de búsqueda
        $param = '%' . $param . '%';
        
        $sql ="SELECT titulo_curso FROM cursos WHERE titulo_curso LIKE ?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {   
            throw new Exception("Error: ". $this->dbConnect->error);
        }
        
        // Definir el tipo de dato del parámetro (en este caso, una cadena)
        mysqli_stmt_bind_param($stmt, "s", $param);
        
        if(!mysqli_stmt_execute($stmt)){
            throw new Exception("Error al ejecutar la consulta". $stmt->error);
        }
    
        // En este punto, debes hacer algo con el resultado del statement
        // Por ejemplo, obtener y procesar los resultados de la consulta
        // Aquí se asume que quieres retornar el resultado de la consulta
        $result = mysqli_stmt_get_result($stmt);
    
        // Obtener los resultados como un array asociativo
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
        // Retornar el resultado
        return $rows;
    }
}
