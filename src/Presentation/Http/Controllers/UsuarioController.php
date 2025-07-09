<?php
declare(strict_types=1);

namespace Presentation\Http\Controllers;

use Application\Usuario\AtualizarUsuario;
use Application\Usuario\BuscarUsuario;
use Application\Usuario\CriarUsuario;
use Application\Usuario\DeletarUsuario;
use Application\Usuario\ListarUsuarios;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioController
{
    public function __construct(
        private CriarUsuario $criarUsuario,
        private ListarUsuarios $listarUsuarios,
        private BuscarUsuario $buscarUsuario,
        private AtualizarUsuario $atualizarUsuario,
        private DeletarUsuario $deletarUsuario
    ) {
    }

    public function index(Request $request, Response $response): Response
    {
        $usuarios = $this->listarUsuarios->execute();
        $items = array_map(fn($u) => $u->toArray(), $usuarios);
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $senha = password_hash($params['senha'], PASSWORD_BCRYPT);
        $usuario = $this->criarUsuario->execute($params['login'], $params['email'], $params['nome'], $senha);
        $response->getBody()->write(json_encode($usuario->toArray()));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $usuario = $this->buscarUsuario->execute($id);
        if (!$usuario) {
            $response->getBody()->write(json_encode(['message' => 'Usuário não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode($usuario->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $params = (array)$request->getParsedBody();
        $senha = password_hash($params['senha'], PASSWORD_BCRYPT);
        $usuario = $this->atualizarUsuario->execute($id, $params['login'], $params['email'], $params['nome'], $senha);
        if (!$usuario) {
            $response->getBody()->write(json_encode(['message' => 'Usuário não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode($usuario->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        if (!$this->deletarUsuario->execute($id)) {
            $response->getBody()->write(json_encode(['message' => 'Usuário não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        return $response->withStatus(204);
    }
}
