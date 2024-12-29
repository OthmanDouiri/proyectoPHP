<?php

// Incluir conexión a la base de datos
require_once '../src/controller/DatabaseController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone_id'])) {
    $phoneId = intval($_POST['phone_id']); // Obtener el ID del teléfono
    $sql = "DELETE FROM phone WHERE id = ?"; 
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $phoneId);
        
        if ($stmt->execute()) {
            // Mostrar mensaje de éxito (opcional)
            echo "<script>alert('Teléfono eliminado exitosamente');</script>";
        } else {
            // Mostrar mensaje de error (opcional)
            echo "<script>alert('Error al eliminar el teléfono');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparando la consulta');</script>";
    }

    // Redirigir al dashboard
    header('Location: /dashboard');
    exit;
} else {
    // Si no se recibe un ID válido
    echo "<script>alert('Solicitud inválida');</script>";
    header('Location: /dashboard');
    exit;
}
