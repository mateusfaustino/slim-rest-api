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

/**
 * @OA\Tag(name="Usuarios")
 */
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

    /**
     * @OA\Get(path="/api/usuarios", tags={"Usuarios"})
     * @OA\Response(response=200, description="Lista de usuarios")
     */
    public function index(Request $request, Response $response): Response
    {
        $usuarios = $this->listarUsuarios->execute();
        $items = array_map(fn($u) => $u->toArray(), $usuarios);
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Post(path="/api/usuarios", tags={"Usuarios"})
     * @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/Usuario"))
     * @OA\Response(response=201, description="Usuario criado", @OA\JsonContent(ref="#/components/schemas/Usuario"))
     */
    public function create(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $validator = new \Application\Usuario\UsuarioValidator($params);
        if (!$validator->validate()) {
            $response->getBody()->write(json_encode(['errors' => $validator->errors()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $senha = password_hash($params['senha'], PASSWORD_BCRYPT);
        $usuario = $this->criarUsuario->execute($params['login'], $params['email'], $params['nome'], $senha);
        $response->getBody()->write(json_encode($usuario->toArray()));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
    /**
     * @OA\Get(path="/api/usuarios/{id}", tags={"Usuarios"})
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer"))
     * @OA\Response(response=200, description="Usuario")
     * @OA\Response(response=404, description="Não encontrado")
     */

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

    /**
     * @OA\Put(path="/api/usuarios/{id}", tags={"Usuarios"})
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer"))
     * @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/Usuario"))
     * @OA\Response(response=200, description="Usuario atualizado")
     * @OA\Response(response=404, description="Não encontrado")
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $params = (array)$request->getParsedBody();
        $validator = new \Application\Usuario\UsuarioValidator($params);
        if (!$validator->validate()) {
            $response->getBody()->write(json_encode(['errors' => $validator->errors()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $senha = password_hash($params['senha'], PASSWORD_BCRYPT);
        $usuario = $this->atualizarUsuario->execute($id, $params['login'], $params['email'], $params['nome'], $senha);
        if (!$usuario) {
            $response->getBody()->write(json_encode(['message' => 'Usuário não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode($usuario->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Delete(path="/api/usuarios/{id}", tags={"Usuarios"})
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer"))
     * @OA\Response(response=204, description="Excluído")
     * @OA\Response(response=404, description="Não encontrado")
     */
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
