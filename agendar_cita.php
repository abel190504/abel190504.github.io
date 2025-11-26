<?php
// 1. Incluimos el archivo de conexión
include 'conexion.php';

// 2. Verificamos que los datos se envíen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Obtenemos los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $plan = $_POST['plan'];

    // 4. Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($telefono) || empty($plan)) {
        echo "Error: Todos los campos son obligatorios.";
    } else {
        
        // 5. Preparamos la consulta SQL
        $sql = "INSERT INTO pacientes (nombre, email, telefono, plan) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // 6. "Atamos" las variables
            $stmt->bind_param("ssss", $nombre, $email, $telefono, $plan);
            
            // 7. Ejecutamos la consulta DENTRO DE UN TRY...CATCH
            try {
                // Intentamos ejecutar
                $stmt->execute();
                
                // Si todo sale bien, redirigimos a la página de éxito
                header("Location: exito.php");
                exit; // ¡Importante! Detener el script aquí.

            } catch (mysqli_sql_exception $e) {
                
                // Si falla, atrapamos la excepción y la analizamos
                // El código 1062 es "Duplicate entry" (Entrada Duplicada)
                if ($e->getCode() == 1062) {
                    
                    // Es un duplicado. Redirigimos a nuestra página de error bonita
                    header("Location: error_duplicado.php");
                    exit; // ¡Importante! Detener el script aquí.
                    
                } else {
                    // Fue otro error de base de datos
                    echo "Error al registrar la cita: " . $e->getMessage();
                }
            }
            
            // 8. Cerramos la sentencia
            $stmt->close();
            
        } else {
            // Si hay un error al preparar la consulta
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }
    
    // 9. Cerramos la conexión a la base de datos
    $conn->close();
    
} else {
    // Si alguien intenta acceder a este archivo .php directamente
    echo "Acceso no permitido.";
}
?>