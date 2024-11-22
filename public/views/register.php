<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../src/controller/SessionController.php';

$message = "";
$messageType = ""; // Define el tipo de mensaje ('success' o 'danger')

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Llamar al método de registro
    $sessionController = new SessionController();
    $result = $sessionController->register($username, $email, $password);

    // Determina el tipo de mensaje según el resultado
    if ($result === "El usuario ya existe") {
        $messageType = "danger";  // Rojo para error
    } else {
        $messageType = "success"; // Verde para éxito
    }
    $message = $result;
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
  <script src="assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="User registration page">
  <meta name="author" content="Your Company Name">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Register</title>
  <link href="assets/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .register-container {
      max-width: 400px;
      width: 100%;
      padding: 2rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .register-title {
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
    <div class="register-container">
      <h1 class="register-title text-center">Register</h1>

      <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> text-center">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group mb-3">
          <label for="inputName" class="form-label">Full Name</label>
          <input type="text" id="inputName" name="username" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="form-group mb-3">
          <label for="inputEmail" class="form-label">Email Address</label>
          <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>
        </div>
        <div class="form-group mb-4">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-primary w-100 btn-lg" type="submit">Register</button>
        <p class="text-center mt-3">
          Already have an account? <a href="login">Login</a>
        </p>
        <p class="text-center mt-4 mb-3 text-muted">&copy; 2021–2024 Othman</p>
      </form>
    </div>
  </div>
  <script src="assets/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
