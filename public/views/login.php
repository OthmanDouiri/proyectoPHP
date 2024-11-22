<?php 
// for errors 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia la sesión
session_start();
require_once '../src/controller/SessionController.php';

// Verifica si el usuario ya está logueado
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard"); // Redirige al dashboard si ya está logueado
    exit();
}

// Maneja el inicio de sesión del usuario
$error = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

// crea una instancia del controllador de sesion 

  $sessionController = new SessionController();
  
  // llama al metodo de inicio de session 

  if ($sessionController->login($username,$password)){
    
  // Obtén el objeto del usuario actual

  $user = (object) [

    'id' => $_SESSION['user_id']

  ];


  // Genera un token para el usuario
  $token = $sessionController->generateToken($user);
    header("Location: dashboard"); // Redirige al dashboard si el inicio de sesión es exitoso
    exit();
  }






}





?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
  <!-- Optional: Script for color theme mode -->
  <script src="assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Secure login page">
  <meta name="author" content="Your Company Name">
  <title>Login</title>

  <!-- Bootstrap CSS -->
  <link href="assets/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Custom styling for a professional look */
    .login-container {
      max-width: 400px;
      width: 100%;
      padding: 2rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .login-title {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      font-weight: 600;
      color: #333;
    }
    .form-control:focus {
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      border-color: #80bdff;
    }
  </style>
</head>

<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-container">
      <h1 class="login-title text-center">Sign In</h1>
      
      <!-- Alert for error message in red -->
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" >
        <div class="form-group mb-3">
          <label for="inputUsername" class="form-label">Username</label>
          <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
        </div>
        <div class="form-group mb-4">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-primary w-100 btn-lg" type="submit">Sign in</button>
        
        <!-- Registration link -->
        <p class="text-center mt-3">
          Don't have an account? <a href="register">Register</a>
        </p>
        
        <p class="text-center mt-4 mb-3 text-muted">&copy; 2021–2024 Othman</p>
      </form>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper.js -->
  <script src="assets/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
