<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('X-Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(.*)/', $authHeader, $matches)) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token no proporcionado o formato incorrecto','status' => 401]);
                
        }
        $token = $matches[1];
        $key = getenv('JWT_SECRET');
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Puedes guardar el usuario en el request si lo deseas
            // $request->user = $decoded;
        } catch (\Exception $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token inválido: ' . $e->getMessage() , 'status' => 401]);
               
        }
        // Si todo está bien, continuar
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       

        return $response;
    }
}
