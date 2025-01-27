<?php

/*Esta utilidad se encargará de todas las tareas relacionadas 
con JWT (por ejemplo, generación y validación).*/

namespace App\Utils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTUtils {
// Clave secreta para firmar el token
private static $key = "my_secret_key";



// Generar un token JWT
public static function generateJWt($userId,$username,$role){

 $payload = [
    'iss' => 'proyectophp.local',
    'iat' => time(),
    'exp' => time() + (60 * 60 * 24 * 7), // 7 days
    'userId' => $userId,
    'username' => $username,
    'role' => $role,
 ];

    return JWT::encode($payload, self::$key, 'HS256'); // Codifica el token con la clave secreta

}


public static function validateJWT($token){
    try {
        return JWT::decode($token, new Key(self::$key, 'HS256'));
    } catch (\Exception $e) {
        return null;
    }
}






}