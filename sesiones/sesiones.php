<?php
// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar sesión si no se ha hecho
}

// Comprobar si el usuario no está autenticado
if (empty($_SESSION['usuario'])) { 
    // Redirigir al login.php si no hay un usuario en la sesión
    header("Location: ../sesiones/login.php");
    exit();
}

?>
