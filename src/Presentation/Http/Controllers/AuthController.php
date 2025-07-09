<?php
declare(strict_types=1);

namespace Presentation\Http\Controllers;

use Application\Usuario\AutenticarUsuario;
use Application\Usuario\LoginDTO;
use Application\Usuario\LoginValidator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function __construct(private AutenticarUsuario $autenticarUsuario)
    {
    }

    public function login(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        $validator = new LoginValidator($params);
        if (!$validator->validate()) {
            $response->getBody()->write(json_encode(['errors' => $validator->errors()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $loginDTO = LoginDTO::fromArray($params);
        $userId = $this->autenticarUsuario->execute($loginDTO);
        if (!$userId) {
            $response->getBody()->write(json_encode(['message' => 'Credenciais inválidas']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
        $payload = [
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + 3600,
        ];
        $token = JWT::encode($payload, $_ENV['JWT_SECRET'] ?? 'secret', 'HS256');
        $response->getBody()->write(json_encode(['token' => $token]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
