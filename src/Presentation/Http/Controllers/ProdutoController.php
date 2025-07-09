<?php

declare(strict_types=1);

namespace Presentation\Http\Controllers;

use Application\Produto\AtualizarProduto;
use Application\Produto\BuscarProduto;
use Application\Produto\CriarProduto;
use Application\Produto\DeletarProduto;
use Application\Produto\ListarProdutos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController
{
    public function __construct(
        private CriarProduto $criarProduto,
        private ListarProdutos $listarProdutos,
        private BuscarProduto $buscarProduto,
        private AtualizarProduto $atualizarProduto,
        private DeletarProduto $deletarProduto
    ) {
    }

    public function index(Request $request, Response $response): Response
    {
        $produtos = $this->listarProdutos->execute();
        $data = array_map(fn($p) => [
            'id' => $p->getId(),
            'nome' => $p->getNome(),
            'preco' => $p->getPreco(),
        ], $produtos);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $produto = $this->criarProduto->execute($params['nome'], (float)$params['preco']);
        $data = ['id' => $produto->getId(), 'nome' => $produto->getNome(), 'preco' => $produto->getPreco()];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $produto = $this->buscarProduto->execute($id);
        if (!$produto) {
            $response->getBody()->write(json_encode(['message' => 'Produto não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $data = ['id' => $produto->getId(), 'nome' => $produto->getNome(), 'preco' => $produto->getPreco()];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $params = (array)$request->getParsedBody();
        $produto = $this->atualizarProduto->execute($id, $params['nome'], (float)$params['preco']);
        if (!$produto) {
            $response->getBody()->write(json_encode(['message' => 'Produto não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $data = ['id' => $produto->getId(), 'nome' => $produto->getNome(), 'preco' => $produto->getPreco()];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        if (!$this->deletarProduto->execute($id)) {
            $response->getBody()->write(json_encode(['message' => 'Produto não encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        return $response->withStatus(204);
    }
}
