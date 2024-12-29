<?php

$id = isset($_GET['id']) ? $_GET['id'] : null;

echo $id;

// conect to the database
require_once '../src/controller/DatabaseController.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form>
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="">
        </div>
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript Bundle (Optional for interactive features) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
