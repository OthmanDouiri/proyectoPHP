<?php
// dashboard.php

// Iniciar la sesión y verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login"); // Redirige al login si no está logueado
    exit();
}

require_once '../src/controller/SessionController.php';

// Verificar si se hizo clic en "Logout"
if (isset($_POST['logout'])) {
    SessionController::logout();
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="assets/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <p>This is your dashboard.</p>

  <!-- Formulario para cerrar sesión -->
  <form method="POST">
      <button type="submit" name="logout" class="btn btn-danger">Logout</button>
  </form>
</div>

<script src="assets/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
