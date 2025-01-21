<?php

/*Create a middleware to protect routes by validating 
the JWT in the auth_token cookie.*/
namespace App\Middleware;

use App\Utils\JWTUtils;

class AuthMiddleware {
    public static function protectRoute($requiredRole = null) {
        if (isset($_COOKIE['token'])) {
            $decoded = JWTUtils::validateJWT($_COOKIE['token']);
            if ($decoded && (!$requiredRole || $decoded->role === $requiredRole)) {
                return $decoded; // User is authorized
            }
        }

        // Unauthorized access
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['error' => 'Access denied']);
        exit();
    }




}
