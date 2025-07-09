<?php

declare(strict_types=1);

use Presentation\Http\Controllers\ProdutoController;
use Slim\App;

return function (App $app): void {
    $app->group('/api/produtos', function ($group) {
        $group->get('', [ProdutoController::class, 'index']);
        $group->post('', [ProdutoController::class, 'create']);
        $group->get('/{id}', [ProdutoController::class, 'show']);
        $group->put('/{id}', [ProdutoController::class, 'update']);
        $group->delete('/{id}', [ProdutoController::class, 'delete']);
    });
};
