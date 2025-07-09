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
        $query = $request->getQueryParams();
        $page = isset($query['page']) ? max(1, (int)$query['page']) : 1;
        $perPage = isset($query['per_page']) ? max(1, (int)$query['per_page']) : 10;
        $search = $query['search'] ?? null;
        $name = $query['name'] ?? null;
        $minPrice = isset($query['min_price']) ? (float)$query['min_price'] : null;
        $maxPrice = isset($query['max_price']) ? (float)$query['max_price'] : null;

        $result = $this->listarProdutos->execute($page, $perPage, $search, $name, $minPrice, $maxPrice);
        $response->getBody()->write(json_encode($result->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $produto = $this->criarProduto->execute($params['nome'], (float)$params['preco']);
        $response->getBody()->write(json_encode($produto->toArray()));
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
        $response->getBody()->write(json_encode($produto->toArray()));
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
        $response->getBody()->write(json_encode($produto->toArray()));
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
