<?php

declare(strict_types=1);

use Presentation\Http\Controllers\ProdutoController;
use Presentation\Http\Controllers\UsuarioController;
use Presentation\Http\Controllers\AuthController;
use Presentation\Http\JwtMiddleware;
use Slim\App;

return function (App $app): void {
    $jwt = new JwtMiddleware();

    $app->group('/api/produtos', function ($group) use ($jwt) {
        $group->get('', [ProdutoController::class, 'index']);
        $group->post('', [ProdutoController::class, 'create'])->add($jwt);
        $group->get('/{id}', [ProdutoController::class, 'show'])->add($jwt);
        $group->put('/{id}', [ProdutoController::class, 'update'])->add($jwt);
        $group->delete('/{id}', [ProdutoController::class, 'delete'])->add($jwt);
    });

    $app->group('/api/usuarios', function ($group) use ($jwt) {
        $group->get('', [UsuarioController::class, 'index'])->add($jwt);
        $group->post('', [UsuarioController::class, 'create'])->add($jwt);
        $group->get('/{id}', [UsuarioController::class, 'show'])->add($jwt);
        $group->put('/{id}', [UsuarioController::class, 'update'])->add($jwt);
        $group->delete('/{id}', [UsuarioController::class, 'delete'])->add($jwt);
    });

    $app->post('/api/auth/login', [AuthController::class, 'login']);
};
