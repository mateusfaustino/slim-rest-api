<?php
declare(strict_types=1);

namespace Presentation\Http;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

class JwtMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $auth = $request->getHeaderLine('Authorization');
        if (!str_starts_with($auth, 'Bearer ')) {
            return $this->unauthorized();
        }
        $token = substr($auth, 7);
        try {
            JWT::decode($token, new Key($_ENV['JWT_SECRET'] ?? 'secret', 'HS256'));
        } catch (\Throwable $e) {
            return $this->unauthorized();
        }
        return $handler->handle($request);
    }

    private function unauthorized(): Response
    {
        $response = new SlimResponse(401);
        $response->getBody()->write(json_encode(['message' => 'Unauthorized']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
