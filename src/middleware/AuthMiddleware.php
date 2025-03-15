<?php

/*Create a middleware to protect routes by validating 
the JWT in the auth_token cookie.*/
namespace App\Middleware;

use App\Utils\JWTUtils;

class AuthMiddleware {
    public static function protectRoute($requiredRole = null) {
        // Rutas públicas que no requieren autenticación
        $publicRoutes = ['/api/phones'];  

        $currentRoute = $_SERVER['REQUEST_URI'];

        // Si la ruta es pública, permitir acceso sin validar JWT
        if (in_array($currentRoute, $publicRoutes)) {
            return;
        }

        // Verificar el token en la cookie
        if (isset($_COOKIE['token'])) {
            $decoded = JWTUtils::validateJWT($_COOKIE['token']);
            if ($decoded && (!$requiredRole || $decoded->role === $requiredRole)) {
                return $decoded; // Usuario autorizado
            }
        }

        // Acceso no autorizado
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['error' => 'Access denied']);
        exit();
    }
}
